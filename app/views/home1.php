<?php
// File: app/views/home.php (Versi Desain Baru + Backend)
$title = "EcoPlant - Solusi Tanaman Anda";
include 'templates/public_header.php'; // Panggil header yang sudah ada
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
            <h1 class="fs-1 fw-bold">Rooted in <span class="text-success">Nature</span> and Grown with Love.</h1>
            <p>Membangun masa depan hijau lewat inovasi dan cinta pada tanaman, langsung dari kebun kami ke rumah Anda.</p>
            <div class="d-flex">
                <a href="#katalog" class="btn btn-success me-2">Lihat Katalog</a>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <img src="images/download (1).png" class="rounded img-fluid d-none d-md-block" style="max-width: 60%;" alt="hero picture">
        </div>
    </div>
</main>

<section id="katalog" class="gallery-section">
    <div class="container">
        <h5 class="gallery-subtitle">PRODUK KAMI</h5>
        <h2 class="gallery-title">KATALOG PRODUK</h2>

        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white">🔍</span>
                    <input type="text" id="product-search-input" class="form-control" placeholder="Cari sayur, buah, atau produk lainnya...">
                </div>
            </div>
        </div>

        <div id="product-list" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if (isset($products) && mysqli_num_rows($products) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($products)): ?>
                <div class="col product-card" data-name="<?= strtolower(htmlspecialchars($product['name'])) ?>">
                    <div class="card h-100 shadow-sm product-card-hover">
                        <img src="images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text fw-bold text-success fs-5 mb-2">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                            <p class="card-text text-muted"><small>Stok: <?= $product['stock'] ?></small></p>
                            
                            <?php if ($product['stock'] > 0): ?>
                                <button class="btn btn-primary mt-auto add-to-cart-btn" data-id="<?= $product['id'] ?>">+ Keranjang</button>
                            <?php else: ?>
                                <button class="btn btn-secondary mt-auto" disabled>Stok Habis</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12"><p class="text-center text-muted fs-5">Belum ada produk yang tersedia.</p></div>
            <?php endif; ?>
            <div id="no-product-found" class="col-12 text-center" style="display: none;">
                <p class="fs-4 text-muted">Oops! Produk yang kamu cari tidak ditemukan.</p>
            </div>
        </div>
    </div>
</section>

<section class="gallery-section bg-light">
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
