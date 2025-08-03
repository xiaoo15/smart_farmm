<?php
// File: app/views/product_detail.php (VERSI FINAL DENGAN TOMBOL AKTIF)
$title = isset($product['name']) ? htmlspecialchars($product['name']) : "Detail Produk";
include 'templates/public_header.php';
?>

<!-- "Rumah" Notifikasi, wajib ada -->
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

<div class="container my-5 pt-5">
    <?php if (isset($product) && $product): ?>
        <div class="row">
            <!-- Bagian Kiri: Galeri Gambar -->
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm mb-2">
                    <img src="public/images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top img-fluid rounded-4" alt="Gambar Produk Utama">
                </div>
            </div>

            <!-- Bagian Kanan: Info & Aksi -->
            <div class="col-lg-7">
                <h1 class="h2 mb-3 fw-bold"><?= htmlspecialchars($product['name']) ?></h1>

                <div class="d-flex align-items-center text-muted mb-3">
                    <span>Stok: <span class="fw-semibold text-dark"><?= htmlspecialchars($product['stock']) ?></span></span>
                    <span class="mx-2">|</span>
                    <span>Kategori: <a href="index.php?action=allProducts" class="badge bg-success text-decoration-none"><?= htmlspecialchars($product['kategori']) ?></a></span>
                </div>

                <div class="bg-light p-3 mb-4 rounded-3">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="h2 fw-bold text-success mb-0">Rp<?= number_format($product['price'], 0, ',', '.') ?></div>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="mb-2 fw-bold">Deskripsi Singkat</p>
                    <p class="text-muted">
                        <!-- Kamu bisa tambahkan kolom 'deskripsi' di database nanti -->
                        Ini adalah deskripsi singkat produk. Untuk detail lengkap, silakan lihat di bawah. Tanaman ini dijamin segar dan dirawat dengan metode smart farming terbaik.
                    </p>
                </div>

                <div class="d-flex flex-column flex-sm-row">
                    <?php
                    $isStokHabis = ($product['stock'] <= 0);
                    $tombolClass = $isStokHabis ? 'btn-outline-secondary' : 'btn-success';
                    $tombolTeks = $isStokHabis ? 'Stok Habis' : 'Masukkan Keranjang';
                    $tombolDisabled = $isStokHabis ? 'disabled' : '';
                    ?>
                    <!-- INI DIA TOMBOL YANG KITA BENERIN! -->
                    <button class="btn <?= $tombolClass ?> btn-lg me-sm-2 mb-2 mb-sm-0 add-to-cart-btn" data-id="<?= $product['id'] ?>" <?= $tombolDisabled ?>>
                        <?= $tombolTeks ?>
                    </button>
                </div>
            </div>
        </div>

        <!-- Bagian Deskripsi Lengkap -->
        <hr class="my-5">
        <div class="row">
            <div class="col-12">
                <div class="card p-4 border-0 shadow-sm">
                    <h5 class="mb-3">Deskripsi Lengkap Produk</h5>
                    <p>
                        Detail lengkap tentang <?= htmlspecialchars($product['name']) ?>. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <h2 class="text-danger">Oops! Produk Tidak Ditemukan.</h2>
            <p class="text-muted">Produk yang kamu cari mungkin sudah tidak ada atau link-nya salah.</p>
            <a href="index.php?action=allProducts" class="btn btn-success mt-3">Kembali ke Katalog</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/public_footer.php'; ?>