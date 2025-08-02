<?php
// File: app/views/checkout.php (VERSI PERBAIKAN FINAL)

// ===================================================================
// BAGIAN LOGIKA (DIPINDAH KE PALING ATAS, SEBELUM HTML APAPUN)
// ===================================================================

// Ambil koneksi database dan model yang dibutuhkan
global $conn;
require_once __DIR__ . '/../models/Product.php'; // Pastikan path ini benar

// Cek dulu keranjangnya. Kalau kosong, langsung usir dari sekarang!
if (empty($_SESSION['cart'])) {
    header('Location: index.php?action=home'); // Ini aman karena belum ada HTML yang dikirim
    exit;
}

// Kalau keranjang ada isinya, baru kita proses datanya
$productModel = new Product($conn);
$cart_items = [];
$total_price = 0;
$product_ids = array_keys($_SESSION['cart']);
$products_in_cart = $productModel->getProductsByIds($product_ids);

foreach ($products_in_cart as $product) {
    $quantity = $_SESSION['cart'][$product['id']];
    $subtotal = $product['price'] * $quantity;
    $cart_items[] = ['name' => $product['name'], 'quantity' => $quantity, 'subtotal' => $subtotal];
    $total_price += $subtotal;
}

// ===================================================================
// BAGIAN TAMPILAN (HTML DIMULAI DARI SINI)
// ===================================================================
$title = "Checkout";
include 'templates/public_header.php';
?>

<div class="container my-5">
    <div class="row g-5">
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Proses Checkout</h4>
            <form action="index.php?action=processCheckout" method="POST" id="checkout-form">
                <h5 class="mb-3">Pilih Metode Pembayaran</h5>

                <div class="my-3">
                    <div class="form-check">
                        <input id="qris" name="payment_method" type="radio" class="form-check-input" value="QRIS" required>
                        <label class="form-check-label" for="qris">QRIS (QR Code)</label>
                    </div>
                    <div class="form-check">
                        <input id="cod" name="payment_method" type="radio" class="form-check-input" value="COD" required>
                        <label class="form-check-label" for="cod">Bayar di Tempat (COD)</label>
                    </div>
                </div>

                <div id="qris-payment-details" class="card mt-4" style="display: none;">
                    <div class="card-body text-center">
                        <p>Silakan scan QR Code di bawah ini:</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://github.com/xiaoo15" alt="QR Code Palsu">
                        <p class="mt-2 fw-bold">Total: Rp <?= number_format($total_price, 0, ',', '.') ?></p>
                        <small class="text-muted">Ini hanya simulasi. Klik "Buat Pesanan" untuk melanjutkan.</small>
                    </div>
                </div>
                
                <div id="cod-payment-details" class="alert alert-info mt-4" style="display: none;">
                    Pastikan Anda menyiapkan uang pas sebesar <strong>Rp <?= number_format($total_price, 0, ',', '.') ?></strong> saat kurir kami tiba.
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-success btn-lg" type="submit">Buat Pesanan</button>
            </form>
        </div>

        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Ringkasan Belanja</span>
                <span class="badge bg-primary rounded-pill"><?= count($cart_items) ?></span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach($cart_items as $item): ?>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
                        <small class="text-muted">Jumlah: <?= $item['quantity'] ?></small>
                    </div>
                    <span class="text-muted">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                </li>
                <?php endforeach; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (IDR)</span>
                    <strong>Rp <?= number_format($total_price, 0, ',', '.') ?></strong>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php include 'templates/public_footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const qrisDetails = document.getElementById('qris-payment-details');
    const codDetails = document.getElementById('cod-payment-details');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            qrisDetails.style.display = (this.value === 'QRIS') ? 'block' : 'none';
            codDetails.style.display = (this.value === 'COD') ? 'block' : 'none';
        });
    });
});
</script>