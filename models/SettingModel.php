<?php
/**
 * Modelo de Configuración del Sitio
 */

require_once ROOT_PATH . 'models/Model.php';

class SettingModel extends Model {
    protected $table = 'settings';

    // Obtener un valor de configuración por clave
    public function get($key) {
        $stmt = $this->pdo->prepare("SELECT setting_value FROM {$this->table} WHERE setting_key = ?");
        $stmt->execute([$key]);
        $result = $stmt->fetch();
        return $result ? $result['setting_value'] : null;
    }

    // Actualizar un valor de configuración
    public function set($key, $value) {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET setting_value = ? WHERE setting_key = ?");
        return $stmt->execute([$value, $key]);
    }

    // Obtener todas las configuraciones como array asociativo
    public function getAllSettings() {
        $stmt = $this->pdo->query("SELECT setting_key, setting_value FROM {$this->table}");
        $results = $stmt->fetchAll();
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }
}
