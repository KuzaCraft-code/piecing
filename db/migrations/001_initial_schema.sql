-- 1. TABELA DE STAFF (Gestão Interna)
CREATE TABLE IF NOT EXISTS staff_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_worker INT(10) NULL, -- ID interno da Kuzacraft
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(255), -- VARCHAR(255) para suportar encriptação AES
    cell_whatsapp VARCHAR(255) NULL,
    location VARCHAR(255) NULL,
   pass VARCHAR(255) NOT NULL,
    pass2factor VARCHAR(255) NULL,
    pass_status ENUM('1F', '2F', '@reset') DEFAULT '@reset',
    pass_reset_token VARCHAR(255) NULL,
    role ENUM('admin', 'employee', 'editor', 'seller') DEFAULT 'employee',
    status ENUM('active', 'inactive') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. FASE 1: O Visitante/Interessado (Leads)
CREATE TABLE IF NOT EXISTS leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NULL,
    telemovel VARCHAR(255) NULL, -- Encriptado
    origem ENUM('newsletter', 'contacto', 'blog', 'catalogo') NOT NULL,
    status ENUM('visitante', 'interesado', 'interrado', 'convertido') DEFAULT 'visitante',
    location VARCHAR(255) NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. FASE 2: O Cliente Convertido (Customers)
-- Isolado do Staff por segurança
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lead_id INT NULL, 
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    location VARCHAR(255) NULL,
    pass VARCHAR(255) NOT NULL,
    pass2factor VARCHAR(255) NULL,
    pass_status ENUM('@reset', '@2factor', 'ok') DEFAULT '@reset',
    phone VARCHAR(255) NULL,
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE SET NULL
) ENGINE=InnoDB;



-- 3. PRODUTOS E SERVIÇOS (Inspirado em E-commerce Globais)
-- TABELA DE CATÁLOGO PROFISSIONAL (ISO-8601 Compliance)
CREATE TABLE IF NOT EXISTS catalog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- numero de referência único para cada item, seguindo o formato ISO-8601 (ex: 2024-06-001) que pode virar codigo de barras ou QR code mas gerado automaticamente
    reference_code VARCHAR(20) UNIQUE NOT NULL,
    type ENUM('product', 'service', 'subscription') DEFAULT 'product',
    brand VARCHAR(100), -- Ex: Apple, Crucial, Kuzacraft
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    sku VARCHAR(50) UNIQUE, -- Stock Keeping Unit (Referência única)
    
    -- PREÇOS E CONDIÇÕES
    base_price DECIMAL(15, 2) NOT NULL,
    discount_percent INT DEFAULT 0, -- Ex: -13% (Estilo Amazon)
    currency VARCHAR(3) DEFAULT 'MZN',
    
    -- CONTEÚDO DINÂMICO (CMS)
    description TEXT,
    specifications JSON, -- Armazena RAM, CPU, Portas como ["RAM":"8GB", "CPU":"i5"]
    features_list TEXT, -- Bullet points (Estilo Microsoft 365)
    
    -- LOGÍSTICA E CTA
    stock_quantity INT DEFAULT 0, --
    cta_label VARCHAR(50) DEFAULT 'comprar', -- 'comprar', 'assinar', 'adicionar'
    status ENUM('active', 'out_of_stock', 'hidden', 'archived') DEFAULT 'active',
    
    -- MEDIA
    thumbnail VARCHAR(255),
    gallery JSON, -- Array de caminhos para as imagens laterais
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. CONTEÚDO E BLOG (CMS)
-- 1. TABELA DE BLOG (Conteúdo que atrai o Visitante)
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL, -- Ex: /blog/como-usar-o-nexora
    summary TEXT, -- O resumo que aparece nos 3 cards da Home
    content LONGTEXT, -- O texto completo
    category VARCHAR(50), -- Educação, TI, Business
    featured_image VARCHAR(255),
    views_count INT DEFAULT 0, -- Para saberes o que os visitantes mais gostam
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    location VARCHAR(255) NULL, -- Para saber de onde vem o autor (ex: Maputo, Lisboa)
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES staff_users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 2. TABELA DE COMENTÁRIOS (Interação e Captação)
-- Aqui é onde um visitante anónimo pode deixar o nome/email e virar Lead!
CREATE TABLE IF NOT EXISTS post_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NULL, -- ID do autor do comentário (se logado)
    user_type ENUM('staff', 'customer') NULL, -- Para saber de qual tabela vem o ID
    author_name VARCHAR(100), -- Para anónimos
    cell_whatsapp VARCHAR(255) NULL, -- Para anónimos (Lead!)
    location VARCHAR(255) NULL, -- Para anónimos (Lead!)
    author_email VARCHAR(100), -- Para anónimos (Lead!)
    comment TEXT NOT NULL,
    status ENUM('pending', 'approved', 'spam') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. TABELA DE COMPONENTES CMS
CREATE TABLE IF NOT EXISTS cms_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_slug VARCHAR(50) UNIQUE NOT NULL, -- 'hero', 'metrics', 'resume'
    title VARCHAR(255),
    subtitle TEXT,
    content TEXT,
    image_path VARCHAR(255),
    button_text VARCHAR(50),
    button_link VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;