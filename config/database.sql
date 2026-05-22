-- ========================================
-- ESTRUCTURA DE BASE DE DATOS - TSM
-- ========================================

CREATE DATABASE IF NOT EXISTS tsm_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tsm_db;

-- ========================================
-- TABLA: users (Usuarios del sistema)
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: pages (Páginas dinámicas)
-- ========================================
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    meta_description TEXT,
    meta_keywords TEXT,
    content LONGTEXT,
    template VARCHAR(100) DEFAULT 'default',
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at TIMESTAMP NULL,
    author_id INT,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: sections (Secciones dentro de páginas)
-- ========================================
CREATE TABLE IF NOT EXISTS sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    title VARCHAR(200),
    section_type ENUM('text', 'image', 'gallery', 'video', 'form', 'custom') DEFAULT 'text',
    content LONGTEXT,
    image_url VARCHAR(500),
    order_index INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: galleries (Galerías de imágenes)
-- ========================================
CREATE TABLE IF NOT EXISTS galleries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    description TEXT,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: gallery_images (Imágenes de galerías)
-- ========================================
CREATE TABLE IF NOT EXISTS gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gallery_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    alt_text VARCHAR(200),
    caption TEXT,
    order_index INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (gallery_id) REFERENCES galleries(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: services (Servicios)
-- ========================================
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    short_description TEXT,
    description LONGTEXT,
    icon VARCHAR(100),
    image_url VARCHAR(500),
    is_featured BOOLEAN DEFAULT FALSE,
    order_index INT DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: portfolio (Portafolio/Proyectos)
-- ========================================
CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    short_description TEXT,
    description LONGTEXT,
    client_name VARCHAR(200),
    project_date DATE,
    category VARCHAR(100),
    image_url VARCHAR(500),
    gallery_images JSON,
    project_url VARCHAR(500),
    technologies_used TEXT,
    is_featured BOOLEAN DEFAULT FALSE,
    order_index INT DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: testimonials (Testimonios)
-- ========================================
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(200) NOT NULL,
    client_position VARCHAR(200),
    client_company VARCHAR(200),
    client_image VARCHAR(500),
    testimonial_text TEXT NOT NULL,
    rating INT DEFAULT 5,
    is_published BOOLEAN DEFAULT FALSE,
    order_index INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: team_members (Miembros del equipo)
-- ========================================
CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(200) NOT NULL,
    position VARCHAR(200),
    biography TEXT,
    image_url VARCHAR(500),
    email VARCHAR(100),
    phone VARCHAR(20),
    linkedin_url VARCHAR(500),
    twitter_url VARCHAR(500),
    is_featured BOOLEAN DEFAULT FALSE,
    order_index INT DEFAULT 0,
    is_published BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: contacts (Mensajes de contacto)
-- ========================================
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: settings (Configuración del sitio)
-- ========================================
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'textarea', 'boolean', 'number', 'image', 'json') DEFAULT 'text',
    description VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABLA: activity_log (Registro de actividad)
-- ========================================
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(100),
    record_id INT,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- INSERTAR USUARIO ADMIN POR DEFECTO
-- Usuario: admin
-- Clave: tsm_2026
-- ========================================
INSERT INTO users (username, email, password, role, is_active) 
VALUES (
    'admin', 
    'admin@tsm.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin', 
    TRUE
);

-- ========================================
-- INSERTAR CONFIGURACIONES BÁSICAS DEL SITIO
-- ========================================
INSERT INTO settings (setting_key, setting_value, setting_type, description) VALUES
('site_title', 'TSM - Tu Sitio Web', 'text', 'Título principal del sitio'),
('site_description', 'Bienvenido a TSM', 'textarea', 'Descripción del sitio'),
('site_logo', '', 'image', 'Logo del sitio'),
('site_favicon', '', 'image', 'Favicon del sitio'),
('contact_email', 'info@tsm.com', 'text', 'Email de contacto'),
('contact_phone', '+57 300 000 0000', 'text', 'Teléfono de contacto'),
('contact_address', 'Dirección principal', 'textarea', 'Dirección física'),
('social_facebook', '', 'text', 'URL de Facebook'),
('social_twitter', '', 'text', 'URL de Twitter'),
('social_instagram', '', 'text', 'URL de Instagram'),
('social_linkedin', '', 'text', 'URL de LinkedIn'),
('google_analytics', '', 'textarea', 'Código de Google Analytics'),
('maintenance_mode', '0', 'boolean', 'Modo mantenimiento activado/desactivado');

-- ========================================
-- INSERTAR PÁGINAS POR DEFECTO
-- ========================================
INSERT INTO pages (title, slug, meta_description, content, template, is_published, author_id) VALUES
('Inicio', 'inicio', 'Página de inicio de TSM', '<h1>Bienvenido a TSM</h1><p>Este es el contenido de la página de inicio.</p>', 'home', TRUE, 1),
('Nosotros', 'nosotros', 'Conoce más sobre TSM', '<h1>Sobre Nosotros</h1><p>Información sobre nuestra empresa.</p>', 'default', TRUE, 1),
('Servicios', 'servicios', 'Nuestros servicios profesionales', '<h1>Nuestros Servicios</h1><p>Descubre lo que podemos hacer por ti.</p>', 'services', TRUE, 1),
('Portafolio', 'portafolio', 'Nuestros proyectos realizados', '<h1>Portafolio</h1><p>Explora nuestros trabajos.</p>', 'portfolio', TRUE, 1),
('Contacto', 'contacto', 'Contáctanos', '<h1>Contacto</h1><p>Ponte en contacto con nosotros.</p>', 'contact', TRUE, 1);

-- ========================================
-- ÍNDICES ADICIONALES PARA MEJORAR RENDIMIENTO
-- ========================================
CREATE INDEX idx_pages_slug ON pages(slug);
CREATE INDEX idx_pages_published ON pages(is_published);
CREATE INDEX idx_sections_page_id ON sections(page_id);
CREATE INDEX idx_services_published ON services(is_published);
CREATE INDEX idx_portfolio_published ON portfolio(is_published);
CREATE INDEX idx_testimonials_published ON testimonials(is_published);
CREATE INDEX idx_team_published ON team_members(is_published);
CREATE INDEX idx_contacts_read ON contacts(is_read);
CREATE INDEX idx_activity_user ON activity_log(user_id);
CREATE INDEX idx_activity_created ON activity_log(created_at);
