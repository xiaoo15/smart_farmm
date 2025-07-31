<?php 
$title = "Detail Pesanan"; 
include 'templates/public_header.php'; 

// Ambil data dari item pertama untuk info umum (tanggal & total)
$first_item = $details[0];
$total_price = 0;
?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=myOrders">Riwayat Pesanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pesanan #<?= htmlspecialchars($_GET['id']) ?></li>
        </ol>
    </nav>
    
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success">
            <strong>Transaksi Berhasil!</strong> Terima kasih telah berbelanja di SmartFarm.
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>ID Pesanan: <strong>#<?= htmlspecialchars($_GET['id']) ?></strong></span>
            <span>Tanggal: <strong><?= date('d F Y', strtotime($first_item['transaction_date'])) ?></strong></span>
        </div>
        <div class="card-body">
            <h5 class="card-title">Rincian Produk</h5>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <?php foreach($details as $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; $total_price += $subtotal; ?>
                        <tr>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="text-end">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-end">
            <h5 class="mb-0">Total Belanja: <span class="text-success fw-bold">Rp <?= number_format($total_price, 0, ',', '.') ?></span></h5>
        </div>
    </div>
</div>

<?php include 'templates/public_footer.php'; ?>