<?php
// File: app/views/payment.php (FILE BARU!)
$title = "Lakukan Pembayaran";
include 'templates/public_header.php';
?>

<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <?php if (isset($transaction) && $transaction): ?>
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header text-center bg-white py-3">
                    <h2 class="h4 mb-0">Selesaikan Pembayaran Anda</h2>
                    <p class="text-muted mb-0">ID Pesanan Anda: #<?= htmlspecialchars($transaction['id']) ?></p>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-warning">
                        <strong>PENTING:</strong> Selesaikan pembayaran dalam <strong>1x24 jam</strong> atau pesanan Anda akan otomatis dibatalkan.
                    </div>

                    <div class="text-center my-4">
                        <p class="mb-2">Total yang harus dibayar:</p>
                        <h1 class="display-5 fw-bold text-success">Rp<?= number_format($transaction['total_price'], 0, ',', '.') ?></h1>
                    </div>

                    <?php if ($transaction['payment_method'] == 'QRIS'): ?>
                        <div id="qris-payment" class="text-center p-3 border rounded-3">
                            <h5 class="mb-3">Scan QR Code di Bawah Ini</h5>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=SMARTFARM-<?= $transaction['id'] ?>-<?= $transaction['total_price'] ?>" alt="QR Code Pembayaran" class="img-fluid">
                            <p class="mt-3 text-muted small">Gunakan aplikasi e-wallet (GoPay, OVO, Dana, dll) atau mobile banking Anda.</p>
                        </div>
                    <?php else: // (payment_method == 'Bank Transfer') ?>
                        <div id="bank-transfer-payment" class="p-3 border rounded-3">
                            <h5 class="mb-3">Transfer ke Virtual Account Berikut</h5>
                            <p class="mb-1">Bank Tujuan: <strong>Bank SmartFarm (Kode: 007)</strong></p>
                            <p class="mb-1">Nomor Virtual Account:</p>
                            <div class="input-group">
                                <input type="text" class="form-control" value="8808<?= date('md') . $transaction['user_id'] . $transaction['id'] ?>" readonly>
                                <button class="btn btn-outline-secondary" onclick="copyToClipboard(this)">Copy</button>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <hr class="my-4">

                    <h5 class="mb-3">Konfirmasi Pembayaran</h5>
                    <form action="index.php?action=handlePaymentProof" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Upload Bukti Transfer</label>
                            <input class="form-control" type="file" id="payment_proof" name="payment_proof" required>
                            <div class="form-text">Upload screenshot atau foto bukti pembayaran Anda (JPG, PNG).</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Saya Sudah Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h2 class="text-danger">Oops! Transaksi Tidak Ditemukan.</h2>
                    <a href="index.php?action=home" class="btn btn-success mt-3">Kembali ke Beranda</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'templates/public_footer.php'; ?>

<script>
// Fungsi kecil buat tombol "Copy"
function copyToClipboard(button) {
    const input = button.previousElementSibling;
    input.select();
    document.execCommand('copy');
    button.textContent = 'Copied!';
    setTimeout(() => { button.textContent = 'Copy'; }, 2000);
}
</script>