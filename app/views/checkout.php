<?php
// ... (kode PHP di atas biarkan sama) ...
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
                        <input id="qris" name="payment_method" type="radio" class="form-check-input" value="QRIS" required checked>
                        <label class="form-check-label" for="qris">QRIS (Scan untuk Bayar)</label>
                    </div>
                    <div class="form-check">
                        <input id="bank_transfer" name="payment_method" type="radio" class="form-check-input" value="Bank Transfer" required>
                        <label class="form-check-label" for="bank_transfer">Transfer Bank (Virtual Account)</label>
                    </div>
                </div>

                <hr class="my-4">

                <p class="text-muted">Dengan menekan tombol di bawah, Anda akan membuat pesanan dan diarahkan ke halaman pembayaran.</p>
                <button class="w-100 btn btn-success btn-lg" type="submit">Buat Pesanan & Lanjut Bayar</button>
            </form>
        </div>

        </div>
</div>

<?php include 'templates/public_footer.php'; ?>