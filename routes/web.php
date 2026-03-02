<?php

use Controllers\HomeController;
use Controllers\PageController;
use Controllers\AuthController;
use Controllers\ServiceController;
use Controllers\PaymentController;
use Controllers\DashboardController;

/** * Roteamento do Framework Piecing
 * Foco: Saneamento de dados e carregamento de JSON
 */

// Home e Páginas Institucionais
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/contact', [PageController::class, 'contact']);

// Processamento de Formulário (Lead Capture)
// Corrigido para usar a classe importada consistentemente
$router->post('/contact/send', [PageController::class, 'sendContact']);

// Área Administrativa (Dashboard)
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->post('/dashboard/promote-lead', [DashboardController::class, 'promoteLead']);

// Dinâmico (LMS, Gestão, etc)
$router->get('/servico/{slug}', [ServiceController::class, 'show']);

// Autenticação
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Redefinição de Senha
$router->get('/password-reset-required', [AuthController::class, 'showPasswordReset']);
$router->post('/password-update', [AuthController::class, 'updatePassword']);

// Pagamentos Integrados
$router->post('/pagamento/mpesa', [PaymentController::class, 'process']);