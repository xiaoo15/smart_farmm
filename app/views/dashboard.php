<?php
$title = "Dashboard";
include 'templates/header.php';
?>
<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>

    <div class="main-content">
        <header class="content-header">
            <div class="header-welcome">
                <h2>Welcome back, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h2>
                <p>Here's what's happening with your store today.</p>
            </div>
            <div class="header-actions d-flex align-items-center">
                <input type="text" class="form-control me-2" placeholder="Search...">
                <button class="btn btn-light"><i class="fas fa-bell"></i></button>
            </div>
        </header>

        <section class="today-sales mb-4">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-card-icon icon-earnings"><i class="fas fa-dollar-sign"></i></div>
                        <p class="stat-card-title">Today's Sales</p>
                        <h4 class="stat-card-value">Rp<?= number_format($stats['todays_sales'], 0, ',', '.') ?></h4>
                        <span class="stat-card-change text-success"><i class="fas fa-arrow-up"></i> 12%</span> vs last month
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-card-icon icon-visitors"><i class="fas fa-users"></i></div>
                        <p class="stat-card-title">Today's Visitors</p>
                        <h4 class="stat-card-value">1,234</h4>
                        <span class="stat-card-change text-success"><i class="fas fa-arrow-up"></i> 8%</span> vs last month
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-card-icon icon-orders"><i class="fas fa-receipt"></i></div>
                        <p class="stat-card-title">Total Orders</p>
                        <h4 class="stat-card-value"><?= $stats['total_transactions'] ?></h4>
                        <span class="stat-card-change text-danger"><i class="fas fa-arrow-down"></i> 2%</span> vs last month
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-card-icon icon-sales"><i class="fas fa-chart-line"></i></div>
                        <p class="stat-card-title">Conversion Rate</p>
                        <h4 class="stat-card-value">5.8%</h4>
                        <span class="stat-card-change text-success"><i class="fas fa-arrow-up"></i> 0.5%</span> vs last month
                    </div>
                </div>
            </div>
        </section>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="dashboard-section h-100">
                    <div class="section-header">
                        <h5>Sales Statistics</h5>
                        <select class="form-select form-select-sm w-auto">
                            <option>This Month</option>
                            <option>Last 3 Months</option>
                            <option>This Year</option>
                        </select>
                    </div>
                    <div style="height: 350px;"><canvas id="salesChart"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-section h-100">
                    <div class="section-header">
                        <h5>Top Products</h5><a href="index.php?action=products" class="small">See All</a>
                    </div>
                    <table class="table table-borderless">
                        <tbody>
                            <?php if (!empty($stats['best_selling_products'])): ?>
                                <?php foreach ($stats['best_selling_products'] as $product): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="public/images/products/<?= htmlspecialchars($product['image_url'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                                <span class="ms-3 fw-bold"><?= htmlspecialchars($product['name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-end fw-bold"><?= $product['total_sold'] ?> sold</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-muted text-center">No products sold yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesChartCanvas = document.getElementById('salesChart');
    if (salesChartCanvas) {
        new Chart(salesChartCanvas, {
            type: 'bar',
            data: {
                labels: <?= json_encode($stats['weekly_sales']['labels'] ?? []) ?>,
                datasets: [{
                    label: 'Sales',
                    data: <?= json_encode($stats['weekly_sales']['data'] ?? []) ?>,
                    backgroundColor: 'rgba(90, 106, 207, 0.7)',
                    borderRadius: 5
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