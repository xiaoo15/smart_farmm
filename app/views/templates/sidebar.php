<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; min-height: 100vh;">
    <a href="index.php?action=dashboard" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-tree-fill me-2" viewBox="0 0 16 16">
            <path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777z"/>
        </svg>
        <span class="fs-4">SmartFarm</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php?action=dashboard" class="nav-link text-white <?= ($action == 'dashboard') ? 'active' : '' ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="index.php?action=pos" class="nav-link text-white <?= ($action == 'pos') ? 'active' : '' ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
                Sistem Kasir (POS)
            </a>
        </li>
        <li>
            <a href="index.php?action=products" class="nav-link text-white <?= ($action == 'products') ? 'active' : '' ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                Manajemen Produk
            </a>
        </li>
        <li>
            <a href="index.php?action=reports" class="nav-link text-white <?= ($action == 'reports') ? 'active' : '' ?>">
                <svg class="bi me-2" width="16" height="16"><use xlink:href="#collection"/></svg>
                Laporan Penjualan
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?= $_SESSION['user']['username'] ?? 'Admin' ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="index.php?action=logout">Sign out</a></li>
        </ul>
    </div>
</div>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="speedometer2" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.54l1.41-1.41a.389.389 0 0 0-.029-.527zM4.938 8.541a.91.91 0 1 1-1.3-1.229.39.39 0 0 0-.028.527l1.41 1.41a.91.91 0 0 0 1.229-1.287l-1.41-1.41a.389.389 0 0 0-.527.02z"/></symbol>
  <symbol id="table" viewBox="0 0 16 16"><path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm5 0v3h4V4h-4z"/></symbol>
  <symbol id="collection" viewBox="0 0 16 16"><path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/></symbol>
  <symbol id="grid" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 9.5A1.5 1.5 0 0 1 2.5 8h3A1.5 1.5 0 0 1 7 9.5v3A1.5 1.5 0 0 1 5.5 14h-3A1.5 1.5 0 0 1 1 12.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM9.5 1A1.5 1.5 0 0 1 11 2.5v3A1.5 1.5 0 0 1 9.5 7h-3A1.5 1.5 0 0 1 5 5.5v-3A1.5 1.5 0 0 1 6.5 1h3zM11 2a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3zM8.5 9.5A1.5 1.5 0 0 1 10 8h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 7 12.5v-3A1.5 1.5 0 0 1 8.5 9.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/></symbol>
</svg>