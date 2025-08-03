<?php
// File: app/views/all_products.php
$title = "Semua Produk - SmartFarm";
include 'templates/public_header.php';
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
            transition: all 0.5s ease;
        }

        .product-header {
            padding: 5rem 0;
            background: linear-gradient(135deg, #e9f5e9, #d0e7d0);
            border-bottom: 2px solid #28a745;
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
            background-color: #28a745;
            border-color: #28a745;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .product-card {
            background-color: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .product-card .img-container {
            height: 250px;
            position: relative;
            cursor: pointer;
        }

        .product-card .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .img-container img {
            transform: scale(1.05);
        }

        .product-card .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .product-card .product-title {
            font-weight: 600;
            color: #343a40;
            overflow: hidden;
            height: 3rem;
            line-height: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .product-card .product-price {
            font-size: 1.4rem;
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
            transform: scale(1.02);
        }

        .modal-header,
        .modal-body {
            font-family: 'Poppins', sans-serif;
        }

        .modal-title {
            font-weight: 700;
            color: #28a745;
        }

        /* Responsive CSS untuk HP */
        @media (max-width: 768px) {
            .product-header {
                padding: 3rem 0;
            }

            .product-header h1 {
                font-size: 2rem;
            }

            .product-card .img-container {
                height: 180px;
            }
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

        <div id="loading-spinner" class="text-center my-5" style="display: none;">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat produk...</p>
        </div>

        <div class="row g-4" id="product-list-container">
            <?php
            // Pastikan variabel $products dari HomeController sudah ada
            if (isset($products) && mysqli_num_rows($products) > 0) {
                while ($row = mysqli_fetch_assoc($products)) {
                    $isStokHabis = ($row['stock'] <= 0);
                    $tombolClass = $isStokHabis ? 'btn-outline-secondary' : 'btn-success';
                    $tombolTeks = $isStokHabis ? 'Stok Habis' : 'Tambah ke Keranjang';
                    $tombolDisabled = $isStokHabis ? 'disabled' : '';
            ?>
                    <div class="col-6 col-md-4 col-lg-3 product-item" data-category="<?= htmlspecialchars($row['kategori'] ?? '') ?>">
                        <div class="card product-card h-100">
                            <div class="img-container"
                                data-bs-toggle="modal"
                                data-bs-target="#productDetailModal"
                                data-name="<?= htmlspecialchars($row['name'] ?? '') ?>"
                                data-price="<?= htmlspecialchars(number_format($row['price'] ?? 0, 0, ',', '.')) ?>"
                                data-image="public/images/products/<?= htmlspecialchars($row['image_url'] ?? '') ?>"
                                data-description="<?= htmlspecialchars($row['description'] ?? '') ?>">
                                <img src="public/images/products/<?= htmlspecialchars($row['image_url'] ?? '') ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name'] ?? '') ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="product-title"><?= htmlspecialchars($row['name'] ?? '') ?></h5>
                                <p class="product-price mb-3">Rp <?= htmlspecialchars(number_format($row['price'] ?? 0, 0, ',', '.')) ?></p>
                                <button class="btn <?= $tombolClass ?> mt-auto add-to-cart-btn" data-id="<?= htmlspecialchars($row['id'] ?? '') ?>" <?= $tombolDisabled ?>>
                                    <?= $tombolTeks ?>
                                </button>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
            ?>
                <div class="col-12 text-center">
                    <p class="text-muted fs-5">Yah, belum ada produk yang bisa ditampilkan.</p>
                </div>
            <?php
            }
            ?>
        </div>
    </main>

    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="productImage" src="" class="img-fluid rounded" alt="Product Image">
                        </div>
                        <div class="col-md-6">
                            <h2 class="mt-3 mt-md-0" id="productName"></h2>
                            <h4 class="text-success my-3" id="productPrice"></h4>
                            <p id="productDescription"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include 'templates/public_footer.php';
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Logika filter produk
            const filterLinks = document.querySelectorAll('.filter-nav .nav-link');
            const productItems = document.querySelectorAll('.product-item');
            const productListContainer = document.getElementById('product-list-container');
            const loadingSpinner = document.getElementById('loading-spinner');

            if (filterLinks.length > 0) {
                filterLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        filterLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');

                        const filter = this.getAttribute('data-filter');
                        
                        productListContainer.style.display = 'none';
                        loadingSpinner.style.display = 'block';

                        setTimeout(() => {
                            let displayedItemsCount = 0;
                            
                            productItems.forEach(item => {
                                if (filter === '*' || item.getAttribute('data-category') === filter) {
                                    item.style.display = 'block';
                                    displayedItemsCount++;
                                } else {
                                    item.style.display = 'none';
                                }
                            });
                            
                            loadingSpinner.style.display = 'none';
                            productListContainer.style.display = 'flex';

                            if (displayedItemsCount > 0) {
                                // Tampilkan produk
                            } else {
                                // Tampilkan pesan "produk tidak ditemukan"
                                const noProductMessage = document.createElement('div');
                                noProductMessage.className = 'col-12 text-center my-5';
                                noProductMessage.innerHTML = '<p class="text-muted fs-5">Produk di kategori ini belum tersedia.</p>';
                                productListContainer.innerHTML = ''; // Kosongkan dulu
                                productListContainer.appendChild(noProductMessage);
                            }
                        }, 500);
                    });
                });
            }

            // Logika modal detail produk
            const productDetailModal = document.getElementById('productDetailModal');
            productDetailModal.addEventListener('show.bs.modal', function(event) {
                const triggerElement = event.relatedTarget;
                const productName = triggerElement.getAttribute('data-name');
                const productPrice = triggerElement.getAttribute('data-price');
                const productImage = triggerElement.getAttribute('data-image');
                const productDescription = triggerElement.getAttribute('data-description');

                const modalTitle = productDetailModal.querySelector('.modal-title');
                const modalImage = productDetailModal.querySelector('#productImage');
                const modalName = productDetailModal.querySelector('#productName');
                const modalPrice = productDetailModal.querySelector('#productPrice');
                const modalDescription = productDetailModal.querySelector('#productDescription');

                modalTitle.textContent = productName;
                modalImage.src = productImage;
                modalName.textContent = productName;
                modalPrice.textContent = 'Rp ' + productPrice;
                modalDescription.textContent = productDescription;
            });

            // Logika untuk tombol "Tambah ke Keranjang" dan Toast
            const toastElement = document.getElementById('addCartToast');
            const toast = new bootstrap.Toast(toastElement);
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const productId = this.dataset.id;
                    const productName = this.closest('.product-card').querySelector('.product-title').textContent;
                    try {
                        // Mengirim data ke backend
                        const response = await fetch('tambah_ke_keranjang.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `product_id=${productId}`
                        });
                        const result = await response.json();
                        if (result.status === 'success') {
                            const toastBody = document.getElementById('toast-body-message');
                            toastBody.textContent = `Produk "${result.product_name}" berhasil ditambahkan ke keranjang!`;
                            toast.show();
                            // Fungsi ini bisa kamu panggil kalau ada badge keranjang di navbar
                            // updateCartBadge(result.keranjangCount);
                        } else {
                            alert('Gagal menambahkan produk: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menambahkan produk ke keranjang.');
                    }
                });
            });
            
            // Contoh fungsi update badge keranjang (kamu bisa implementasikan di public_header.php)
            // function updateCartBadge(count) {
            //     const badge = document.querySelector('#cart-count-badge');
            //     if (badge) {
            //         badge.textContent = count;
            //         badge.style.display = count > 0 ? 'inline-block' : 'none';
            //     }
            // }
        });
    </script>
</body>
</html>