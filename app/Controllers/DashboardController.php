<?php

namespace Controllers;

use Core\Controller;
use Core\Database;

class DashboardController extends Controller
{
    /**
     * Exibe o ecrã principal do Painel Admin
     */
    public function index()
    {
        // 1. CORREÇÃO DE SEGURANÇA: Validar contra a chave correta da sessão
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login?error=acesso_negado');
            exit;
        }

        $db = Database::getConnection();

        

        // 2. CAPTURA DE DADOS (Puxando da nova tabela 'leads' e 'catalog')
        // Total de Leads (Newsletter + Contactos)
        $totalLeads = $db->query("SELECT COUNT(*) FROM leads")->fetchColumn();
        $leadsNovas = $db->query("SELECT COUNT(*) FROM leads WHERE status = 'visitante'")->fetchColumn();

        // Total de Produtos/Serviços no Catálogo
        $totalCatalogo = $db->query("SELECT COUNT(*) FROM catalog")->fetchColumn();

        // Puxa as últimas 5 Leads para a tabela
        $stmt = $db->query("SELECT * FROM leads ORDER BY created_at DESC LIMIT 5");
        $ultimasLeads = $stmt->fetchAll();

        return $this->view('dashboard/index', [
            'title'          => 'Painel de Controlo - Kuzacraft',
            'totalLeads'     => $totalLeads,
            'leadsNovas'     => $leadsNovas,
            'totalCatalogo'  => $totalCatalogo,
            'ultimasLeads'   => $ultimasLeads,
            'user_name'      => $_SESSION['user_name'] ?? 'Membro Staff'
        ]);
    }
    public function uploadSql()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['sql_file'])) {
            $file = $_FILES['sql_file'];

            if ($file['error'] === UPLOAD_ERR_OK) {
                $sql = file_get_contents($file['tmp_name']);
                $db = \Core\Database::getConnection();

                try {
                    // Executa o conteúdo do SQL
                    $db->exec($sql);

                    // Regista no log para o AutoDB saber que já foi feito
                    $stmt = $db->prepare("INSERT INTO system_migrations_log (file_name) VALUES (?)");
                    $stmt->execute(['manual_upload_' . time() . '_' . $file['name']]);

                    header('Location: /dashboard?success=sql_executado');
                } catch (\PDOException $e) {
                    die("Erro ao executar SQL: " . $e->getMessage());
                }
            }
        }
    }

    public function promoteLead()
    {
        $leadId = $_POST['lead_id'] ?? null;

        if (!$leadId) {
            header('Location: /dashboard?error=lead_nao_encontrada');
            exit;
        }

        $db = \Core\Database::getConnection();

        // 1. Puxar os dados da Lead
        $stmt = $db->prepare("SELECT * FROM leads WHERE id = ? LIMIT 1");
        $stmt->execute([$leadId]);
        $lead = $stmt->fetch();

        if ($lead) {
            try {
                $db->beginTransaction();

                // 2. Gerar senha padrão para o primeiro acesso
                $tempPass = password_hash('kuzacraft2026', PASSWORD_ARGON2ID);

                // 3. Criar o Cliente na tabela 'customers'
                $ins = $db->prepare("INSERT INTO customers (lead_id, nome, email, pass, phone, location, pass_status) VALUES (?, ?, ?, ?, ?, ?, '@reset')");
                $ins->execute([
                    $lead['id'],
                    $lead['nome'] ?? 'Cliente Nexora',
                    $lead['email'],
                    $tempPass,
                    $lead['telemovel'],
                    $lead['location'],
                ]);

                // 4. Atualizar o status da Lead para 'convertido'
                $upd = $db->prepare("UPDATE leads SET status = 'convertido' WHERE id = ?");
                $upd->execute([$leadId]);

                $db->commit();
                header('Location: /dashboard?success=lead_convertida');
            } catch (\Exception $e) {
                $db->rollBack();
                die("Erro na conversão: " . $e->getMessage());
            }
        }
    }

    public function updateCms()
    {
        $slug    = $_POST['section_slug'] ?? '';
        $title   = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $btnText = $_POST['button_text'] ?? '';
        $btnLink = $_POST['button_link'] ?? '';

        $db = \Core\Database::getConnection();

        try {
            $stmt = $db->prepare("
            UPDATE cms_sections 
            SET title = ?, content = ?, button_text = ?, button_link = ?, updated_at = NOW() 
            WHERE section_slug = ?
        ");
            $stmt->execute([$title, $content, $btnText, $btnLink, $slug]);

            header('Location: /dashboard?success=cms_updated');
        } catch (\Exception $e) {
            header('Location: /dashboard?error=cms_failed');
        }
    }

    public function addPartner()
{
    if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
        header('Location: /dashboard?error=upload_falhou');
        exit;
    }

    $name = $_POST['partner_name'] ?? 'Parceiro';
    $uploadDir = 'public/assets/img/logos/';
    
    // Gerar nome único para o ficheiro
    $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
    $filename = bin2hex(random_bytes(8)) . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
        $db = \Core\Database::getConnection();
        $stmt = $db->prepare("INSERT INTO partners (name, image_path) VALUES (?, ?)");
        $stmt->execute([$name, '/assets/img/logos/' . $filename]);

        header('Location: /dashboard?success=partner_added');
    } else {
        header('Location: /dashboard?error=save_failed');
    }
}
}
