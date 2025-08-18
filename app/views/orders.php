<?php
// File: app/views/orders.php (VERSI DENGAN KONFIRMASI 'SELESAI')
$title = "Manajemen Pesanan";
global $action;
?>

<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <div class="content-wrapper">
        <?php include 'templates/header.php'; ?>
        <main class="p-4">
            <h1 class="h2 mb-4">Manajemen Pesanan</h1>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div id="status-update-alert" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        Status pesanan berhasil diperbarui!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Bukti Bayar</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-center" style="width: 200px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($transactions) && !empty($transactions)): ?>
                                    <?php foreach ($transactions as $trx): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= $trx['id'] ?></td>
                                            <td><?= htmlspecialchars($trx['username']) ?></td>
                                            <td><?= date('d M Y, H:i', strtotime($trx['transaction_date'])) ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($trx['payment_proof'])): ?>
                                                    <a href="#" class="view-proof-btn" data-bs-toggle="modal" data-bs-target="#proofModal" data-proof-image="../public/images/proofs/<?= htmlspecialchars($trx['payment_proof']) ?>">
                                                        <img src="../public/images/proofs/<?= htmlspecialchars($trx['payment_proof']) ?>" alt="Proof" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Belum ada</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">Rp<?= number_format($trx['total_price'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <select class="form-select form-select-sm status-dropdown" data-id="<?= $trx['id'] ?>" data-current-status="<?= $trx['payment_status'] ?>">
                                                    <option value="Menunggu Pembayaran" <?= $trx['payment_status'] == 'Menunggu Pembayaran' ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                                                    <option value="Menunggu Konfirmasi" <?= $trx['payment_status'] == 'Menunggu Konfirmasi' ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                                                    <option value="Diproses" <?= $trx['payment_status'] == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="Dikirim" <?= $trx['payment_status'] == 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                                    <option value="Selesai" <?= $trx['payment_status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                    <option value="Dibatalkan" <?= $trx['payment_status'] == 'Dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center p-5 text-muted">Belum ada pesanan yang masuk.</td>
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

<div class="modal fade" id="proofModal" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proofModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="full-proof-image" class="img-fluid" alt="Bukti Pembayaran Penuh">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusAlert = document.getElementById('status-update-alert');

        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const transactionId = this.dataset.id;
                const newStatus = this.value;
                const oldStatus = this.dataset.currentStatus;
                const dropdownElement = this;

                // =============================================
                // INI DIA LOGIKA KONFIRMASINYA, REVAN!
                // =============================================
                if (newStatus === 'Selesai') {
                    const confirmation = confirm(`Anda YAKIN ingin menyelesaikan pesanan #${transactionId}? Aksi ini tidak dapat dibatalkan dan akan membuka fitur penilaian untuk customer.`);

                    // Jika admin klik "Cancel"
                    if (!confirmation) {
                        this.value = oldStatus; // Kembalikan dropdown ke status semula
                        return; // Hentikan eksekusi script
                    }
                }

                // Jika status bukan 'Selesai' atau jika admin klik "OK", lanjutkan update
                updateStatus(transactionId, newStatus, dropdownElement);
            });
        });

        async function updateStatus(transactionId, newStatus, dropdownElement) {
            try {
                const response = await fetch('index.php?action=updateOrderStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${transactionId}&status=${newStatus}`
                });

                const result = await response.json();
                if (result.success) {
                    statusAlert.style.display = 'block';
                    dropdownElement.dataset.currentStatus = newStatus;
                    setTimeout(() => {
                        statusAlert.style.display = 'none';
                    }, 3000);
                } else {
                    alert('Gagal mengupdate status: ' + result.message);
                    dropdownElement.value = dropdownElement.dataset.currentStatus;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghubungi server.');
                dropdownElement.value = dropdownElement.dataset.currentStatus;
            }
        }

        // Script untuk modal (biarkan sama)
        const proofModal = document.getElementById('proofModal');
        if (proofModal) {
            proofModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const imageUrl = button.getAttribute('data-proof-image');
                const modalImage = proofModal.querySelector('#full-proof-image');
                modalImage.src = imageUrl;
            });
        }
    });
</script>