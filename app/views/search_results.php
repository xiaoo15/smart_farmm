<?php
// File: app/views/search_results.php (FILE BARU)
$title = "Hasil Pencarian untuk '" . htmlspecialchars($searchTerm) . "'";
include 'templates/public_header.php';
?>

<div class="container my-5">
    <div class="search-header mb-4">
        <h1 class="display-6 fw-bold">Hasil Pencarian</h1>
        <p class="lead text-muted">Menampilkan hasil untuk: "<strong><?= htmlspecialchars($searchTerm) ?></strong>"</p>
    </div>

    <div class="row g-4">
        <?php if (isset($products) && mysqli_num_rows($products) > 0): ?>
            <?php while ($product = mysqli_fetch_assoc($products)): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="index.php?action=productDetail&id=<?= $product['id'] ?>" class="product-card-link">
                        <div class="card h-100 product-card">
                            <div class="img-container">
                                <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>
                            <div class="card-body">
                                <p class="product-title"><?= htmlspecialchars($product['name']) ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="product-price mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                    <p class="product-sold mb-0"><?= $product['total_sold'] ?> terjual</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h3 class="fw-bold">Oops! Produk tidak ditemukan.</h3>
                <p class="text-muted">Coba gunakan kata kunci lain yang lebih umum.</p>
                <a href="index.php?action=home" class="btn btn-success mt-2">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .product-card .product-price {
        font-size: 1rem;
        /* Sedikit kita kecilkan agar sejajar */
        font-weight: 600;
        color: var(--dark-primary-green);
        margin-bottom: 0;
    }

    /* ============================================= */
    /* CSS BARU UNTUK TULISAN "TERJUAL" */
    /* ============================================= */
    .product-card .product-sold {
        font-size: 0.75rem;
        color: #6c757d;
        /* Warna abu-abu */
    }

    .product-card-link {
        text-decoration: none;
    }

    .product-card {
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        border-radius: 5px;
        overflow: hidden;
    }

    .product-card:hover {
        border-color: var(--dark-primary-green);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-5px);
    }

    .product-card .img-container {
        width: 100%;
        padding-top: 100%;
        position: relative;
    }

    .product-card .img-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-card .card-body {
        padding: 0.75rem;
    }

    .product-card .product-title {
        font-size: 0.8rem;
        color: #333;
        margin-bottom: 0.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.4em;
    }

    .product-card .product-price {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-primary-green);
        margin-bottom: 0;
    }
</style>

<?php include 'templates/public_footer.php'; ?>