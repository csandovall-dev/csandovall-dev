<?php
/**
 * Modelo de Usuario
 */

require_once ROOT_PATH . 'models/Model.php';

class UserModel extends Model {
    protected $table = 'users';

    // Verificar credenciales de login
    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = ? AND is_active = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Actualizar último login
            $updateStmt = $this->pdo->prepare("UPDATE {$this->table} SET last_login = NOW() WHERE id = ?");
            $updateStmt->execute([$user['id']]);
            
            return $user;
        }

        return false;
    }

    // Obtener usuario por email
    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    // Obtener usuario por username
    public function getByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Hash de contraseña
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Registrar log de actividad
    public function logActivity($userId, $action, $tableName = null, $recordId = null, $description = null) {
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        $stmt = $this->pdo->prepare("INSERT INTO activity_log (user_id, action, table_name, record_id, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $action, $tableName, $recordId, $description, $ipAddress, $userAgent]);
    }
}
