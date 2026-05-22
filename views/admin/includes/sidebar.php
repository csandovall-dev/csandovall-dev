<aside class="admin-sidebar">
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>admin/dashboard" class="nav-item <?= ($currentPage ?? '') == 'dashboard' ? 'active' : '' ?>">
            <span class="nav-icon">📊</span>
            <span>Dashboard</span>
        </a>

        <a href="<?= BASE_URL ?>admin/pages" class="nav-item <?= ($currentPage ?? '') == 'pages' ? 'active' : '' ?>">
            <span class="nav-icon">📄</span>
            <span>Páginas</span>
        </a>

        <a href="<?= BASE_URL ?>admin/services" class="nav-item <?= ($currentPage ?? '') == 'services' ? 'active' : '' ?>">
            <span class="nav-icon">🛠️</span>
            <span>Servicios</span>
        </a>

        <a href="<?= BASE_URL ?>admin/portfolio" class="nav-item <?= ($currentPage ?? '') == 'portfolio' ? 'active' : '' ?>">
            <span class="nav-icon">💼</span>
            <span>Portafolio</span>
        </a>

        <a href="<?= BASE_URL ?>admin/testimonials" class="nav-item <?= ($currentPage ?? '') == 'testimonials' ? 'active' : '' ?>">
            <span class="nav-icon">💬</span>
            <span>Testimonios</span>
        </a>

        <a href="<?= BASE_URL ?>admin/team" class="nav-item <?= ($currentPage ?? '') == 'team' ? 'active' : '' ?>">
            <span class="nav-icon">👥</span>
            <span>Equipo</span>
        </a>

        <a href="<?= BASE_URL ?>admin/galleries" class="nav-item <?= ($currentPage ?? '') == 'galleries' ? 'active' : '' ?>">
            <span class="nav-icon">🖼️</span>
            <span>Galerías</span>
        </a>

        <a href="<?= BASE_URL ?>admin/contacts" class="nav-item <?= ($currentPage ?? '') == 'contacts' ? 'active' : '' ?>">
            <span class="nav-icon">📧</span>
            <span>Contactos</span>
        </a>

        <div class="nav-divider"></div>

        <a href="<?= BASE_URL ?>admin/settings" class="nav-item <?= ($currentPage ?? '') == 'settings' ? 'active' : '' ?>">
            <span class="nav-icon">⚙️</span>
            <span>Configuración</span>
        </a>
    </nav>
</aside>

<style>
    .admin-sidebar {
        width: 250px;
        background: white;
        box-shadow: 2px 0 4px rgba(0,0,0,0.1);
        padding: 20px 0;
        overflow-y: auto;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        transition: all 0.3s;
        border-left: 3px solid transparent;
    }

    .nav-item:hover {
        background: #f5f5f5;
        border-left-color: #667eea;
    }

    .nav-item.active {
        background: #e8eaff;
        border-left-color: #667eea;
        color: #667eea;
        font-weight: 600;
    }

    .nav-icon {
        font-size: 18px;
    }

    .nav-divider {
        height: 1px;
        background: #e0e0e0;
        margin: 10px 20px;
    }
</style>
