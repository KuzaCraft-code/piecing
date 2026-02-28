<?php

use Controllers\HomeController;
use Controllers\PageController;
use Controllers\AuthController;
use Controllers\ServiceController;
use Controllers\PaymentController;
use Controllers\DashboardController;

// ... (tuas rotas anteriores) ...

// Rotas da Área Administrativa (Dashboard)
$router->get('/dashboard', [DashboardController::class, 'index']);


// Home e Páginas Simples
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [PageController::class, 'about']);
$router->get('/contact', [PageController::class, 'contact']);
$router->post('/contact/send', [Controllers\PageController::class, 'sendContact']);
// Dinâmico (LMS, Gestão, etc)
$router->get('/servico/{slug}', [ServiceController::class, 'show']);

// Autenticação
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);


// Rotas de Reset Obrigatório (Corrigidas)
$router->get('/password-reset-required', [AuthController::class, 'showPasswordReset']);
$router->post('/password-update', [AuthController::class, 'updatePassword']);

// Rotas de Promoção de Leads (Dashboard)
$router->post('/dashboard/promote-lead', [DashboardController::class, 'promoteLead']);
// Pagamentos
$router->post('/pagamento/mpesa', [PaymentController::class, 'process']);
