<?php
/**
 * Controlador de Páginas (Admin)
 */

require_once ROOT_PATH . 'models/PageModel.php';
require_once ROOT_PATH . 'models/UserModel.php';

class PageController {
    private $pageModel;
    private $userModel;

    public function __construct() {
        $this->pageModel = new PageModel();
        $this->userModel = new UserModel();
    }

    // Listar todas las páginas
    public function index() {
        $pages = $this->pageModel->getAll('created_at', 'DESC');
        require_once ROOT_PATH . 'views/admin/pages/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        require_once ROOT_PATH . 'views/admin/pages/create.php';
    }

    // Guardar nueva página
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => cleanData($_POST['title']),
                'slug' => $this->generateSlug($_POST['slug'] ?? $_POST['title']),
                'meta_description' => cleanData($_POST['meta_description'] ?? ''),
                'meta_keywords' => cleanData($_POST['meta_keywords'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'template' => $_POST['template'] ?? 'default',
                'is_published' => isset($_POST['is_published']) ? 1 : 0,
                'author_id' => $_SESSION['user_id']
            ];

            // Validaciones
            if (empty($data['title'])) {
                $_SESSION['error'] = 'El título es requerido';
                redirect('admin/pages/create');
                return;
            }

            if ($this->pageModel->insert($data)) {
                $pageId = $this->pageModel->getBySlug($data['slug'])['id'];
                
                // Guardar secciones si existen
                if (isset($_POST['sections']) && is_array($_POST['sections'])) {
                    $this->pageModel->saveSections($pageId, $_POST['sections']);
                }

                $this->userModel->logActivity($_SESSION['user_id'], 'CREATE', 'pages', $pageId, "Página creada: {$data['title']}");
                $_SESSION['success'] = 'Página creada exitosamente';
                redirect('admin/pages');
            } else {
                $_SESSION['error'] = 'Error al crear la página';
                redirect('admin/pages/create');
            }
        }
    }

    // Mostrar formulario de edición
    public function edit($id) {
        $page = $this->pageModel->getById($id);
        
        if (!$page) {
            $_SESSION['error'] = 'Página no encontrada';
            redirect('admin/pages');
            return;
        }

        $sections = $this->pageModel->getPageSections($id);
        require_once ROOT_PATH . 'views/admin/pages/edit.php';
    }

    // Actualizar página
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $page = $this->pageModel->getById($id);
            
            if (!$page) {
                $_SESSION['error'] = 'Página no encontrada';
                redirect('admin/pages');
                return;
            }

            $data = [
                'title' => cleanData($_POST['title']),
                'slug' => $this->generateSlug($_POST['slug'] ?? $_POST['title']),
                'meta_description' => cleanData($_POST['meta_description'] ?? ''),
                'meta_keywords' => cleanData($_POST['meta_keywords'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'template' => $_POST['template'] ?? 'default',
                'is_published' => isset($_POST['is_published']) ? 1 : 0
            ];

            if (empty($data['title'])) {
                $_SESSION['error'] = 'El título es requerido';
                redirect("admin/pages/edit/{$id}");
                return;
            }

            if ($this->pageModel->update($id, $data)) {
                // Actualizar secciones
                if (isset($_POST['sections']) && is_array($_POST['sections'])) {
                    $this->pageModel->saveSections($id, $_POST['sections']);
                }

                $this->userModel->logActivity($_SESSION['user_id'], 'UPDATE', 'pages', $id, "Página actualizada: {$data['title']}");
                $_SESSION['success'] = 'Página actualizada exitosamente';
                redirect('admin/pages');
            } else {
                $_SESSION['error'] = 'Error al actualizar la página';
                redirect("admin/pages/edit/{$id}");
            }
        }
    }

    // Eliminar página
    public function delete($id) {
        $page = $this->pageModel->getById($id);
        
        if ($page) {
            if ($this->pageModel->delete($id)) {
                $this->userModel->logActivity($_SESSION['user_id'], 'DELETE', 'pages', $id, "Página eliminada: {$page['title']}");
                $_SESSION['success'] = 'Página eliminada exitosamente';
            } else {
                $_SESSION['error'] = 'Error al eliminar la página';
            }
        } else {
            $_SESSION['error'] = 'Página no encontrada';
        }
        
        redirect('admin/pages');
    }

    // Generar slug único
    private function generateSlug($text, $id = null) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
        
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $existingPage = $this->pageModel->getBySlug($slug);
            
            if (!$existingPage || ($id && $existingPage['id'] == $id)) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}
