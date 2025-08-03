<?php
// File: app/views/all_products.php (VERSI FINAL YANG SUDAH DIPERBAIKI)
$title = "Semua Produk - SmartFarm";
include 'templates/public_header.php';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        /* ===== INI DIA DAPUR CSS BARUNYA! ===== */
        body {
            background-color: #f0f2f5; /* Warna latar sedikit lebih lembut */
            font-family: 'Poppins', sans-serif;
        }

        .product-header {
            padding: 5rem 0;
            /* Gradient mewah dari hijau muda ke putih */
            background: linear-gradient(135deg, #e9f5e9 0%, #ffffff 100%);
        }
        
        .filter-nav .nav-link {
            color: #495057;
            font-weight: 500;
            border: 1px solid #dee2e6;
            border-radius: 50px;
            margin: 5px;
            padding: 8px 20px;
            transition: all 0.3s ease-in-out;
        }

        .filter-nav .nav-link.active,
        .filter-nav .nav-link:hover {
            color: #fff;
            background-color: #fff;
            border-color: #28a745;
            transform: translateY(-3px); /* Efek ngangkat sedikit lebih tinggi */
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4); /* Bayangan lebih dramatis */
        }

        .product-card {
            background-color: #fff;
            border: none;
            border-radius: 20px; /* Sudut lebih bulat, lebih modern */
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.08); /* Bayangan lebih halus */
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1); /* Transisi lebih smooth */
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-10px); /* Ngangkat lebih tinggi pas di-hover */
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); /* Bayangan lebih jelas */
        }

        .product-card .img-container {
            height: 250px; /* Sedikit lebih tinggi biar gambar lebih lega */
            position: relative;
            cursor: pointer; /* Kasih tanda kalau gambar bisa diklik */
        }

        .product-card .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease; /* Animasi zoom gambar */
        }

        .product-card:hover .img-container img {
            transform: scale(1.05); /* Zoom sedikit pas hover */
        }

        .product-card .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column; /* Biar tombol selalu di bawah */
        }

        .product-card .product-title {
            font-weight: 600;
            color: #343a40;
            overflow: hidden;
            height: 3rem; /* Cukup untuk 2 baris */
            line-height: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .product-card .product-price {
            font-size: 1.4rem; /* Harga lebih menonjol */
            font-weight: 700;
            color: #28a745;
            margin-bottom: 1rem;
        }
        
        .add-to-cart-btn {
            border-radius: 50px;
            font-weight: 600;
            padding: 12px 25px;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            transform: scale(1.02); /* Tombol sedikit membesar */
        }

    </style>
</head>

<body>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="addCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">SmartFarm</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-body-message">
            Produk berhasil ditambahkan ke keranjang!
        </div>
    </div>
</div>
<header class="product-header text-center">
    <div class="container">
        <h1 class="display-5 fw-bold">Semua Produk</h1>
        <p class="lead text-muted">Temukan semua yang Anda butuhkan untuk memulai petualangan berkebun cerdas Anda.</p>
    </div>
</header>

<main class="container py-5">
    <div class="row mb-5">
        <div class="col-12">
            <ul class="nav nav-pills justify-content-center filter-nav flex-wrap">
                <li class="nav-item"><a class="nav-link active" href="#" data-filter="*">Semua</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="kit">🌱 Smart Kit</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="panen">🍎 Hasil Panen</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="bibit">🌿 Bibit</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="alat">🛠️ Peralatan</a></li>
            </ul>
        </div>
    </div>

    <div class="row g-4" id="product-list-container">
        <?php
        if (isset($products) && mysqli_num_rows($products) > 0) {
            while ($row = mysqli_fetch_assoc($products)) {
                $isStokHabis = ($row['stock'] <= 0);
                $tombolClass = $isStokHabis ? 'btn-outline-secondary' : 'btn-outline-success';
                $tombolTeks = $isStokHabis ? 'Stok Habis' : 'Tambah ke Keranjang';
                $tombolDisabled = $isStokHabis ? 'disabled' : '';
                echo '
                <div class="col-6 col-md-4 col-lg-3 product-item" data-category="'.htmlspecialchars($row['kategori']).'">
                    <div class="card product-card h-100">
                        <div class="img-container">
                            <img src="public/images/products/'.htmlspecialchars($row['image_url']).'" class="card-img-top" alt="'.htmlspecialchars($row['name']).'">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="product-title">'.htmlspecialchars($row['name']).'</h5>
                            <p class="product-price mb-3">Rp '.number_format($row['price'], 0, ',', '.').'</p>
                            <button class="btn '.$tombolClass.' mt-auto add-to-cart-btn" data-id="'.$row['id'].'" '.$tombolDisabled.'>'.$tombolTeks.'</button>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
    </div>
</main>

    <?php include 'templates/public_footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterLinks = document.querySelectorAll('.filter-nav .nav-link');
            const productItems = document.querySelectorAll('.product-item');

            filterLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    filterLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    const filter = this.getAttribute('data-filter');

                    productItems.forEach(item => {
                        if (filter === '*' || item.getAttribute('data-category') === filter) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // SETELAH SELESAI FILTER, PANGGIL ULANG INISIALISASI TOMBOL!
                    // Ini penting biar tombol di produk yang baru muncul bisa diklik
                    if (typeof window.reinitializeCartButtons === 'function') {
                        window.reinitializeCartButtons();
                    }
                });
            });
        });
    </script>
</body>

</html>