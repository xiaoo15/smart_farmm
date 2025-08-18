<?php
// File: app/views/home.php (VERSI FINAL + VOUCHER SECTION)
$title = "SmartFarm - Tanam, Panen, Nikmati!";
include 'templates/public_header.php'; // Ini header hijau muda yang sudah kita buat
?>

<main class="main-content-container">
    <div class="container">

        <div class="row mb-4">
            <div class="col-12">
                <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded-3">
                        <div class="carousel-item active">
                            <img src="https://static.vecteezy.com/system/resources/previews/011/188/575/large_2x/yellow-and-orange-special-sale-coupon-template-with-exclusive-offer-up-to-50-percent-off-gift-voucher-with-50-percent-discount-special-promo-code-website-illustration-vector.jpg" class="d-block w-100" alt="Promo 1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://static.vecteezy.com/system/resources/previews/011/188/575/large_2x/yellow-and-orange-special-sale-coupon-template-with-exclusive-offer-up-to-50-percent-off-gift-voucher-with-50-percent-discount-special-promo-code-website-illustration-vector.jpg" class="d-block w-100" alt="Promo 2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="voucher-section row g-3 mb-4">
            <div class="col-md-6">
                <a href="#" class="voucher-card">
                    <img src="https://images.unsplash.com/photo-1464297162577-f5295c892194?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Diskon Petani Lokal">
                </a>
            </div>
            <div class="col-md-6">
                <a href="#" class="voucher-card">
                    <img src="https://media.istockphoto.com/id/1329408006/photo/green-tomatoes-in-greenhouse.webp?a=1&s=612x612&w=0&k=20&c=KBy0VdkalatrqCB2MTkE4l4Dj5OwZ_mHQ4l3hcpN-Vw=" alt="Voucher Panen Segar">
                </a>
            </div>
        </div>


        <div class="category-icons-grid bg-white rounded-3 p-3 mb-4">
            <div class="row g-2">
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-tags"></i></div>
                        <span class="icon-text">Promo Spesial</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-store"></i></div>
                        <span class="icon-text">SmartFarm Mall</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-bolt"></i></div>
                        <span class="icon-text">Flash Sale</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-seedling"></i></div>
                        <span class="icon-text">Bibit Unggul</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-carrot"></i></div>
                        <span class="icon-text">Hasil Panen</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-tractor"></i></div>
                        <span class="icon-text">Peralatan</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-gift"></i></div>
                        <span class="icon-text">Gratis Ongkir</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-percent"></i></div>
                        <span class="icon-text">Diskon & Voucher</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-boxes-stacked"></i></div>
                        <span class="icon-text">Paket Hemat</span>
                    </a>
                </div>
                <div class="col-3 col-md-2 col-lg-1 text-center">
                    <a href="#" class="category-icon-item">
                        <div class="icon-wrapper"><i class="fas fa-ellipsis-h"></i></div>
                        <span class="icon-text">Semua Kategori</span>
                    </a>
                </div>
            </div>
        </div>


        <div class="product-section bg-white rounded-3 p-3">
            <div class="section-header">
                <h4 class="section-title">REKOMENDASI UNTUKMU</h4>
                <a href="index.php?action=allProducts" class="section-see-all">Lihat Semua <i class="fas fa-chevron-right"></i></a>
            </div>

            <div id="product-list" class="row g-3">
                <?php if (isset($products) && mysqli_num_rows($products) > 0): ?>
                    <?php
                    mysqli_data_seek($products, 0); // Reset pointer
                    while ($product = mysqli_fetch_assoc($products)):
                    ?>
                        <div class="col-6 col-md-4 col-lg-2">
                            <a href="index.php?action=productDetail&id=<?= $product['id'] ?>" class="product-card-link">
                                <div class="card h-100 product-card">
                                    <div class="img-container">
                                        <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                                    </div>
                                    <div class="card-body">
                                        <p class="product-title"><?= htmlspecialchars($product['name']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="product-price mb-0">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                            <p class="product-sold mb-0"><?= $product['total_sold'] ?? 0 ?> terjual</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    endwhile;
                    ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center text-muted p-5">Belum ada produk untuk direkomendasikan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>


<?php include 'templates/public_footer.php'; ?>

<style>
    .main-content-container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    /* ============================================= */
    /* CSS BARU UNTUK VOUCHER SECTION                */
    /* ============================================= */
    .voucher-card {
        display: block;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .voucher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .voucher-card img {
        width: 100%;
        height: auto;
        display: block;
    }

    .category-icons-grid {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .category-icon-item {
        display: inline-block;
        text-decoration: none;
        color: #333;
        transition: transform 0.2s ease;
    }

    .category-icon-item:hover {
        transform: translateY(-5px);
        color: var(--dark-primary-green);
    }

    .category-icon-item .icon-wrapper {
        width: 50px;
        height: 50px;
        margin: 0 auto 0.5rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .category-icon-item .icon-text {
        font-size: 0.75rem;
        display: block;
        line-height: 1.2;
    }

    .product-section {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 0.75rem;
        margin-bottom: 1rem;
    }

    .section-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #555;
    }

    .section-see-all {
        text-decoration: none;
        color: var(--dark-primary-green);
        font-size: 0.9rem;
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
        height: 2.4em;
        line-height: 1.2em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
    }

    .product-card .product-price {
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-primary-green);
        margin-bottom: 0;
    }

    .product-card .product-sold {
        font-size: 0.75rem;
        color: #6c757d;
    }
</style>