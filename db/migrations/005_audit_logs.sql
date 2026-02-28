CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,          -- Quem fez (referência a staff_users)
    user_name VARCHAR(100),    -- Nome para histórico rápido
    action VARCHAR(255),       -- O que fez
    target VARCHAR(100),       -- Ex: 'cms', 'leads', 'services'
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES staff_users(id) ON DELETE SET NULL
) ENGINE=InnoDB;