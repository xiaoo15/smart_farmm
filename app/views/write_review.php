<?php
// File: app/views/write_review.php (VERSI PERBAIKAN FINAL)
$title = "Beri Penilaian";
include 'templates/public_header.php';
?>

<div class="container my-5">
    <h1 class="display-6 fw-bold mb-4">Beri Penilaian</h1>
    <p class="text-muted">Pesanan Anda telah selesai. Silakan berikan penilaian untuk produk yang Anda beli.</p>

    <?php if (isset($items) && !empty($items)): ?>
        <?php foreach ($items as $item): // Loop untuk setiap produk dalam pesanan 
        ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form action="index.php?action=submitReview" method="POST">
                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">

                        <div class="d-flex mb-3">
                            <img src="public/images/products/<?= htmlspecialchars($item['product_image'] ?? 'default.jpg') ?>" style="width: 80px; height: 80px; object-fit: cover;" class="rounded me-3">
                            <div>
                                <h5 class="mb-0"><?= htmlspecialchars($item['product_name']) ?></h5>
                                <p class="text-muted mb-0">Bagaimana kualitas produk ini?</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating Anda:</label>
                            <div class="rating-stars-input" data-form-id="<?= $item['product_id'] ?>">
                                <i class="far fa-star" data-value="1" title="Sangat Buruk"></i>
                                <i class="far fa-star" data-value="2" title="Buruk"></i>
                                <i class="far fa-star" data-value="3" title="Cukup"></i>
                                <i class="far fa-star" data-value="4" title="Baik"></i>
                                <i class="far fa-star" data-value="5" title="Sangat Baik"></i>
                            </div>
                            <input type="hidden" name="rating" class="rating-value" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="review_text_<?= $item['product_id'] ?>" class="form-label">Ulasan Anda (Opsional):</label>
                            <textarea name="review_text" id="review_text_<?= $item['product_id'] ?>" class="form-control" rows="3" placeholder="Bagikan pengalamanmu tentang produk ini..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Kirim Penilaian</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Produk tidak ditemukan dalam pesanan ini.</p>
    <?php endif; ?>
</div>

<style>
    .rating-stars-input i {
        font-size: 2.2rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s, transform 0.2s;
        padding: 0 5px;
    }

    .rating-stars-input i:hover {
        transform: scale(1.2);
    }

    .rating-stars-input i.hover,
    .rating-stars-input i.selected {
        color: #ffc107;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Loop setiap blok rating agar tidak bentrok
        document.querySelectorAll('.rating-stars-input').forEach(starContainer => {
            const stars = starContainer.querySelectorAll('i');
            const ratingInput = starContainer.parentElement.querySelector('.rating-value');

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    // Highlight bintang saat di-hover
                    resetStars(stars);
                    const currentValue = this.dataset.value;
                    for (let i = 0; i < currentValue; i++) {
                        stars[i].classList.add('hover');
                    }
                });

                star.addEventListener('mouseout', function() {
                    // Hapus highlight hover, kembalikan ke state `selected`
                    resetStars(stars);
                    const selectedValue = ratingInput.value;
                    if (selectedValue > 0) {
                        for (let i = 0; i < selectedValue; i++) {
                            stars[i].classList.add('selected');
                        }
                    }
                });

                star.addEventListener('click', function() {
                    // Set nilai rating saat bintang di-klik
                    const ratingValue = this.dataset.value;
                    ratingInput.value = ratingValue;

                    resetStars(stars, true); // Hapus semua kelas 'selected' dulu

                    // Tambahkan kelas 'selected' sesuai rating yang dipilih
                    for (let i = 0; i < ratingValue; i++) {
                        stars[i].classList.add('selected');
                    }
                });
            });
        });

        function resetStars(stars, removeSelected = false) {
            stars.forEach(s => {
                s.classList.remove('hover');
                if (removeSelected) s.classList.remove('selected');
            });
        }
    });
</script>

<?php include 'templates/public_footer.php'; ?>