<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'SmartFarm') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #90EE90;
            /* Hijau Muda */
            --dark-primary-green: #7CFC00;
            /* Hijau Muda Lebih Gelap untuk Hover */
            --text-color: #333;
            --white: #fff;
            --light-grey: #f2f2f2;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-grey);
            color: var(--text-color);
        }

        .top-bar {
            background-color: var(--primary-green);
            color: var(--text-color);
            padding: 0.5rem 0;
            font-size: 0.8rem;
        }

        .top-bar a {
            color: var(--text-color);
            text-decoration: none;
            margin: 0 0.5rem;
            white-space: nowrap;
        }

        .top-bar a:hover {
            text-decoration: underline;
        }

        .top-bar .top-bar-left,
        .top-bar .top-bar-right {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .main-header {
            background-color: var(--white);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--dark-primary-green) !important;
            text-decoration: none !important;
        }

        .search-form {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            display: flex;
        }

        .search-form input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 0.7rem;
            font-size: 0.9rem;
        }

        .search-form button {
            background-color: var(--primary-green);
            color: var(--text-color);
            border: none;
            padding: 0.7rem 1.2rem;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: var(--dark-primary-green);
        }

        .search-suggestions {
            font-size: 0.7rem;
            color: #666;
            margin-top: 0.5rem;
            white-space: nowrap;
            overflow-x: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .search-suggestions::-webkit-scrollbar {
            display: none;
        }

        .search-suggestions a {
            color: #666;
            text-decoration: none;
            margin: 0 0.3rem;
        }

        .header-icons {
            display: flex;
            align-items: center;
        }

        .header-icons a {
            color: var(--text-color);
            font-size: 1.5rem;
            margin-left: 1.5rem;
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 0.7rem;
            padding: 3px 6px;
            border-radius: 50%;
        }

        /* ============================================= */
        /* CSS BARU UNTUK DROPDOWN ON HOVER              */
        /* ============================================= */
        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown .dropdown-menu {
            display: none;
            /* Sembunyikan secara default */
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
            min-width: 200px;
            /* Lebar minimum dropdown */
        }

        /* Tampilkan dropdown saat parent di-hover */
        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 0.75rem;
            color: #6c757d;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--dark-primary-green);
        }

        .dropdown-item:hover i {
            color: var(--dark-primary-green);
        }

        @media (max-width: 991.98px) {
            .main-header .row>div {
                margin-bottom: 1rem;
            }

            .main-header .col-md-3,
            .main-header .col-md-6,
            .main-header .col-md-3 {
                width: 100%;
                text-align: center;
            }

            .header-icons {
                justify-content: center;
            }

            .search-suggestions {
                display: none;
            }

            /* Di mobile, hover tidak berfungsi, jadi kita andalkan klik */
            .profile-dropdown:hover .dropdown-menu {
                display: none;
            }

            .profile-dropdown.show .dropdown-menu {
                display: block;
            }
        }

        @media (max-width: 767.98px) {
            .top-bar {
                font-size: 0.75rem;
            }

            .top-bar-left {
                justify-content: center;
                margin-bottom: 0.5rem;
                width: 100%;
            }

            .top-bar-right {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <div class="top-bar-left">
                <a href="#">Seller Centre</a>|
                <a href="#">Download</a>|
                <span class="ms-2">Ikuti Kami di</span>
                <a href="#" class="ms-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="ms-1"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="top-bar-right">
                <a href="#"><i class="fas fa-bell"></i> Notifikasi</a>
                <a href="#"><i class="fas fa-question-circle"></i> Bantuan</a>
                <?php if (isset($_SESSION['user'])): ?>
                <?php else: ?>
                    <a href="index.php?action=showRegister">Daftar</a>|
                    <a href="index.php?action=showLogin" class="fw-bold">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-3 text-center text-lg-start">
                    <a class="navbar-brand" href="index.php?action=home">
                        <i class="fas fa-leaf me-1"></i>SmartFarm
                    </a>
                </div>
                <div class="col-12 col-lg-6">
                    <form class="search-form" action="index.php" method="GET">
                        <input type="hidden" name="action" value="search">
                        <input class="form-control" type="search" name="q" placeholder="Cari di SmartFarm" required>
                        <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="search-suggestions d-none d-lg-block">
                        <a href="#">Bibit Cabai</a>
                        <a href="#">Pupuk Organik</a>
                        <a href="#">Smart Sprinkler</a>
                        <a href="#">Polybag</a>
                        <a href="#">Selada Hidroponik</a>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="header-icons justify-content-center justify-content-lg-end">
                        <a href="index.php?action=showCart">
                            <i class="fas fa-shopping-cart"></i>
                            <?php $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                            <span class="cart-badge badge bg-danger" style="<?= $cart_count > 0 ? '' : 'display:none;' ?>"><?= $cart_count ?></span>
                        </a>

                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="profile-dropdown dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                                    <i class="fas fa-user-circle"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <h6 class="dropdown-header">Halo, <?= htmlspecialchars($_SESSION['user']['username']) ?></h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i>Akun Saya</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=myOrders"><i class="fas fa-receipt"></i>Pesanan Saya</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>