<?php
// File: app/views/dashboard.php (VERSI COMMAND CENTER)
$title = "Dashboard";
global $action;
?>

<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <div class="content-wrapper">
        <?php include 'templates/header.php'; ?>
        
        <main class="p-4">
            <h1 class="h2 mb-4">Dashboard</h1>

            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card stat-card h-100">
                        <div class="card-body">
                            <div class="stat-icon bg-success"><i class="fas fa-dollar-sign"></i></div>
                            <div>
                                <h6 class="card-title">Penjualan Hari Ini</h6>
                                <p class="card-text">Rp <?= number_format($stats['todays_sales'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card stat-card h-100">
                         <div class="card-body">
                            <div class="stat-icon bg-warning text-dark"><i class="fas fa-exclamation-triangle"></i></div>
                            <div>
                                <h6 class="card-title">Produk Stok Menipis</h6>
                                <p class="card-text"><?= $stats['low_stock_products'] ?> Jenis</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                     <div class="card stat-card h-100">
                         <div class="card-body">
                            <div class="stat-icon bg-info"><i class="fas fa-receipt"></i></div>
                            <div>
                                <h6 class="card-title">Total Transaksi</h6>
                                <p class="card-text"><?= $stats['total_transactions'] ?> Pesanan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Grafik Penjualan 7 Hari Terakhir</h5>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-white fw-bold">
                            <i class="fas fa-bell me-2"></i> Aktivitas Terbaru
                        </div>
                        <div class.card-body p-0" style="max-height: 200px; overflow-y: auto;">
                            <ul class="list-group list-group-flush">
                                <?php if (!empty($stats['recent_transactions'])): ?>
                                    <?php foreach ($stats['recent_transactions'] as $trx): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong class="d-block text-truncate"><?= htmlspecialchars($trx['username']) ?></strong>
                                            <small>Baru saja membuat pesanan.</small>
                                        </div>
                                        <a href="index.php?action=orders" class="btn btn-sm btn-outline-primary">Lihat</a>
                                    </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="list-group-item text-center text-muted p-4">Belum ada aktivitas.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-white fw-bold">
                            <i class="fas fa-star me-2"></i> Produk Terlaris
                        </div>
                        <div class="card-body p-0" style="max-height: 200px; overflow-y: auto;">
                            <ul class="list-group list-group-flush">
                                <?php if (!empty($stats['best_selling_products'])): ?>
                                    <?php foreach ($stats['best_selling_products'] as $prod): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="text-truncate"><?= htmlspecialchars($prod['name']) ?></span>
                                        <span class="badge bg-success rounded-pill"><?= $prod['total_sold'] ?> terjual</span>
                                    </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                     <li class="list-group-item text-center text-muted p-4">Belum ada produk yang terjual.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <?php include 'templates/footer.php'; ?>
        
        <script>
            // Script untuk Chart.js (dengan warna baru)
            const ctx = document.getElementById('salesChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($stats['weekly_sales']['labels']) ?>,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: <?= json_encode($stats['weekly_sales']['data']) ?>,
                        fill: true,
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        tension: 0.3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: 'rgba(40, 167, 69, 1)',
                        pointHoverRadius: 7
                    }]
                },
                options: { 
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });
        </script>
    </div>
</div>