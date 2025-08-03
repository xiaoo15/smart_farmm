<?php
$title = "Dashboard";
global $action;
?>

<div class="d-flex">
    <?php include 'templates/sidebar.php'; ?>

    <div class="flex-grow-1">
        <?php include 'templates/header.php'; ?>

            <div class="content-wrapper">
                <main class="p-4">
                    <h1 class="h2 mb-4">Dashboard</h1>

                    <div class="row">
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="stat-icon bg-primary"><i class="fas fa-dollar-sign"></i></div>
                                    <div>
                                        <h6 class="card-title">Penjualan Hari Ini</h6>
                                        <p class="card-text">Rp <?= number_format($stats['todays_sales'], 0, ',', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="stat-icon bg-success"><i class="fas fa-boxes-stacked"></i></div>
                                    <div>
                                        <h6 class="card-title">Total Produk</h6>
                                        <p class="card-text"><?= $stats['total_products'] ?> Jenis</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="stat-icon bg-warning text-dark"><i class="fas fa-exclamation-triangle"></i></div>
                                    <div>
                                        <h6 class="card-title">Stok Menipis</h6>
                                        <p class="card-text"><?= $stats['low_stock_products'] ?> Produk</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <div class="stat-icon bg-info"><i class="fas fa-receipt"></i></div>
                                    <div>
                                        <h6 class="card-title">Total Transaksi</h6>
                                        <p class="card-text"><?= $stats['total_transactions'] ?> Kali</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm border-0 rounded-3">
                                <div class="card-body">
                                    <h5 class="card-title">Grafik Penjualan 7 Hari Terakhir</h5>
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <?php include 'templates/footer.php'; ?>

                <script>
                    // ... (kode JavaScript untuk chart tidak perlu diubah) ...
                </script>
            </div>
        </div>
        <?php include 'templates/footer.php'; ?>
        <script>
            const ctx = document.getElementById('salesChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    // Ambil data dari variabel PHP yang di-encode ke JSON
                    labels: <?= json_encode($stats['weekly_sales']['labels']) ?>,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: <?= json_encode($stats['weekly_sales']['data']) ?>,
                        fill: true,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat().format(value);
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</div>