<?php 
$title = "Riwayat Pesanan Saya"; 
include 'templates/public_header.php'; 
?>

<style>
    .order-card {
        transition: all 0.2s ease-in-out;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    .order-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .status-badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.5em 0.75em;
    }
    .product-item-in-order {
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .product-item-in-order:last-child {
        border-bottom: none;
    }
    .product-item-in-order img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
    }
    .order-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
</style>

<div class="container my-5">
    <h1 class="display-6 fw-bold mb-4">Riwayat Pesanan Saya</h1>

    <?php if(isset($_GET['payment_success'])): ?>
        <div class="alert alert-success"><strong>Konfirmasi Terkirim!</strong> Pembayaranmu sedang kami verifikasi. Terima kasih!</div>
    <?php endif; ?>
    <?php if(isset($_GET['review_success'])): ?>
        <div class="alert alert-success"><strong>Terima Kasih!</strong> Penilaian Anda berhasil dikirim.</div>
    <?php endif; ?>

    <?php if (isset($transactions) && !empty($transactions)): ?>
        <?php foreach($transactions as $trx): ?>
        <div class="card shadow-sm border-0 mb-4 order-card">
            <div class="card-header order-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-receipt me-2 text-muted"></i>
                    <strong>Pesanan #<?= $trx['id'] ?></strong>
                    <span class="text-muted ms-2"><?= date('d F Y', strtotime($trx['transaction_date'])) ?></span>
                </div>
                <span class="badge rounded-pill text-bg-success status-badge"><?= htmlspecialchars($trx['payment_status']) ?></span>
            </div>

            <div class="card-body p-0">
                <?php foreach($trx['items'] as $item): ?>
                <div class="product-item-in-order d-flex align-items-center px-3">
                    <img src="public/images/products/<?= htmlspecialchars($item['product_image'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($item['product_name'] ?? 'Nama Produk') ?>" class="me-3">
                    <div class="flex-grow-1">
                        <h6 class="mb-0"><?= htmlspecialchars($item['product_name']) ?></h6>
                        <small class="text-muted">Jumlah: <?= $item['quantity'] ?></small>
                    </div>
                    <div class="text-end">
                        <span class="text-muted">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card-footer order-footer d-flex flex-column flex-sm-row justify-content-end align-items-sm-center text-end">
                <div class="mb-2 mb-sm-0 me-sm-3">
                    <span class="text-muted">Total Pesanan:</span>
                    <strong class="fs-5 ms-2">Rp <?= number_format($trx['total_price'], 0, ',', '.') ?></strong>
                </div>
                <div>
                    <?php if ($trx['payment_status'] == 'Menunggu Pembayaran'): ?>
                        <a href="index.php?action=showPayment&id=<?= $trx['id'] ?>" class="btn btn-danger">Bayar Sekarang</a>
                    <?php elseif ($trx['payment_status'] == 'Selesai'): ?>
                        <a href="index.php?action=showReviewPage&order_id=<?= $trx['id'] ?>" class="btn btn-warning">Beri Penilaian</a>
                    <?php endif; ?>
                    <a href="index.php?action=orderDetails&id=<?= $trx['id'] ?>" class="btn btn-outline-secondary">Lihat Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center p-5 border rounded bg-white">
            <h3 class="fw-bold">Anda Belum Punya Riwayat Pesanan</h3>
            <p class="text-muted">Yuk, mulai belanja produk segar dari kebun kami!</p>
            <a href="index.php?action=home" class="btn btn-success mt-2">Mulai Belanja</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/public_footer.php'; ?>