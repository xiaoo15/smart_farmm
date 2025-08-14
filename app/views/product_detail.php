<?php
// File: app/views/product_detail.php (VERSI FINAL DENGAN DESKRIPSI ASLI)
$title = isset($product['name']) ? htmlspecialchars($product['name']) : "Detail Produk";
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

<div class="container my-5 pt-4">
    <div class="mb-4">
        <a href="index.php?action=allProducts" class="btn btn-light border shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Katalog
        </a>
    </div>

    <?php if (isset($product) && $product): ?>
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm mb-2">
                    <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top img-fluid rounded-4" alt="Gambar Produk Utama">
                </div>
            </div>

            <div class="col-lg-7">
                <h1 class="h2 mb-3 fw-bold"><?= htmlspecialchars($product['name']) ?></h1>
                <div class="d-flex align-items-center text-muted mb-3">
                    <span>Stok: <span class="fw-semibold text-dark"><?= htmlspecialchars($product['stock']) ?></span></span>
                    <span class="mx-2">|</span>
                    <span>Kategori: <a href="index.php?action=allProducts" class="badge bg-success text-decoration-none"><?= htmlspecialchars($product['kategori']) ?></a></span>
                </div>
                <div class="bg-light p-3 mb-4 rounded-3">
                    <div class="h2 fw-bold text-success mb-0">Rp<?= number_format($product['price'], 0, ',', '.') ?></div>
                </div>

                <div class="col-lg-7">
                    <div class="mb-4">
                        <p class="mb-2 fw-bold">Deskripsi Singkat</p>
                        <p class="text-muted">
                            <?= !empty($product['short_description']) ? htmlspecialchars($product['short_description']) : 'Deskripsi singkat belum tersedia.' ?>
                        </p>
                    </div>
                    <div class="d-flex flex-column flex-sm-row">
                        <?php
                        $isStokHabis = ($product['stock'] <= 0);
                        $tombolClass = $isStokHabis ? 'btn-outline-secondary' : 'btn-success';
                        $tombolTeks = $isStokHabis ? 'Stok Habis' : 'Masukkan Keranjang';
                        $tombolDisabled = $isStokHabis ? 'disabled' : '';
                        ?>
                        <button class="btn <?= $tombolClass ?> btn-lg me-sm-2 mb-2 mb-sm-0 add-to-cart-btn" data-id="<?= $product['id'] ?>" <?= $tombolDisabled ?>>
                            <?= $tombolTeks ?>
                        </button>
                    </div>
                </div>
            </div>

            <hr class="my-5">
            <div class="row">
                <div class="col-12">
                    <div class="card p-4 border-0 shadow-sm">
                        <h5 class="mb-3">Deskripsi Lengkap Produk</h5>
                        <?php if (!empty($product['description'])): ?>
                            <p>
                                <?= nl2br(htmlspecialchars($product['description'])) ?>
                            </p>
                        <?php else: ?>
                            <p class="text-muted">Belum ada deskripsi lengkap untuk produk ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php else: ?>
        <?php endif; ?>
        </div>

        <?php
        // Panggil footer yang ada "otak" JavaScript-nya
        include 'templates/public_footer.php';
        ?>