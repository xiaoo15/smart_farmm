<div class="offcanvas-md offcanvas-start sidebar sidebar-offcanvas" tabindex="-1" id="sidebarAdmin">
    <div class="sidebar-header">
        <a class="navbar-brand d-flex align-items-center" href="index.php?action=dashboard">
            <i class="fas fa-leaf me-2" style="color: var(--primary-green);"></i>
            <span>SmartFarm</span>
        </a>
    </div>

    <div class="offcanvas-body d-flex flex-column p-3">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php?action=dashboard" class="nav-link <?= ($action == 'dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?action=orders" class="nav-link <?= ($action == 'orders') ? 'active' : '' ?>">
                    <i class="fas fa-receipt fa-fw me-2"></i> Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?action=products" class="nav-link <?= ($action == 'products') ? 'active' : '' ?>">
                    <i class="fas fa-box-open fa-fw me-2"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?action=customers" class="nav-link <?= ($action == 'customers') ? 'active' : '' ?>">
                    <i class="fas fa-users fa-fw me-2"></i> Pelanggan
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?action=reports" class="nav-link <?= ($action == 'reports') ? 'active' : '' ?>">
                    <i class="fas fa-chart-line fa-fw me-2"></i> Laporan
                </a>
            </li>
        </ul>
        <hr>
        <div class="sidebar-footer">
            <div class="d-flex align-items-center">
                <img src="https://github.com/mdo.png" alt="Admin" width="40" height="40" class="rounded-circle me-2">
                <div>
                    <strong class="d-block text-white"><?= $_SESSION['user']['username'] ?? 'Admin' ?></strong>
                    <a href="index.php?action=logout" class="text-danger small">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>