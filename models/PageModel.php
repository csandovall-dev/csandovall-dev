<?php
/**
 * Modelo de Página
 */

require_once ROOT_PATH . 'models/Model.php';

class PageModel extends Model {
    protected $table = 'pages';

    // Obtener página por slug
    public function getBySlug($slug) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND is_published = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    // Obtener todas las páginas publicadas
    public function getPublished() {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE is_published = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    // Obtener secciones de una página
    public function getPageSections($pageId) {
        $stmt = $this->pdo->prepare("SELECT * FROM sections WHERE page_id = ? AND is_active = 1 ORDER BY order_index ASC");
        $stmt->execute([$pageId]);
        return $stmt->fetchAll();
    }

    // Guardar secciones de una página
    public function saveSections($pageId, $sections) {
        // Eliminar secciones existentes
        $deleteStmt = $this->pdo->prepare("DELETE FROM sections WHERE page_id = ?");
        $deleteStmt->execute([$pageId]);

        // Insertar nuevas secciones
        $insertStmt = $this->pdo->prepare("INSERT INTO sections (page_id, title, section_type, content, image_url, order_index, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($sections as $index => $section) {
            $insertStmt->execute([
                $pageId,
                $section['title'] ?? null,
                $section['type'] ?? 'text',
                $section['content'] ?? null,
                $section['image_url'] ?? null,
                $index,
                true
            ]);
        }

        return true;
    }
}
