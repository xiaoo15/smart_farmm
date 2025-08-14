<?php 
$title = "Riwayat Pesanan Saya"; 
include 'templates/public_header.php'; 
?>

<div class="container my-5">
    <h2 class="mb-4">Riwayat Pesanan Saya</h2>

    <?php if(isset($_GET['payment_success'])): ?>
        <div class="alert alert-success">
            <strong>Konfirmasi Terkirim!</strong> Pembayaranmu sedang kami verifikasi. Terima kasih!
        </div>
    <?php endif; ?>

    <?php if (isset($transactions) && !empty($transactions)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transactions as $row): ?>
                    <tr>
                        <td class="fw-bold">#<?= $row['id'] ?></td>
                        <td><?= date('d F Y, H:i', strtotime($row['transaction_date'])) ?></td>
                        <td class="text-end fw-bold">Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        
                        <td class="text-center">
                            <span class="badge 
                                <?php 
                                    // Logika buat ganti warna badge sesuai status
                                    switch($row['payment_status']) {
                                        case 'Selesai': echo 'bg-success'; break;
                                        case 'Dikirim': echo 'bg-info text-dark'; break;
                                        case 'Diproses': echo 'bg-primary'; break;
                                        case 'Dibatalkan': echo 'bg-danger'; break;
                                        default: echo 'bg-warning text-dark'; // Untuk Menunggu Pembayaran & Menunggu Konfirmasi
                                    }
                                ?>
                            "><?= htmlspecialchars($row['payment_status']) ?></span>
                        </td>
                        
                        <td class="text-center">
                            <?php if ($row['payment_status'] == 'Menunggu Pembayaran'): ?>
                                <a href="index.php?action=showPayment&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Bayar Sekarang</a>
                            <?php else: ?>
                                <a href="index.php?action=orderDetails&id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center p-5 border rounded">
            <h3>Anda Belum Punya Riwayat Pesanan</h3>
            <p class="text-muted">Yuk, mulai belanja produk segar dari kebun kami!</p>
            <a href="index.php?action=home#katalog" class="btn btn-success mt-2">Mulai Belanja</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/public_footer.php'; ?>