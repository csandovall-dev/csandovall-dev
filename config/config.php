<?php
/**
 * Configuración General de la Aplicación
 */

// Ruta base del proyecto
define('BASE_URL', 'http://localhost/TSM/');
define('ROOT_PATH', dirname(__DIR__) . '/');

// Configuración de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS

// Tiempo de expiración de sesión (30 minutos)
ini_set('session.gc_maxlifetime', 1800);
ini_set('session.cookie_lifetime', 1800);

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de uploads
define('UPLOAD_DIR', ROOT_PATH . 'uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Función para redireccionar
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

// Función para verificar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin';
}

// Función para limpiar datos
function cleanData($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
