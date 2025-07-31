<?php
$title = "Dashboard";
global $action;
?>

<div class="d-flex">
    <?php include 'templates/sidebar.php'; ?>

    <div class="flex-grow-1">
        <?php include 'templates/header.php'; ?>
        
        <main class="p-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-primary shadow">
                        <div class="card-body">
                            <h5 class="card-title">Penjualan Hari Ini</h5>
                            <p class="card-text fs-4">Rp <?= number_format($stats['todays_sales'], 0, ',', '.') ?></p>
                            <small>Data Real-time</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-success shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Produk</h5>
                            <p class="card-text fs-4"><?= $stats['total_products'] ?> Jenis</p>
                            <small>Jumlah semua produk</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-warning shadow">
                        <div class="card-body">
                            <h5 class="card-title">Stok Menipis</h5>
                            <p class="card-text fs-4"><?= $stats['low_stock_products'] ?> Produk</p>
                            <small>Stok di bawah 10</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                     <div class="card text-white bg-info shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total Transaksi</h5>
                            <p class="card-text fs-4"><?= $stats['total_transactions'] ?> Transaksi</p>
                            <small>Semua transaksi tercatat</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm">
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