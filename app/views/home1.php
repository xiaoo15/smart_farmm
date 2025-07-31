<?php
// File: app/views/home.php (Versi Desain Baru + Backend)
$title = "EcoPlant - Solusi Tanaman Anda";
include 'templates/public_header.php'; // Panggil header yang sudah ada
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
  <div id="addCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <strong class="me-auto">EcoPlant</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Produk berhasil ditambahkan ke keranjang!
    </div>
  </div>
</div>

<main class="container pt-5 mt-5">
    <div class="row">
        <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-start text-center text-md-start gap-3">
            <h1 class="fs-1 fw-bold">Rooted in <span class="text-success">Nature</span> and Grown with Love.</h1>
            <p>Membangun masa depan hijau lewat inovasi dan cinta pada tanaman.</p>
            <div class="d-flex">
                <button type="button" class="btn btn-success me-2">Beli Sekarang</button>
                <button type="button" class="btn">
                    <img src="images/images-removebg-preview (1).png" alt="Logo" class="me-2" style="height: 2em;"> klik aku
                </button>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <img src="images/download (1).png" class="rounded img-fluid d-none d-md-block" style="max-width: 60%;" alt="picture">
        </div>
    </div>

    <div class="container recent-product-section mt-5">
        <div class="navigation-arrows">
            <div class="arrow-btn">&lt;</div>
            <div class="arrow-btn">&gt;</div>
        </div>

        <div class="recent-product-header-wrapper">
            <h2 class="recent-product-header">RECENT PRODUCT</h2>
            <p class="header-description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris aliquet nibh eu est ullamcorper.
            </p>
        </div>

        <div class="row px-3">
            <div class="col-md-6">
                <div class="product-card">
                    <img src="images/eI6xOPtKKT-removebg-preview.png" alt="Toss the tubs image">
                    <div>
                        <h5 class="product-card-title">Toss the tubs</h5>
                        <p class="product-card-text">Toss the tubs into the recycling bin! Let's make our community greener.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-card">
                    <img src="images/download_6-removebg-preview.png" alt="Reveal the plant image">
                    <div>
                        <h5 class="product-card-title">Reveal the plant</h5>
                        <p class="product-card-text">As we removed the large cloth covering, the audience eagerly anticipated.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-5 mt-4">
        <div class="row">
            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
                <img src="images/fb3c97abe7243934a7ccf7e8a44fa9f0-removebg-preview.png" class="rounded img-fluid d-none d-md-block" style="max-width: 100%;" alt="picture">
            </div>
            <div class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-start text-center text-md-start gap-3">
                <h5 class="gallery-subtitle">Gallery</h5>
                <h1 class="fs-1">Rooted in <span class="text-success">Nature</span> and Grown with Love.</h1>
                <p>Membangun masa depan hijau lewat inovasi dan cinta pada tanaman.</p>
                <div class="d-flex">
                    <button type="button" class="btn btn-success me-2">Beli Sekarang</button>
                    <button type="button" class="btn border-success text-succes me-2">Beli Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</main>

<section class="gallery-section">
    <div class="container">
        <h5 class="gallery-subtitle">Gallery</h5>
        <h2 class="gallery-title">OUR GALLERY</h2>

        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/wagubri-ajak-warga-riau-gemar-berta.jpg" class="d-block w-100 rounded" alt="foto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/olerikultura.jpg" class="d-block w-100 rounded" alt="foto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="images/images.jpeg" class="d-block w-100 rounded" alt="foto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section id="katalog" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5">Katalog Produk</h2>
            <p class="lead text-muted">Temukan hasil panen segar terbaik langsung dari kebun kami.</p>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-white">🔍</span>
                    <input type="text" id="product-search-input" class="form-control border-start-0" placeholder="Cari sayur, buah, atau produk lainnya...">
                </div>
            </div>
        </div>

        <div id="product-list" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if (isset($products) && mysqli_num_rows($products) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($products)): ?>
                <div class="col product-card" data-name="<?= strtolower(htmlspecialchars($product['name'])) ?>">
                    <div class="card h-100 border-0 shadow-sm card-product">
                        <div class="card-img-container">
                            <img src="images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title product-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text product-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                            <div class="mt-auto">
                                <?php if ($product['stock'] > 0): ?>
                                    <button class="btn btn-success w-100 add-to-cart-btn" data-id="<?= $product['id'] ?>">
                                        + Tambah ke Keranjang
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-secondary w-100" disabled>Stok Habis</button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 text-center">
                             <small class="text-muted">Stok: <?= $product['stock'] ?></small>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12"><p class="text-center text-muted fs-5 py-5">Belum ada produk yang tersedia.</p></div>
            <?php endif; ?>
            <div id="no-product-found" class="col-12 text-center" style="display: none;">
                <p class="fs-4 text-muted py-5">Oops! Produk yang kamu cari tidak ditemukan.</p>
            </div>
        </div>
    </div>
</section>

<style>
    .card-product {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 15px; /* Sudut lebih membulat */
    }
    .card-product:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important;
    }
    .card-img-container {
        height: 200px;
        overflow: hidden;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Gambar akan mengisi penuh tanpa distorsi */
    }
    .product-title {
        font-weight: 600;
        color: #333;
        /* Batasi teks jadi 2 baris jika terlalu panjang */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
        height: 2.5em; /* Sesuaikan dengan font-size * line-height * 2 */
    }
    .product-price {
        font-weight: 700;
        font-size: 1.25rem;
        color: #198754; /* Warna hijau success Bootstrap */
    }
    #product-search-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25); /* Efek focus hijau */
        border-color: #198754;
    }
</style>

<script>
// Script ini seharusnya sudah ada di file home.php atau footer-mu.
// Pastikan skrip ini ada untuk menangani fungsionalitas pencarian dan tambah keranjang.
document.addEventListener('DOMContentLoaded', function() {
    // Pencarian Produk
    const searchInput = document.getElementById('product-search-input');
    const allCards = document.querySelectorAll('#product-list .product-card');
    const noProductMessage = document.getElementById('no-product-found');
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        allCards.forEach(card => {
            const productName = card.dataset.name;
            if (productName.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        noProductMessage.style.display = visibleCount === 0 ? 'block' : 'none';
    });

    // Tambah ke Keranjang (Pastikan toast & fungsi update badge ada)
    const toastElement = document.getElementById('addCartToast');
    const toast = toastElement ? new bootstrap.Toast(toastElement) : null;
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.id;
            try {
                const response = await fetch(`index.php?action=addToCartAjax`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                });
                const result = await response.json();
                if (result.success) {
                    if(toast) toast.show();
                    // Pastikan fungsi updateCartBadge ada
                    if(typeof updateCartBadge === "function") updateCartBadge(result.cartCount);
                }
            } catch (error) { console.error('Error:', error); }
        });
    });
});
</script>

<?php 
// Panggil footer yang sudah ada
include 'templates/public_footer.php'; 
?>

<style>
    body { background-color: #f8f9fa; font-family: "Poppins", sans-serif; }
    .gallery-section { padding: 80px 0; text-align: center; }
    .gallery-subtitle { font-size: 0.9rem; color: #6c757d; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 5px; }
    .gallery-title { font-size: 2.5rem; font-weight: 700; color: #343a40; margin-bottom: 50px; position: relative; display: inline-block; padding-bottom: 10px; }
    .gallery-title::after { content: ''; position: absolute; left: 50%; transform: translateX(-50%); bottom: 0; width: 80px; height: 3px; background-color: #198754; border-radius: 5px; }
    .product-card-hover { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .product-card-hover:hover { transform: translateY(-5px); box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important; }
    .carousel-item img { height: 500px; object-fit: cover; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search-input');
    const allCards = document.querySelectorAll('#product-list .product-card');
    const noProductMessage = document.getElementById('no-product-found');
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        let visibleCount = 0;
        allCards.forEach(card => {
            if (card.dataset.name.includes(searchTerm)) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        noProductMessage.style.display = visibleCount === 0 ? 'block' : 'none';
    });

    const toast = new bootstrap.Toast(document.getElementById('addCartToast'));
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.id;
            try {
                const response = await fetch(`index.php?action=addToCartAjax`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                });
                const result = await response.json();
                if (result.success) {
                    toast.show();
                    updateCartBadge(result.cartCount);
                }
            } catch (error) { console.error('Error:', error); }
        });
    });

    function updateCartBadge(count) {
        const badge = document.querySelector('.nav-link .badge');
        if (badge) {
            badge.style.display = count > 0 ? 'inline-block' : 'none';
            badge.innerText = count;
        }
    }
});
</script>

<?php 
// Panggil footer yang sudah ada
include 'templates/public_footer.php'; 
?>

<style>
    body {
        background-color: #f0f0f0;
        font-family: "Poppins", sans-serif;
    }
    .recent-product-section {
        background-color: #E6F5EA;
        padding: 40px 0;
        border-radius: 10px;
        margin-top: 50px;
        position: relative;
        border-top-left-radius: 15px;
        border-top-right-radius: 60px;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        overflow: hidden;
    }
    .recent-product-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 150px;
        height: 100%;
        background-color: #D3EFDB;
        border-top-left-radius: 15px;
        border-top-right-radius: 0;
        z-index: 1;
    }
    .recent-product-header-wrapper {
        position: relative;
        z-index: 2;
        padding-left: 20px;
        padding-top: 15px;
    }
    .recent-product-header {
        color: #388E3C;
        font-size: 1.8rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .recent-product-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 30px;
    }
    .product-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        transition: transform 0.2s ease-in-out;
        position: relative;
        z-index: 3;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-card img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        margin-right: 20px;
    }
    .product-card-title {
        color: #388E3C;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 5px;
    }
    .product-card-text {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .navigation-arrows {
        position: absolute;
        top: 40px;
        right: 40px;
        display: flex;
        gap: 10px;
        z-index: 2;
    }
    .arrow-btn {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        color: #388E3C;
        font-weight: bold;
    }
    .arrow-btn:hover {
        background-color: #f0f0f0;
    }
    .header-description {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 20px;
        max-width: 300px;
    }
    .gallery-section {
        padding: 80px 0;
        text-align: center;
    }
    .gallery-subtitle {
        font-size: 0.9rem;
        color: #6c757d;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    .gallery-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #343a40;
        margin-bottom: 30px;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }
    .gallery-title::after {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 0;
        width: 80px;
        height: 3px;
        background-color: #28a745;
        border-radius: 5px;
    }
    .gallery-img-wrapper {
        padding: 10px;
    }
    .gallery-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }
    .gallery-img:hover {
        transform: translateY(-5px);
    }
    @media (max-width: 767.98px) {
        .gallery-title {
            font-size: 2rem;
        }
        .gallery-section {
            padding: 50px 0;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = new bootstrap.Toast(document.getElementById('addCartToast'));
    
    // Contoh fungsi untuk menambahkan ke keranjang
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.id;
            try {
                const response = await fetch(`index.php?action=addToCartAjax`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                });
                const result = await response.json();
                if (result.success) {
                    toast.show();
                    updateCartBadge(result.cartCount);
                }
            } catch (error) { console.error('Error:', error); }
        });
    });

    function updateCartBadge(count) {
        const badge = document.querySelector('.nav-link .badge');
        if (badge) {
            badge.style.display = count > 0 ? 'inline-block' : 'none';
            badge.innerText = count;
        }
    }
});
</script>