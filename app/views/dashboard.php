<?php
$title = "Dashboard";
include 'templates/header.php';
?>
<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>
    <main id="main-content">
        <header class="top-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">Dashboard</h2>
                <div class="text-muted small"><i class="fas fa-calendar-alt me-2"></i><?= date('l, F d, Y') ?></div>
            </div>
        </header>
        <section class="overview-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="h5 mb-0">Overview</h3>
                <span class="text-muted small">Updated <?= date('d-m-Y') ?></span>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <p class="stat-title">Total Income</p>
                        <h4 class="stat-value">Rp<?= number_format($stats['todays_sales'], 0, ',', '.') ?></h4><span class="stat-change text-success">+2.18%</span><span class="text-muted small"> in a last month</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <p class="stat-title">Profit</p>
                        <h4 class="stat-value">Rp<?= number_format($stats['todays_sales'] * 0.4, 0, ',', '.') ?></h4><span class="stat-change text-success">+2.18%</span><span class="text-muted small"> in a last month</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <p class="stat-title">Total order</p>
                        <h4 class="stat-value"><?= $stats['total_transactions'] ?></h4><span class="stat-change text-danger">-1.62%</span><span class="text-muted small"> in a last month</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card stat-card h-100">
                        <p class="stat-title">Conversion rate</p>
                        <h4 class="stat-value">4.98%</h4><span class="stat-change text-success">+0.31%</span><span class="text-muted small"> in a last month</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="sales-revenue-section mt-4">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title">Sales Revenue</h5>
                    <div style="height: 300px;"><canvas id="salesChart"></canvas></div>
                </div>
            </div>
        </section>
        <section class="latest-order-section mt-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center p-4">
                    <h5 class="mb-0">Latest Order</h5><a href="index.php?action=orders" class="small text-decoration-none">See all</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Customer name</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($stats['recent_transactions'])): ?>
                                    <?php foreach (array_slice($stats['recent_transactions'], 0, 5) as $trx): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($trx['username']) ?></td>
                                            <td><span class="badge bg-success-soft rounded-pill">Complete</span></td>
                                            <td><?= date('d M, Y', strtotime($trx['transaction_date'])) ?></td>
                                            <td class="text-end fw-bold">Rp<?= number_format($trx['total_price'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted p-4">No recent orders.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesChartCanvas = document.getElementById('salesChart');
    if (salesChartCanvas) {
        new Chart(salesChartCanvas, {
            type: 'line',
            data: {
                labels: <?= json_encode($stats['weekly_sales']['labels'] ?? []) ?>,
                datasets: [{
                    label: 'Sales Revenue',
                    data: <?= json_encode($stats['weekly_sales']['data'] ?? []) ?>,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#3B82F6',
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#3B82F6'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            },
        });
    }
</script>
<?php include 'templates/footer.php'; ?>