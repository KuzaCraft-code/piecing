<?php

namespace Controllers;

use Core\Controller;
use Core\Database;
use Core\DataHelper; // Importação da Trait para manipulação de dados

class PageController extends Controller
{
    use DataHelper; // Ativando a funcionalidade de carregamento de JSON

    public function about()
    {
        return $this->view('pages/about', ['title' => 'Sobre Nós - Kuzacraft']);
    }

    public function contact()
    {
        // 1. CARREGAMENTO DOS PAÍSES (Usando a Trait para limpeza e performance)
        // O método loadJsonData já cuida do caminho absoluto e do tratamento de erro
        $countries = $this->loadJsonData('countries');

        return $this->view('pages/contact', [
            'title'     => 'Contacto - Kuzacraft',
            'countries' => $countries
        ]);
    }

    /**
     * Processa o formulário de contacto e insere no Funil de Leads
     */
    public function sendContact()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /contact');
            exit;
        }

        // 1. Captura e Saneamento de dados
        $nome     = strip_tags($_POST['nome'] ?? '');
        $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $assunto  = strip_tags($_POST['assunto'] ?? 'Contacto via Website');
        $mensagem = strip_tags($_POST['mensagem'] ?? '');

        // 2. Tratamento do Telemóvel (Padrão E.164 para WhatsApp)
        $ddi = $_POST['ddi'] ?? '+258';
        $numero = preg_replace('/\s+/', '', $_POST['telemovel'] ?? '');
        $telemovel_completo = !empty($numero) ? $ddi . $numero : null;

        // 3. Dados de Auditoria (Padrão ISO)
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        try {
            $db = Database::getConnection();
            
            // Inserção na tabela LEADS (O primeiro estágio do funil da Kuzacraft)
            $sql = "INSERT INTO leads (nome, email, telemovel, origem, status, location, ip_address) 
                    VALUES (:nome, :email, :telemovel, :origem, :status, :location, :ip_address)";

            $stmt = $db->prepare($sql);
            
            $stmt->execute([
                ':nome'       => $nome,
                ':email'      => $email,
                ':telemovel'  => $telemovel_completo,
                ':origem'     => 'contacto',
                ':status'     => 'visitante',
                ':location'   => $assunto,
                ':ip_address' => $ip_address
            ]);

            // Sucesso: Redireciona para o Contacto com Feedback
            header('Location: /contact?success=1');
            exit;

        } catch (\Exception $e) {
            error_log("Erro Crítico Piecing (Lead Capture): " . $e->getMessage());
            header('Location: /contact?error=db');
            exit;
        }
    }
}