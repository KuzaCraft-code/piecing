<?php
namespace Core;

use Exception;

class AutoEncrypt {
    private static $method = 'aes-256-gcm';
    
    // Campos que a base de dados vai encriptar/desencriptar automaticamente
    private static $sensitiveFields = ['bi_nr', 'telemovel', 'senha_api', 'token_pagamento'];

    /**
     * Captura e prepara a chave do .env de forma inteligente.
     * O dev não precisa de comandos de terminal, o Piecing trata de tudo.
     */
    private static function getKey() {
        if (!isset($_ENV['APP_KEY'])) {
            throw new Exception("❌ Erro de Segurança Piecing: APP_KEY não configurada no .env");
        }

        $key = $_ENV['APP_KEY'];
        
        // Se a chave vier com o nosso prefixo "base64:", limpamos
        if (strpos($key, 'base64:') === 0) {
            $key = base64_decode(substr($key, 7));
        }

        // O AES-256 EXIGE uma chave de exatamente 32 bytes. 
        // Ao usarmos hash('sha256', true), garantimos que qualquer palavra-passe que 
        // o dev coloque no .env seja transformada numa chave de 32 bytes perfeita, sem erros fatais.
        return hash('sha256', $key, true);
    }

    /**
     * Interceta os arrays da Base de Dados (Usado no Database::insert)
     */
    public static function handle(array $data, bool $isEncrypting = true) {
        $key = self::getKey();
        
        foreach ($data as $keyName => $value) {
            // Só encripta se o campo estiver na lista e não estiver vazio
            if (in_array($keyName, self::$sensitiveFields) && !empty($value)) {
                $data[$keyName] = $isEncrypting ? self::encryptString($value, $key) : self::decryptString($value, $key);
            }
        }
        return $data;
    }

    /**
     * Encripta uma string (Substitui a tua antiga classe Security)
     */
    public static function encryptString($value, $key = null) {
        $key = $key ?? self::getKey();
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::$method));
        $tag = ""; 
        
        $ciphertext = openssl_encrypt($value, self::$method, $key, OPENSSL_RAW_DATA, $iv, $tag);
        return base64_encode($iv . $tag . $ciphertext);
    }

    /**
     * Desencripta uma string (Falha de forma elegante se o dado não for encriptado)
     */
    public static function decryptString($cipherText, $key = null) {
        $key = $key ?? self::getKey();
        $data = base64_decode($cipherText);
        $ivLen = openssl_cipher_iv_length(self::$method);
        
        // Se o dado na BD não for um hash válido (ex: o dev guardou em texto limpo antes), retorna o original
        if (strlen($data) < $ivLen + 16) {
            return $cipherText; 
        }

        $iv = substr($data, 0, $ivLen);
        $tag = substr($data, $ivLen, 16);
        $ciphertext = substr($data, $ivLen + 16);
        
        $decrypted = openssl_decrypt($ciphertext, self::$method, $key, OPENSSL_RAW_DATA, $iv, $tag);
        
        // Se a chave mudar e não conseguir desencriptar, não rebenta o site, devolve o que está lá
        return $decrypted !== false ? $decrypted : $cipherText;
    }
}