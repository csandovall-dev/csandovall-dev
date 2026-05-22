<?php
/**
 * Controlador del Panel de Administración (Dashboard)
 */

require_once ROOT_PATH . 'models/UserModel.php';
require_once ROOT_PATH . 'models/PageModel.php';
require_once ROOT_PATH . 'models/SettingModel.php';

class DashboardController {
    private $userModel;
    private $pageModel;
    private $settingModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->pageModel = new PageModel();
        $this->settingModel = new SettingModel();
    }

    // Mostrar dashboard
    public function index() {
        // Estadísticas
        $stats = [
            'total_pages' => $this->pageModel->count(),
            'published_pages' => $this->pageModel->count('is_published = 1'),
            'total_users' => $this->userModel->count(),
        ];

        // Actividad reciente
        $stmt = $this->userModel->pdo->query("
            SELECT al.*, u.username 
            FROM activity_log al 
            LEFT JOIN users u ON al.user_id = u.id 
            ORDER BY al.created_at DESC 
            LIMIT 10
        ");
        $recentActivity = $stmt->fetchAll();

        require_once ROOT_PATH . 'views/admin/dashboard.php';
    }

    // Configuración del sitio
    public function settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'setting_') === 0) {
                    $settingKey = str_replace('setting_', '', $key);
                    $this->settingModel->set($settingKey, $value);
                }
            }

            // Manejo de uploads de imágenes
            if (isset($_FILES['setting_site_logo']) && $_FILES['setting_site_logo']['error'] === UPLOAD_ERR_OK) {
                $logoPath = $this->uploadImage($_FILES['setting_site_logo'], 'logos');
                if ($logoPath) {
                    $this->settingModel->set('site_logo', $logoPath);
                }
            }

            if (isset($_FILES['setting_site_favicon']) && $_FILES['setting_site_favicon']['error'] === UPLOAD_ERR_OK) {
                $faviconPath = $this->uploadImage($_FILES['setting_site_favicon'], 'favicons');
                if ($faviconPath) {
                    $this->settingModel->set('site_favicon', $faviconPath);
                }
            }

            $this->userModel->logActivity($_SESSION['user_id'], 'UPDATE', 'settings', null, 'Configuración del sitio actualizada');
            $_SESSION['success'] = 'Configuración guardada exitosamente';
            redirect('admin/settings');
        }

        $settings = $this->settingModel->getAllSettings();
        require_once ROOT_PATH . 'views/admin/settings.php';
    }

    // Subir imagen
    private function uploadImage($file, $subdir = '') {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $maxSize = MAX_UPLOAD_SIZE;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExtensions)) {
            $_SESSION['error'] = 'Extensión de archivo no permitida';
            return false;
        }

        if ($file['size'] > $maxSize) {
            $_SESSION['error'] = 'El archivo excede el tamaño máximo permitido';
            return false;
        }

        $uploadDir = UPLOAD_DIR . ($subdir ? $subdir . '/' : '');
        
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = uniqid() . '_' . time() . '.' . $ext;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return 'uploads/' . ($subdir ? $subdir . '/' : '') . $filename;
        }

        return false;
    }
}
