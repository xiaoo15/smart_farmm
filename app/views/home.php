<?php
$title = "SmartFarm - Solusi Pertanian Modern";
include 'templates/public_header.php';
?>
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="addCartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">SmartFarm</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toast-body-message">
            Produk berhasil ditambahkan!
        </div>
    </div>
</div>

<header class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="display-4 fw-bold text-success mb-3">Kesegaran Langsung dari Kebun Cerdas</h1>
                <p class="lead text-muted mb-4">Mulai petualangan berkebun Anda atau nikmati hasil panen terbaik yang ditanam dengan cinta dan teknologi.</p>
                <a href="#katalog" class="btn btn-success btn-lg shadow-sm px-4 py-2">Lihat Katalog Kami</a>
                <a href="index.php?action=allProducts" class="btn btn-outline-secondary btn-lg px-4 py-2 ms-2">Jelajahi Semua</a>
            </div>
            <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center mt-5 mt-lg-0">
                <div class="hero-image-container">
                    <img src="images/download (1).png" class="img-fluid hero-image" alt="Hero Image">
                </div>
            </div>
        </div>
    </div>
</header>

<section id="katalog" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h5 class="gallery-subtitle text-success">PILIHAN TERBAIK</h5>
            <h2 class="gallery-title fw-bold">PRODUK UNGGULAN KAMI</h2>
        </div>

        <div id="product-list" class="row g-4">
            <?php if (isset($products) && mysqli_num_rows($products) > 0): ?>
                <?php
                $product_count = 0;
                mysqli_data_seek($products, 0);
                while ($product = mysqli_fetch_assoc($products)):
                    if ($product_count >= 8) break;

                    $isStokHabis = ($product['stock'] <= 0);
                    $tombolClass = $isStokHabis ? 'btn-outline-secondary' : 'btn-success';
                    $tombolTeks = $isStokHabis ? 'Stok Habis' : 'Tambah';
                    $tombolDisabled = $isStokHabis ? 'disabled' : '';
                ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 product-card">
                            <div class="img-container">
                                <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="product-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="product-price mb-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                <div class="mt-auto">
                                    <button class="btn <?= $tombolClass ?> w-100 add-to-cart-btn fw-semibold" data-id="<?= $product['id'] ?>" <?= $tombolDisabled ?>><?= $tombolTeks ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $product_count++;
                endwhile;
                ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-muted fs-5 py-5">Belum ada produk unggulan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>



<?php
// Panggil footer yang ada "otak"-nya
include 'templates/public_footer.php';
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .hero-section {
        padding: 6rem 0;
        background-color: #fff;
        overflow: hidden;
    }

    /* INI DIA CSS UNTUK EFEK GAMBAR HIDUPNYA */
    .hero-image-container {
        width: 350px;
        height: 350px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        background: radial-gradient(circle, rgba(143, 255, 199, 0.8) 0%, rgba(255, 255, 255, 0) 70%);
        animation: pulse-bg 4s ease-in-out infinite alternate;
    }

    @keyframes pulse-bg {
        from {
            transform: scale(1);
        }

        to {
            transform: scale(1.05);
        }
    }

    .hero-image {
        width: 90%;
        animation: float-up-down 4s ease-in-out infinite;
    }

    @keyframes float-up-down {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    /* CSS LAINNYA */
    .gallery-section {
        padding: 80px 0;
    }

    .gallery-subtitle {
        font-size: 0.9rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .gallery-title {
        font-size: 2.5rem;
        color: #343a40;
        margin-bottom: 50px;
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
        background-color: #198754;
        border-radius: 5px;
    }

    .product-card {
        background-color: #fff;
        border: none;
        border-radius: 20px;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    .product-card .img-container {
        height: 220px;
    }

    .product-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover img {
        transform: scale(1.05);
    }

    .product-card .card-body {
        padding: 1.5rem;
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

    .carousel-item img {
        height: 500px;
        object-fit: cover;
    }
</style>

<?php
// Panggil footer yang ada "otak"-nya
include 'templates/public_footer.php';
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('product-search-input');
        const allCards = document.querySelectorAll('#product-list .product-card');
        const noProductMessage = document.getElementById('no-product-found');

        if (searchInput) {
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
        }
    });
</script>

<?php
include 'templates/public_footer.php';
?>