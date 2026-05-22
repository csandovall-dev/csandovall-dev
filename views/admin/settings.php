<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - TSM Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body>
    <?php 
    $currentPage = 'settings';
    include ROOT_PATH . 'views/admin/includes/header.php'; 
    ?>
    
    <div class="admin-container">
        <?php include ROOT_PATH . 'views/admin/includes/sidebar.php'; ?>
        
        <main class="admin-content">
            <div class="page-header">
                <h1>Configuración del Sitio</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>admin/settings" method="POST" enctype="multipart/form-data" class="form-card">
                <h2>Información General</h2>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="setting_site_title">Título del Sitio</label>
                        <input type="text" id="setting_site_title" name="setting_site_title" value="<?= htmlspecialchars($settings['site_title'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="setting_site_description">Descripción del Sitio</label>
                        <textarea id="setting_site_description" name="setting_site_description" rows="3"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
                    </div>
                </div>

                <h2>Imágenes</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="setting_site_logo">Logo del Sitio</label>
                        <input type="file" id="setting_site_logo" name="setting_site_logo" accept="image/*">
                        <?php if (!empty($settings['site_logo'])): ?>
                            <div style="margin-top: 10px;">
                                <img src="<?= BASE_URL . $settings['site_logo'] ?>" alt="Logo actual" style="max-height: 50px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="setting_site_favicon">Favicon</label>
                        <input type="file" id="setting_site_favicon" name="setting_site_favicon" accept="image/*">
                        <?php if (!empty($settings['site_favicon'])): ?>
                            <div style="margin-top: 10px;">
                                <img src="<?= BASE_URL . $settings['site_favicon'] ?>" alt="Favicon actual" style="max-height: 32px;">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <h2>Información de Contacto</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="setting_contact_email">Email de Contacto</label>
                        <input type="email" id="setting_contact_email" name="setting_contact_email" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="setting_contact_phone">Teléfono</label>
                        <input type="text" id="setting_contact_phone" name="setting_contact_phone" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="setting_contact_address">Dirección</label>
                        <textarea id="setting_contact_address" name="setting_contact_address" rows="2"><?= htmlspecialchars($settings['contact_address'] ?? '') ?></textarea>
                    </div>
                </div>

                <h2>Redes Sociales</h2>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="setting_social_facebook">Facebook URL</label>
                        <input type="url" id="setting_social_facebook" name="setting_social_facebook" value="<?= htmlspecialchars($settings['social_facebook'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="setting_social_twitter">Twitter URL</label>
                        <input type="url" id="setting_social_twitter" name="setting_social_twitter" value="<?= htmlspecialchars($settings['social_twitter'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="setting_social_instagram">Instagram URL</label>
                        <input type="url" id="setting_social_instagram" name="setting_social_instagram" value="<?= htmlspecialchars($settings['social_instagram'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="setting_social_linkedin">LinkedIn URL</label>
                        <input type="url" id="setting_social_linkedin" name="setting_social_linkedin" value="<?= htmlspecialchars($settings['social_linkedin'] ?? '') ?>">
                    </div>
                </div>

                <h2>Otros</h2>
                
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="setting_google_analytics">Código de Google Analytics</label>
                        <textarea id="setting_google_analytics" name="setting_google_analytics" rows="3" placeholder="G-XXXXXXXXXX o código completo"><?= htmlspecialchars($settings['google_analytics'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="setting_maintenance_mode" value="1" <?= ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' ?>>
                            Activar modo mantenimiento
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Guardar Configuración</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
