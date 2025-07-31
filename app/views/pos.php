<?php
$title = "Sistem Kasir (POS)";
global $action;
?>
<div class="d-flex">
    <?php include 'templates/sidebar.php'; ?>
    <div class="flex-grow-1">
        <?php include 'templates/header.php'; ?>
        <main class="p-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sistem Kasir (POS)</h1>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="input-group mb-3">
                        <span class="input-group-text">🔍</span>
                        <input type="text" id="product-search" class="form-control" placeholder="Cari produk...">
                    </div>
                    <div id="product-list" class="row" style="max-height: 70vh; overflow-y: auto;">
                        <?php while ($product = mysqli_fetch_assoc($products)): ?>
                        <div class="col-md-4 mb-3 product-card" data-name="<?= strtolower(htmlspecialchars($product['name'])) ?>">
                            <div class="card h-100" style="cursor: pointer;" onclick="addToCart(<?= htmlspecialchars(json_encode($product)) ?>)">
                                <img src="images/products/<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1"><?= htmlspecialchars($product['name']) ?></h6>
                                    <p class="card-text fw-bold text-success">Rp <?= number_format($product['price']) ?></p>
                                    <small class="text-muted">Stok: <?= $product['stock'] ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header fw-bold">Keranjang Belanja</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    </tbody>
                            </table>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>TOTAL</span>
                                <span id="cart-total">Rp 0</span>
                            </div>
                            <div class="d-grid mt-3">
                                <button id="process-payment-btn" class="btn btn-primary btn-lg" disabled>Proses Pembayaran</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'templates/footer.php'; ?>
        <script src="js/pos.js"></script>
    </div>
</div>