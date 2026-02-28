<?php

namespace Controllers;

use Core\Controller;
use Core\Database;

class AuthController extends Controller
{
    /**
     * Exibe a página de login (Detecta se é admin ou cliente pela URL ou parâmetro)
     */
    public function showLogin()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }

        return $this->view('auth/login', [
            'title' => 'Kuzacraft - Login'
        ]);
    }

    /**
     * Processa a autenticação (Lógica Bifurcada)
     */
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $pass  = $_POST['password'] ?? '';

        $db = Database::getConnection();

        // 1. TENTATIVA 1: Verificar se é Staff (Admin/Employee)
        $stmt = $db->prepare("SELECT id, nome, pass, role, status, pass_status FROM staff_users WHERE email = ? AND status = 'active' LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        $table = 'staff';

        // 2. TENTATIVA 2: Se não for staff, verificar se é Cliente (Customer)
        if (!$user) {
            $stmt = $db->prepare("SELECT id, nome, pass, 'customer' as role, status, pass_status FROM customers WHERE email = ? AND status = 'active' LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            $table = 'customer';
        }

        // 3. Validação de Senha Argon2id
        if ($user && password_verify($pass, $user['pass'])) {

            // Verificação de Estado de Senha (@reset exige troca de senha)
            if ($user['pass_status'] === '@reset') {
                $_SESSION['temp_user_id'] = $user['id'];
                header('Location: /password-reset-required');
                exit;
            }

            // Iniciar Sessão Segura
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['nome'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_type'] = $table; // Para sabermos se é staff ou cliente

            // Auditoria de Login
            $targetTable = ($table === 'staff') ? 'staff_users' : 'customers';
            $db->prepare("UPDATE $targetTable SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

            // Redirecionamento Inteligente
            $redirect = ($table === 'staff') ? '/dashboard' : '/my-account';
            header("Location: $redirect");
            exit;
        } else {
            header('Location: /login?error=invalido');
            exit;
        }
    }

    /**
     * Exibe formulário de troca de senha obrigatória
     */
    public function showPasswordReset()
    {
        // Verifica se há um ID temporário na sessão para evitar acesso direto à URL
        if (!isset($_SESSION['temp_user_id'])) {
            header('Location: /login');
            exit;
        }
        return $this->view('auth/1fOauth_reset', ['title' => 'New Credentials Required - by 2FOauth - Kuzacraft']);
    }

    /**
     * Processa a nova senha e muda o status para '1F' (ou 'ok')
     */
    public function updatePassword()
    {
        $newPass = $_POST['new_password'] ?? '';
        $userId  = $_SESSION['temp_user_id'] ?? null;

        if ($userId && !empty($newPass)) {
            $hash = password_hash($newPass, PASSWORD_ARGON2ID);
            $db = \Core\Database::getConnection();

            // Atualiza pass_status para '1F' (Primeiro Fator concluído)
            $stmt = $db->prepare("UPDATE staff_users SET pass = ?, pass_status = '1F' WHERE id = ?");
            $stmt->execute([$hash, $userId]);

            // Login oficial do utilizador
            $_SESSION['user_id'] = $userId;
            // Puxamos o nome para a sessão se necessário
            $stmtName = $db->prepare("SELECT nome, role FROM staff_users WHERE id = ?");
            $stmtName->execute([$userId]);
            $u = $stmtName->fetch();

            $_SESSION['user_name'] = $u['nome'];
            $_SESSION['user_role'] = $u['role'];
            $_SESSION['user_type'] = 'staff';

            unset($_SESSION['temp_user_id']);

            header('Location: /dashboard?success=welcome');
            exit;
        }
        header('Location: /login?error=reset_failed');
        exit;
    }
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /login?logout=success');
        exit;
    }
}
