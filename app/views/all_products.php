<?php
// File: app/views/all_products.php (FILE BARU)
$title = "Semua Produk";
include 'templates/public_header.php'; // Panggil header
?>

<main class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="text-center mb-5">
            <h5 class="gallery-subtitle">KATALOG LENGKAP</h5>
            <h2 class="gallery-title">SEMUA PRODUK KAMI</h2>
            <p class="lead text-muted">Temukan semua yang Anda butuhkan untuk memulai petualangan berkebun cerdas Anda, mulai dari bibit hingga peralatan.</p>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-white">🔍</span>
                    <input type="text" id="product-search-input" class="form-control border-start-0" placeholder="Cari produk di sini...">
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
</main>

<?php 
// Kita pakai CSS dan JS yang sama dengan home.php
// Jadi, kita bisa pindahkan style dan scriptnya ke footer biar lebih rapi
include 'templates/public_footer.php'; 
?>

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

    // Fungsi Tambah ke Keranjang (Sama seperti di home.php)
    const toastElement = document.getElementById('addCartToast'); // Pastikan toast ada di public_header.php
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
                    // Fungsi ini harus ada di public_footer.php atau scope global
                    if(typeof updateCartBadge === "function") updateCartBadge(result.cartCount);
                }
            } catch (error) { console.error('Error:', error); }
        });
    });
});
</script>