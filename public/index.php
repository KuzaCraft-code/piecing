<?php
/**
 * PIECING FRAMEWORK - Ponto de Entrada Único
 * Kuzacraft | Agência de TI - Beira, MZ
 */

// 1. Alta Performance: Inicia o buffer de saída (RAM) e Sessão
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Padrões ISO e Localização
date_default_timezone_set('Africa/Maputo'); 
setlocale(LC_ALL, 'pt_MZ.UTF-8');

// 3. Autoload & Variáveis de Ambiente
require_once __DIR__ . '/../vendor/autoload.php';

// Carrega o .env (Necessário para o Database e para o Auto-Instalador)
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// --- SISTEMA DE INSTALAÇÃO ÚNICA (ZERO DB OVERHEAD) ---
$installLock = __DIR__ . '/../storage/installed.lock';

if (!file_exists($installLock)) {
    // Só entra aqui UMA VEZ na vida do projeto
    \Core\AutoDB::initialize();

    // Garante que a pasta storage existe e cria o selo de trava
    if (!is_dir(__DIR__ . '/../storage')) {
        mkdir(__DIR__ . '/../storage', 0777, true);
    }
    file_put_contents($installLock, "Instalado em: " . date('Y-m-d H:i:s'));
}
// --- FIM DO AUTO-INSTALL ---

use Core\Router;

// 4. Roteamento e Despacho
$router = new Router();
require_once __DIR__ . '/../routes/web.php';

$router->dispatch();

// 5. Despeja o HTML final de uma só vez para o navegador (Ultra Performance)
ob_end_flush();