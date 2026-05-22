<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Páginas - TSM Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
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
                <h1>Gestión de Páginas</h1>
                <a href="<?= BASE_URL ?>admin/pages/create" class="btn-primary">+ Nueva Página</a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="content-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Slug</th>
                            <th>Plantilla</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pages)): ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">No hay páginas creadas</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pages as $page): ?>
                                <tr>
                                    <td><?= $page['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($page['title']) ?></strong></td>
                                    <td><code><?= htmlspecialchars($page['slug']) ?></code></td>
                                    <td><?= htmlspecialchars($page['template']) ?></td>
                                    <td>
                                        <?php if ($page['is_published']): ?>
                                            <span class="badge badge-success">Publicada</span>
                                        <?php else: ?>
                                            <span class="badge badge-draft">Borrador</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($page['created_at'])) ?></td>
                                    <td class="actions">
                                        <a href="<?= BASE_URL ?>admin/pages/edit/<?= $page['id'] ?>" class="btn-action btn-edit" title="Editar">✏️</a>
                                        <a href="<?= BASE_URL ?>page/<?= $page['slug'] ?>" target="_blank" class="btn-action btn-view" title="Ver">👁️</a>
                                        <form action="<?= BASE_URL ?>admin/pages/delete/<?= $page['id'] ?>" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar esta página?');">
                                            <button type="submit" class="btn-action btn-delete" title="Eliminar">🗑️</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
