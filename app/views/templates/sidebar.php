<nav class="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-leaf icon me-2"></i>
        <h3>SmartFarm</h3>
    </div>

    <ul class="list-unstyled components">
        <p>Menu Utama</p>
        <li class="<?= ($action == 'dashboard') ? 'active' : '' ?>">
            <a href="index.php?action=dashboard"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        </li>
        <li class="<?= ($action == 'products') ? 'active' : '' ?>">
            <a href="index.php?action=products"><i class="fas fa-box-open me-2"></i> Manajemen Produk</a>
        </li>
        <li class="<?= ($action == 'pos') ? 'active' : '' ?>">
            <a href="index.php?action=pos"><i class="fas fa-cash-register me-2"></i> Sistem Kasir (POS)</a>
        </li>
        <li class="<?= ($action == 'reports') ? 'active' : '' ?>">
            <a href="index.php?action=reports"><i class="fas fa-chart-line me-2"></i> Laporan</a>
        </li>
    </ul>

    <ul class="list-unstyled CTAs">
        <div class="px-3">
             <hr>
             <strong><?= $_SESSION['user']['username'] ?? 'Admin' ?></strong><br>
             <a href="index.php?action=logout" class="btn btn-sm btn-outline-danger mt-2 w-100">Logout</a>
        </div>
    </ul>
</nav>