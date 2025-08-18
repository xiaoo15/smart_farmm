<?php
$title = isset($product['name']) ? htmlspecialchars($product['name']) : "Detail Produk";
include 'templates/public_header.php';

// Helper function untuk menampilkan bintang rating
function render_stars($rating)
{
    $rating = round($rating * 2) / 2; // Bulatkan ke 0.5 terdekat
    $output = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($rating >= $i) {
            $output .= '<i class="fas fa-star text-warning"></i>'; // Bintang penuh
        } elseif ($rating > $i - 1 && $rating < $i) {
            $output .= '<i class="fas fa-star-half-alt text-warning"></i>'; // Bintang setengah
        } else {
            $output .= '<i class="far fa-star text-warning"></i>'; // Bintang kosong
        }
    }
    return $output;
}
?>

<div class="product-detail-page container my-4">
    <div class="bg-white p-4 rounded-3 shadow-sm">
        <?php if (isset($product) && $product): ?>
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="main-image-container mb-2">
                        <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="img-fluid rounded" alt="Gambar Produk Utama" id="main-product-image">
                    </div>
                    <div class="thumbnail-container d-flex">
                        <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="thumbnail-item active" alt="Thumb 1">
                        <img src="public/images/products/default.jpg" class="thumbnail-item" alt="Thumb 2">
                        <img src="public/images/products/default.jpg" class="thumbnail-item" alt="Thumb 3">
                    </div>
                    <hr class="d-lg-none">
                </div>

                <div class="col-lg-7">
                    <h1 class="product-title h2 mb-2"><?= htmlspecialchars($product['name']) ?></h1>

                    <div class="d-flex align-items-center mb-3 product-meta">
                        <div class="rating-stars me-2">
                            <span class="fw-bold text-warning me-1"><?= number_format($product['avg_rating'], 1) ?></span>
                            <?= render_stars($product['avg_rating']) ?>
                        </div>
                        <div class="vr"></div>
                        <div class="meta-item mx-2">
                            <span class="fw-bold"><?= $product['review_count'] ?></span> Penilaian
                        </div>
                        <div class="vr"></div>
                        <div class="meta-item ms-2">
                            <span class="fw-bold"><?= $product['total_sold'] ?></span> Terjual
                        </div>
                    </div>

                    <div class="price-section bg-light p-3 rounded-3 mb-4">
                        <span class="old-price text-muted text-decoration-line-through">Rp<?= number_format($product['price'] * 1.2, 0, ',', '.') ?></span>
                        <span class="current-price h3 fw-bold text-success ms-2">Rp<?= number_format($product['price'], 0, ',', '.') ?></span>
                        <span class="badge bg-danger ms-2">-20%</span>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-3 col-form-label">Kuantitas</label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <div class="input-group quantity-selector" style="width: 150px;">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                                <input type="text" class="form-control text-center" value="1" readonly>
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                            <span class="ms-3 text-muted">Tersedia: <?= $product['stock'] ?></span>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-outline-success btn-lg add-to-cart-btn" data-id="<?= $product['id'] ?>">
                            <i class="fas fa-cart-plus me-2"></i>Masukkan Keranjang
                        </button>
                        <button class="btn btn-success btn-lg">Beli Sekarang</button>
                        <button class="btn btn-outline-danger btn-lg ms-2 favorite-btn">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>

            </div>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card p-4 border-0 shadow-sm">
                        <h5 class="mb-3">Penilaian Produk (<?= $product['review_count'] ?>)</h5>
                        <?php
                        // Kita perlu mengambil ulasan di sini
                        global $conn;
                        require_once __DIR__ . '/../models/Review.php';
                        $reviewModel = new Review($conn);
                        $reviews = $reviewModel->getReviewsByProductId($product['id']);
                        ?>
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-user-circle fs-4 me-2 text-muted"></i>
                                        <div>
                                            <h6 class="mb-0"><?= htmlspecialchars($review['username']) ?></h6>
                                            <small class="text-muted"><?= date('d F Y', strtotime($review['created_at'])) ?></small>
                                        </div>
                                    </div>
                                    <div class="ms-4">
                                        <?= render_stars($review['rating']) ?>
                                        <p class="mb-0 mt-2"><?= nl2br(htmlspecialchars($review['review_text'])) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Belum ada penilaian untuk produk ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">Produk tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'templates/public_footer.php'; ?>

<style>
    .product-detail-page {
        max-width: 1200px;
    }

    .main-image-container {
        border: 1px solid #eee;
        border-radius: 5px;
        overflow: hidden;
    }

    .thumbnail-container img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 2px solid #eee;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }

    .thumbnail-container img.active {
        border-color: var(--dark-primary-green);
    }

    .product-title {
        font-weight: 600;
    }

    .product-meta .vr {
        margin: 0 1rem;
    }

    .product-meta .meta-item {
        color: #555;
    }

    .price-section .old-price {
        font-size: 1rem;
    }

    .price-section .current-price {
        font-size: 1.8rem;
    }

    .quantity-selector input {
        border-left: 0;
        border-right: 0;
    }

    .quantity-selector .btn {
        border-radius: 0;
    }

    .action-buttons .btn {
        padding: 0.75rem 1.25rem;
    }

    .favorite-btn.favorited i {
        font-weight: 900;
        /* Mengubah ikon menjadi solid */
    }
</style>