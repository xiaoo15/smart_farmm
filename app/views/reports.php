<?php
$title = "Laporan Penjualan";
global $action;
// Ambil tanggal filter untuk ditampilkan kembali di form
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
?>

<div class="d-flex">
    <?php include 'templates/sidebar.php'; ?>
    <div class="flex-grow-1">
        <?php include 'templates/header.php'; ?>
        <main class="p-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Laporan Penjualan</h1>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <form class="row g-3 align-items-center" method="GET">
                        <input type="hidden" name="action" value="reports">
                        <div class="col-auto">
                            <label for="start_date" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $start_date ?>">
                        </div>
                        <div class="col-auto">
                            <label for="end_date" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $end_date ?>">
                        </div>
                        <div class="col-auto mt-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="index.php?action=reports" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($transactions) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($transactions)): ?>
                            <tr>
                                <td>#<?= $row['id'] ?></td>
                                <td><?= date('d M Y, H:i', strtotime($row['transaction_date'])) ?></td>
                                <td class="fw-bold">Rp <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm view-details-btn" data-id="<?= $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#detailsModal">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center">Tidak ada data transaksi pada periode ini.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include 'templates/footer.php'; ?>
    </div>
</div>

<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailsModalLabel">Detail Transaksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="transaction-details-content">
            <p class="text-center">Memuat data...</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsModal = document.getElementById('detailsModal');
    detailsModal.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const transactionId = button.getAttribute('data-id');
        const modalBody = document.getElementById('transaction-details-content');
        modalBody.innerHTML = '<p class="text-center">Memuat data...</p>';

        try {
            const response = await fetch(`index.php?action=getDetails&id=${transactionId}`);
            const items = await response.json();
            
            let content = '<table class="table"><thead><tr><th>Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Subtotal</th></tr></thead><tbody>';
            let total = 0;
            items.forEach(item => {
                const subtotal = item.quantity * item.price;
                total += subtotal;
                content += `
                    <tr>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${formatRupiah(item.price)}</td>
                        <td>${formatRupiah(subtotal)}</td>
                    </tr>
                `;
            });
            content += `</tbody><tfoot><tr class="fw-bold"><td colspan="3">Total</td><td>${formatRupiah(total)}</td></tr></tfoot></table>`;
            modalBody.innerHTML = content;

        } catch (error) {
            modalBody.innerHTML = '<p class="text-center text-danger">Gagal memuat detail.</p>';
            console.error('Error fetching details:', error);
        }
    });

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }
});
</script>