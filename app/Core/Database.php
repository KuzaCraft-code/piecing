<?php

namespace Core;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // 1. Verificação Estrita (Fail-Fast): Garante que as variáveis existem no .env
        if (!isset($_ENV['DB_DRIVER'], $_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS'])) {
            throw new Exception("❌ Erro Crítico Piecing: As credenciais da Base de Dados não foram encontradas no ficheiro .env.");
        }

        // 2. Captação Exclusiva e Direta do .env (Sem valores padrão '??')
        $driver  = $_ENV['DB_DRIVER'];
        $host    = $_ENV['DB_HOST'];
        $port    = $_ENV['DB_PORT'];
        $db      = $_ENV['DB_NAME'];
        $user    = $_ENV['DB_USER'];
        $pass    = $_ENV['DB_PASS'];
        $charset = 'utf8mb4';

        // 3. Suporte para SQLite (Testes rápidos) ou MySQL/PgSQL (Produção)
        if ($driver === 'sqlite') {
            $dsn = "sqlite:" . __DIR__ . "/../../storage/database.sqlite";
        } else {
            // Inclui a porta dinamicamente
            $dsn = "$driver:host=$host;port=$port;dbname=$db;charset=$charset";
        }

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException("Erro de Conexão à BD: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getConnection()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }

    /**
     * Método de Inserção com Criptografia Automática AES-256
     * Útil para Softwares de Gestão e Dados Sensíveis
     */
    public static function insert($table, $data)
    {
        $db = self::getConnection();

        // Camada de segurança bancária Kuzacraft
        $protectedData = AutoEncrypt::handle($data, true);

        $keys = implode(', ', array_keys($protectedData));
        $placeholders = ':' . implode(', :', array_keys($protectedData));

        $sql = "INSERT INTO $table ($keys) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        return $stmt->execute($protectedData);
    }
}