<?php
// File: app/views/home.php (SUDAH DIRAPIKAN)
$title = "SmartFarm - Solusi Pertanian Modern";
include 'templates/public_header.php';
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
  <div id="addCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header bg-success text-white">
      <strong class="me-auto">SmartFarm</strong>
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
            <h1 class="fs-1 fw-bold">Rooted in <span class="text-success">Nature</span>, Grown with Love.</h1>
            <p>Membangun masa depan hijau lewat inovasi dan cinta pada tanaman, langsung dari kebun kami ke rumah Anda.</p>
            <a href="#katalog" class="btn btn-success btn-lg">Lihat Katalog</a>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <img src="images/download (1).png" class="rounded img-fluid d-none d-md-block" style="max-width: 70%;" alt="Hero Image">
        </div>
    </div>
</main>

<section id="katalog" class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h5 class="gallery-subtitle">PRODUK KAMI</h5>
            <h2 class="gallery-title">KATALOG PRODUK</h2>
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
                            <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title product-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text product-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                            <div class="mt-auto">
                                <?php if ($product['stock'] > 0): ?>
                                    <button class="btn btn-success w-100 add-to-cart-btn" data-id="<?= $product['id'] ?>">+ Tambah ke Keranjang</button>
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

<section class="gallery-section">
    <div class="container">
        <h5 class="gallery-subtitle">GALLERY</h5>
        <h2 class="gallery-title">KEBUN KAMI</h2>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active"><img src="images/wagubri-ajak-warga-riau-gemar-berta.jpg" class="d-block w-100 rounded" alt="foto kebun 1"></div>
                <div class="carousel-item"><img src="images/olerikultura.jpg" class="d-block w-100 rounded" alt="foto kebun 2"></div>
                <div class="carousel-item"><img src="images/images.jpeg" class="d-block w-100 rounded" alt="foto kebun 3"></div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
        </div>
    </div>
</section>

<style>
    /* CSS ini bisa dipindah ke file .css terpisah jika mau */
    .gallery-section { padding: 80px 0; text-align: center; }
    .gallery-subtitle { font-size: 0.9rem; color: #6c757d; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 5px; }
    .gallery-title { font-size: 2.5rem; font-weight: 700; color: #343a40; margin-bottom: 50px; position: relative; display: inline-block; padding-bottom: 10px; }
    .gallery-title::after { content: ''; position: absolute; left: 50%; transform: translateX(-50%); bottom: 0; width: 80px; height: 3px; background-color: #198754; border-radius: 5px; }
    .card-product { transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 15px; }
    .card-product:hover { transform: translateY(-8px); box-shadow: 0 8px 30px rgba(0,0,0,0.1) !important; }
    .card-img-container { height: 200px; overflow: hidden; border-top-left-radius: 15px; border-top-right-radius: 15px; }
    .card-img-top { width: 100%; height: 100%; object-fit: cover; }
    .product-title { font-weight: 600; color: #333; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.5em; }
    .product-price { font-weight: 700; font-size: 1.25rem; color: #198754; }
    #product-search-input:focus { box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25); border-color: #198754; }
    .carousel-item img { height: 500px; object-fit: cover; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi Pencarian Produk
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

    // Fungsi Tambah ke Keranjang
    const toastElement = document.getElementById('addCartToast');
    const toast = new bootstrap.Toast(toastElement);
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
    
    // Fungsi Update Badge Keranjang di Navbar
    function updateCartBadge(count) {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.innerText = count;
            if (count > 0) {
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }
    }
});
</script>

<?php 
include 'templates/public_footer.php'; 
?>