<?php
/**
 * Controlador de Autenticación
 */

require_once ROOT_PATH . 'models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Mostrar formulario de login
    public function showLogin() {
        if (isLoggedIn()) {
            redirect('admin/dashboard');
        }
        
        require_once ROOT_PATH . 'views/admin/login.php';
    }

    // Procesar login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = cleanData($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Usuario y contraseña son requeridos';
                redirect('admin/login');
                return;
            }

            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Iniciar sesión
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                // Registrar actividad
                $this->userModel->logActivity($user['id'], 'LOGIN', 'users', $user['id'], 'Inicio de sesión');

                redirect('admin/dashboard');
            } else {
                $_SESSION['error'] = 'Credenciales incorrectas';
                redirect('admin/login');
            }
        }
    }

    // Cerrar sesión
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $this->userModel->logActivity($userId, 'LOGOUT', 'users', $userId, 'Cierre de sesión');
        }

        session_destroy();
        redirect('admin/login');
    }

    // Verificar si está logueado (middleware)
    public function checkAuth() {
        if (!isLoggedIn()) {
            redirect('admin/login');
        }
    }
}
