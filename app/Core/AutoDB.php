<?php

namespace Core;

use PDO;
use PDOException;
use Exception;

class AutoDB
{
    public static function initialize(): void
    {
        if (!isset($_ENV['DB_DRIVER'], $_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS'])) {
            return;
        }

        $driver = $_ENV['DB_DRIVER'];
        $host   = $_ENV['DB_HOST'];
        $port   = $_ENV['DB_PORT'] ?? '3306';
        $dbname = $_ENV['DB_NAME'];
        $user   = $_ENV['DB_USER'];
        $pass   = $_ENV['DB_PASS'];

        try {
            // 1. Criação da BD se não existir
            if ($driver !== 'sqlite') {
                $serverDsn = "$driver:host=$host;port=$port;charset=utf8mb4";
                $server = new PDO($serverDsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $server->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            }

            $pdo = Database::getConnection();

            // 2. Tabela de Log de Migrações
            $pdo->exec("CREATE TABLE IF NOT EXISTS system_migrations_log (
                id INT AUTO_INCREMENT PRIMARY KEY,
                file_name VARCHAR(255) UNIQUE NOT NULL,
                executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;");

            // 3. Caminho Atualizado para db/migrations
            $sqlFolder = realpath(__DIR__ . '/../../db/migrations');

            if ($sqlFolder && is_dir($sqlFolder)) {
                $files = glob($sqlFolder . '/*.sql');
                if ($files) {
                    sort($files);
                    foreach ($files as $file) {
                        $filename = basename($file);
                        $stmt = $pdo->prepare("SELECT 1 FROM system_migrations_log WHERE file_name = ?");
                        $stmt->execute([$filename]);

                        if ($stmt->rowCount() === 0) {
                            $pdo->exec(file_get_contents($file));
                            $pdo->prepare("INSERT INTO system_migrations_log (file_name) VALUES (?)")->execute([$filename]);
                        }
                    }
                }
            }

            // 4. Admin Mestre Alinhado
            // No teu AutoDB.php:
            if ($pdo->query("SELECT COUNT(*) FROM staff_users")->fetchColumn() == 0) {
                $senhaAdmin = password_hash('piecing.com', PASSWORD_ARGON2ID);
                $pdo->prepare("INSERT INTO staff_users (nome, email, pass, role, status) VALUES (?, ?, ?, ?, ?)")
                    ->execute(['JLB-101 (CEO)', 'admin@piecing.com', $senhaAdmin, 'admin', 'active']);
            }
        } catch (Exception $e) {
            error_log("Erro AutoDB: " . $e->getMessage());
        }
    }
}
