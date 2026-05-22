<?php
/**
 * TSM - Enrutador Principal
 * Maneja todas las solicitudes de la aplicación
 */

session_start();

// Cargar configuración
require_once 'config/config.php';
require_once 'config/database.php';

// Autocarga de controladores y modelos
spl_autoload_register(function ($class) {
    $controllerPath = ROOT_PATH . 'controllers/' . $class . '.php';
    $modelPath = ROOT_PATH . 'models/' . $class . '.php';
    
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        return;
    }
    
    if (file_exists($modelPath)) {
        require_once $modelPath;
        return;
    }
});

// Obtener URL y limpiarla
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseUrl = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

if ($baseUrl !== '/') {
    $requestUri = str_replace($baseUrl, '', $requestUri);
}

$requestUri = trim($requestUri, '/');
$parts = explode('/', $requestUri);

// Segmentos de la URL
$segment1 = $parts[0] ?? '';
$segment2 = $parts[1] ?? '';
$segment3 = $parts[2] ?? '';

// Enrutamiento
try {
    // Rutas de Administración
    if ($segment1 === 'admin') {
        // Verificar autenticación (excepto para login)
        if ($segment2 !== 'login' && $segment2 !== '') {
            if (!isLoggedIn()) {
                redirect('admin/login');
            }
        }

        switch ($segment2) {
            case '':
            case 'dashboard':
                $controller = new DashboardController();
                $controller->index();
                break;

            case 'login':
                $controller = new AuthController();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->login();
                } else {
                    $controller->showLogin();
                }
                break;

            case 'logout':
                $controller = new AuthController();
                $controller->logout();
                break;

            case 'pages':
                $controller = new PageController();
                
                switch ($segment3) {
                    case '':
                    case 'index':
                        $controller->index();
                        break;
                    
                    case 'create':
                        $controller->create();
                        break;
                    
                    case 'store':
                        $controller->store();
                        break;
                    
                    case 'edit':
                        $id = $parts[3] ?? null;
                        if ($id && is_numeric($id)) {
                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $controller->update($id);
                            } else {
                                $controller->edit($id);
                            }
                        } else {
                            redirect('admin/pages');
                        }
                        break;
                    
                    case 'update':
                        $id = $parts[3] ?? null;
                        if ($id && is_numeric($id) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                            $controller->update($id);
                        } else {
                            redirect('admin/pages');
                        }
                        break;
                    
                    case 'delete':
                        $id = $parts[3] ?? null;
                        if ($id && is_numeric($id)) {
                            $controller->delete($id);
                        } else {
                            redirect('admin/pages');
                        }
                        break;
                    
                    default:
                        redirect('admin/pages');
                }
                break;

            case 'settings':
                $controller = new DashboardController();
                $controller->settings();
                break;

            default:
                // Aquí se agregarían más rutas para services, portfolio, etc.
                redirect('admin/dashboard');
        }
    }
    // Rutas Públicas
    elseif ($segment1 === 'page') {
        // Mostrar página pública por slug
        $slug = $segment2 ?? 'inicio';
        
        require_once ROOT_PATH . 'models/PageModel.php';
        require_once ROOT_PATH . 'models/SettingModel.php';
        
        $pageModel = new PageModel();
        $page = $pageModel->getBySlug($slug);
        
        if ($page) {
            // Vista pública de la página (por desarrollar)
            echo "<h1>" . htmlspecialchars($page['title']) . "</h1>";
            echo $page['content'];
        } else {
            http_response_code(404);
            echo "<h1>Página no encontrada</h1>";
        }
    }
    // Página de Inicio por defecto
    elseif ($segment1 === '' || $segment1 === 'index.php') {
        // Redirigir a una página de inicio o mostrar welcome
        echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>TSM - Bienvenido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .welcome {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            text-align: center;
        }
        h1 { color: #667eea; margin-bottom: 20px; }
        p { color: #666; margin-bottom: 30px; }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class='welcome'>
        <h1>Bienvenido a TSM</h1>
        <p>Sistema de Gestión de Contenidos Web</p>
        <a href='admin/login' class='btn'>Ir al Panel de Administración</a>
    </div>
</body>
</html>";
    }
    // 404 para rutas no encontradas
    else {
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
    }

} catch (Exception $e) {
    // Manejo de errores
    error_log($e->getMessage());
    echo "<h1>Error del Sistema</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
