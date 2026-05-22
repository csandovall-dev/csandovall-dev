<header class="admin-header">
    <div class="header-left">
        <h2>TSM Admin</h2>
    </div>
    <div class="header-right">
        <div class="user-info">
            <span>👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        </div>
        <a href="<?= BASE_URL ?>admin/logout" class="btn-logout">Cerrar Sesión</a>
    </div>
</header>

<style>
    .admin-header {
        background: white;
        padding: 15px 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left h2 {
        color: #667eea;
        margin: 0;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .user-info {
        color: #333;
        font-weight: 500;
    }

    .btn-logout {
        padding: 8px 16px;
        background: #f44336;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        transition: background 0.3s;
    }

    .btn-logout:hover {
        background: #d32f2f;
    }
</style>
