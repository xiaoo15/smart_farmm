<?php global $action; ?>
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="index.php?action=dashboard">
            <i class="fas fa-leaf me-2"></i>
            <span>SmartFarm</span>
        </a>
    </div>

    <div class="sidebar-menu">
        <p class="menu-header">Main Menu</p>
        <ul class="list-unstyled components">
            <li class="<?= ($action == 'dashboard') ? 'active' : '' ?>">
                <a href="index.php?action=dashboard"><i class="fas fa-home fa-fw me-3"></i>Home</a>
            </li>
            <li class="<?= in_array($action, ['orders', 'products', 'customers']) ? 'active' : '' ?>">
                <a href="#performanceSubmenu" data-bs-toggle="collapse" aria-expanded="<?= in_array($action, ['orders', 'products', 'customers']) ? 'true' : 'false' ?>" class="dropdown-toggle">
                    <i class="fas fa-chart-pie fa-fw me-3"></i>Performances
                </a>
                <ul class="collapse list-unstyled <?= in_array($action, ['orders', 'products', 'customers']) ? 'show' : '' ?>" id="performanceSubmenu">
                    <li><a href="index.php?action=orders">Order</a></li>
                    <li><a href="index.php?action=products">Product</a></li>
                    <li><a href="index.php?action=customers">Customer</a></li>
                </ul>
            </li>
            <li>
                <a href="index.php?action=chat"><i class="fas fa-envelope fa-fw me-3"></i>Message <span class="badge bg-danger ms-auto">2</span></a>
            </li>
        </ul>

        <p class="menu-header">Step-up</p>
        <ul class="list-unstyled components">
            <li><a href="#"><i class="fas fa-bullhorn fa-fw me-3"></i>Promotion</a></li>
            <li class="<?= ($action == 'reports') ? 'active' : '' ?>"><a href="index.php?action=reports"><i class="fas fa-file-invoice-dollar fa-fw me-3"></i>Finance</a></li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile-block">
            <img src="https://github.com/mdo.png" alt="User Avatar" class="user-avatar">
            <div class="user-info">
                <span class="user-name"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Admin') ?></span>
                <span class="user-role"><?= htmlspecialchars($_SESSION['user']['role'] ?? 'Admin') ?></span>
            </div>
            <a href="index.php?action=logout" class="logout-icon ms-auto" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</nav>