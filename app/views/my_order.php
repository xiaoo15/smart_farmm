<?php 
$title = "Riwayat Pesanan Saya"; 
include 'templates/public_header.php'; 
?>

<div class="container my-5">
    <h2 class="mb-4">Riwayat Pesanan Saya</h2>

    <?php if (isset($transactions) && mysqli_num_rows($transactions) > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($transactions)): ?>
                    <tr>
                        <td>#<?= $row['id'] ?></td>
                        <td><?= date('d F Y, H:i', strtotime($row['transaction_date'])) ?></td>
                        <td class="text-end fw-bold">Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <a href="index.php?action=orderDetails&id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-center p-5 border rounded">
            <h3>Anda Belum Punya Riwayat Pesanan</h3>
            <p class="text-muted">Yuk, mulai belanja produk segar dari kebun kami!</p>
            <a href="index.php?action=home#katalog" class="btn btn-primary mt-2">Mulai Belanja</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'templates/public_footer.php'; ?>