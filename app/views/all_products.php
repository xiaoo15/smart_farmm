<?php
// File: app/views/all_products.php (SUDAH DISAMBUNGKAN PHP & ADMIN)

$title = "Semua Produk - SmartFarm";
// Panggil header untuk customer, yang ada navbar, toast, dll.
include 'templates/public_header.php';
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .product-header {
            padding: 4rem 0;
            background-color: #e9f5e9;
            border-bottom: 1px solid #dee2e6;
        }
        
        .filter-nav .nav-link {
            color: #495057;
            font-weight: 500;
            border: 1px solid #dee2e6;
            border-radius: 50px;
            margin: 5px; /* Sedikit space antar tombol */
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .filter-nav .nav-link.active,
        .filter-nav .nav-link:hover {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .product-card {
            background-color: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden; 
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .product-card .img-container {
            height: 220px;
            position: relative;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-card .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 10px;
        }

        .product-card .card-body {
            padding: 1.25rem;
        }
        
        .product-card .product-title {
            font-weight: 600;
            color: #343a40;
            overflow: hidden;
            height: 3rem; 
        }

        .product-card .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #28a745;
        }

        .product-card .product-price del {
            font-size: 0.9rem;
            font-weight: 400;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <header class="product-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Semua Produk</h1>
            <p class="lead text-muted">Temukan semua yang Anda butuhkan untuk memulai petualangan berkebun cerdas Anda.</p>
        </div>
    </header>

    <main class="container py-5">
        <div class="row mb-5">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center filter-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-filter="*">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="kit">🌱 Smart Kit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="panen">🍎 Hasil Panen</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="bibit">🌿 Bibit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-filter="alat">🛠️ Peralatan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row g-4" id="product-list-container">
            
            <?php
            // Pastikan variabel $products dari HomeController sudah ada
            if (isset($products) && mysqli_num_rows($products) > 0) {
                while ($row = mysqli_fetch_assoc($products)) {
                    // Logika untuk tombol (biar disable kalau stok habis)
                    $isStokHabis = ($row['stock'] <= 0);
                    $tombolClass = $isStokHabis ? 'btn-outline-secondary' : 'btn-outline-success';
                    $tombolTeks = $isStokHabis ? 'Stok Habis' : 'Tambah ke Keranjang';
                    $tombolDisabled = $isStokHabis ? 'disabled' : '';

                    // Cetak kartu produknya
                    echo '
                    <div class="col-6 col-md-4 col-lg-3 product-item" data-category="'.htmlspecialchars($row['kategori']).'">
                        <div class="card product-card h-100">
                            <div class="img-container">
                                <img src="public/images/products/'.htmlspecialchars($row['image_url']).'" class="card-img-top" alt="'.htmlspecialchars($row['name']).'">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="product-title">'.htmlspecialchars($row['name']).'</h5>
                                <p class="product-price mb-3">Rp '.number_format($row['price'], 0, ',', '.').'</p>
                                <button class="btn '.$tombolClass.' mt-auto add-to-cart-btn" data-id="'.$row['id'].'" '.$tombolDisabled.'>
                                    '.$tombolTeks.'
                                </button>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                // Pesan kalau nggak ada produk sama sekali
                echo '<div class="col-12 text-center"><p class="text-muted fs-5">Yah, belum ada produk yang bisa ditampilkan.</p></div>';
            }
            ?>

        </div>
    </main>

    <?php 
    // Panggil footer untuk customer, isinya script-script penting
    include 'templates/public_footer.php'; 
    ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterLinks = document.querySelectorAll('.filter-nav .nav-link');
            // Cek dulu apakah elemennya ada sebelum nambahin event listener
            if (filterLinks.length > 0) {
                const productItems = document.querySelectorAll('.product-item');

                filterLinks.forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        filterLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                        const filter = this.getAttribute('data-filter');

                        productItems.forEach(item => {
                            // Animasi fade out
                            item.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                            item.style.transform = 'scale(0.95)';
                            item.style.opacity = '0';
                            
                            setTimeout(() => {
                                // Sembunyikan atau tampilkan berdasarkan filter
                                if (filter === '*' || item.getAttribute('data-category') === filter) {
                                    item.style.display = 'block';
                                    // Animasi fade in
                                    setTimeout(() => {
                                        item.style.transform = 'scale(1)';
                                        item.style.opacity = '1';
                                    }, 50);
                                } else {
                                    item.style.display = 'none';
                                }
                            }, 300);
                        });
                    });
                });
            }
        });
    </script>
</body>
</html>