<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Página - TSM Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.mce.com/1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            language: 'es',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 400
        });
    </script>
</head>
<body>
    <?php 
    $currentPage = 'pages';
    include ROOT_PATH . 'views/admin/includes/header.php'; 
    ?>
    
    <div class="admin-container">
        <?php include ROOT_PATH . 'views/admin/includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Crear Nueva Página</h1>
                <a href="<?= BASE_URL ?>admin/pages" class="btn-secondary">← Volver</a>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>admin/pages/store" method="POST" class="form-card">
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="title">Título *</label>
                        <input type="text" id="title" name="title" required placeholder="Ej: Nuestra Historia">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" id="slug" name="slug" placeholder="ej: nuestra-historia">
                        <small>Dejar vacío para generar automáticamente del título</small>
                    </div>

                    <div class="form-group">
                        <label for="template">Plantilla</label>
                        <select id="template" name="template">
                            <option value="default">Default</option>
                            <option value="home">Home</option>
                            <option value="services">Services</option>
                            <option value="portfolio">Portfolio</option>
                            <option value="contact">Contact</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="meta_description">Meta Descripción (SEO)</label>
                        <textarea id="meta_description" name="meta_description" rows="2" placeholder="Descripción para motores de búsqueda"></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="meta_keywords">Meta Keywords (SEO)</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" placeholder="palabra1, palabra2, palabra3">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="content">Contenido</label>
                        <textarea id="content" name="content" placeholder="Escribe el contenido de la página..."></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_published" checked>
                            Publicar página inmediatamente
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Crear Página</button>
                    <a href="<?= BASE_URL ?>admin/pages" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
