<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TSM Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body>
    <?php include ROOT_PATH . 'views/admin/includes/header.php'; ?>
    
    <div class="admin-container">
        <?php include ROOT_PATH . 'views/admin/includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Dashboard</h1>
                <p>Bienvenido al panel de administración de TSM</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <!-- Estadísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📄</div>
                    <div class="stat-info">
                        <h3><?= $stats['total_pages'] ?></h3>
                        <p>Total de Páginas</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-info">
                        <h3><?= $stats['published_pages'] ?></h3>
                        <p>Páginas Publicadas</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👤</div>
                    <div class="stat-info">
                        <h3><?= $stats['total_users'] ?></h3>
                        <p>Usuarios</p>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="content-card">
                <h2>Actividad Reciente</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentActivity)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">No hay actividad reciente</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentActivity as $activity): ?>
                                <tr>
                                    <td><?= htmlspecialchars($activity['username'] ?? 'Sistema') ?></td>
                                    <td><span class="badge badge-<?= strtolower($activity['action']) ?>"><?= htmlspecialchars($activity['action']) ?></span></td>
                                    <td><?= htmlspecialchars($activity['description'] ?? '-') ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></td>
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
