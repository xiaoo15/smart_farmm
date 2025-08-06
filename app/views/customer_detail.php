<?php
// File: app/views/customer_detail.php (FILE BARU!)
$title = "Detail Pelanggan";
global $action;
?>

<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>
    <?php include 'templates/header.php'; ?>


    <div class="content-wrapper">
        <main class="p-4">
            <a href="index.php?action=customers" class="btn btn-light border shadow-sm mb-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pelanggan
            </a>
            <h1 class="h2 mb-4">Riwayat Pesanan Pelanggan</h1>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pesanan untuk ID Pelanggan: #<?= htmlspecialchars($_GET['id']) ?></h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center">Metode Bayar</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($transactions) && !empty($transactions)): ?>
                                    <?php foreach ($transactions as $trx): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= $trx['id'] ?></td>
                                            <td><?= date('d M Y, H:i', strtotime($trx['transaction_date'])) ?></td>
                                            <td class="text-end">Rp<?= number_format($trx['total_price'], 0, ',', '.') ?></td>
                                            <td class="text-center"><span class="badge bg-info text-dark"><?= htmlspecialchars($trx['payment_method']) ?></span></td>
                                            <td class="text-center"><span class="badge bg-success"><?= htmlspecialchars($trx['payment_status']) ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center p-5 text-muted">Pelanggan ini belum pernah melakukan transaksi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include 'templates/footer.php'; ?>
    </div>
</div>