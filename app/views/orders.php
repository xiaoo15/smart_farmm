<?php
// File: app/views/orders.php (FILE BARU!)
$title = "Manajemen Pesanan";
global $action;
?>

<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>
        <?php include 'templates/header.php'; ?>

    <div class="content-wrapper">
        <main class="p-4">
            <h1 class="h2 mb-4">Manajemen Pesanan</h1>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center">Metode Bayar</th>
                                    <th class="text-center" style="width: 200px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($transactions) && !empty($transactions)): ?>
                                    <?php foreach($transactions as $trx): ?>
                                    <tr>
                                        <td class="fw-bold">#<?= $trx['id'] ?></td>
                                        <td><?= htmlspecialchars($trx['username']) ?></td>
                                        <td><?= date('d M Y, H:i', strtotime($trx['transaction_date'])) ?></td>
                                        <td class="text-end">Rp<?= number_format($trx['total_price'], 0, ',', '.') ?></td>
                                        <td class="text-center"><span class="badge bg-info text-dark"><?= htmlspecialchars($trx['payment_method']) ?></span></td>
                                        <td class="text-center">
                                            <select class="form-select form-select-sm status-dropdown" data-id="<?= $trx['id'] ?>">
                                                <option value="Menunggu Pembayaran" <?= $trx['payment_status'] == 'Menunggu Pembayaran' ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                                                <option value="Diproses" <?= $trx['payment_status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                                <option value="Dikirim" <?= $trx['payment_status'] == 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                                <option value="Selesai" <?= $trx['payment_status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                <option value="Dibatalkan" <?= $trx['payment_status'] == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="text-center p-5 text-muted">Belum ada pesanan yang masuk.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include 'templates/footer.php'; ?>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-dropdown').forEach(dropdown => {
                dropdown.addEventListener('change', async function() {
                    const transactionId = this.dataset.id;
                    const newStatus = this.value;

                    try {
                        const response = await fetch('index.php?action=updateOrderStatus', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `id=${transactionId}&status=${newStatus}`
                        });

                        const result = await response.json();
                        if (result.success) {
                            // Mungkin tambahkan notifikasi sukses di sini
                            console.log("Status berhasil diupdate!");
                        } else {
                            alert('Gagal mengupdate status: ' + result.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghubungi server.');
                    }
                });
            });
        });
        </script>
    </div>
</div>