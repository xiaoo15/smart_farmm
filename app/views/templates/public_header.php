<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'SmartFarm') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #28a745;
            --dark-green: #218838;
            --light-green: #e6f5ea;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Enhanced Navbar */
        .smartfarm-navbar {
            background-color: white !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            color: var(--primary-green) !important;
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            color: var(--dark-green) !important;
        }
        
        .navbar-brand svg {
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover svg {
            transform: scale(1.1);
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            color: #495057 !important;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-green) !important;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background-color: var(--primary-green);
            border-radius: 2px;
        }
        
        .cart-badge {
            font-size: 0.65rem;
            vertical-align: text-top;
            margin-left: 2px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 8px;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-green);
            color: var(--primary-green);
        }
        
        .dropdown-divider {
            border-color: rgba(0, 0, 0, 0.05);
        }
        
        .btn-login {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
            transform: translateY(-2px);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
        }
        
        @media (max-width: 991.98px) {
            .navbar-collapse {
                padding: 1rem 0;
                background-color: white;
                border-radius: 0 0 10px 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }
            
            .nav-item {
                margin: 0.25rem 0;
            }
            
            .btn-login {
                margin-top: 0.5rem;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg smartfarm-navbar sticky-top">
  <div class="container">
    <a class="navbar-brand" href="index.php?action=home">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-tree-fill me-2" viewBox="0 0 16 16">
            <path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777z"/>
        </svg>
        GrowFarm
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' && (!isset($_GET['action']) || $_GET['action'] == 'home') ? 'active' : '' ?>" href="index.php?action=home">
                <i class="fas fa-home me-1 d-lg-none"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= isset($_GET['action']) && $_GET['action'] == 'showCart' ? 'active' : '' ?>" href="index.php?action=showCart">
                <i class="fas fa-shopping-cart me-1 d-lg-none"></i> Keranjang
                <?php 
                  // Inisialisasi cart count
                  $cart_count = 0;
                  if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                      $cart_count = count($_SESSION['cart']);
                  }
                ?>
                <span class="badge bg-danger cart-badge" style="<?= $cart_count > 0 ? '' : 'display:none;' ?>"><?= $cart_count ?></span>
            </a>
        </li>
        <?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-1 d-lg-none"></i>
                <span>Halo, <?= htmlspecialchars($_SESSION['user']['username']) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="index.php?action=myOrders"><i class="fas fa-history me-2"></i>Riwayat Pesanan</a></li>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <li><a class="dropdown-item" href="admin/index.php?action=dashboard"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              </ul>
            </li>
        <?php else: ?>
            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                <a class="btn btn-success btn-login" href="index.php?action=showLogin">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>