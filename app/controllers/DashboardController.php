<?php
// File: app/controllers/DashboardController.php (VERSI BARU)

require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Product.php';

class DashboardController {
    public function showDashboard() {
        global $conn;
        
        $transactionModel = new Transaction($conn);
        $productModel = new Product($conn);

        // Ambil semua data statistik
        $stats = [
            'todays_sales' => $transactionModel->getTodaysSales(),
            'low_stock_products' => $productModel->getLowStockProductsCount(),
            'total_transactions' => $transactionModel->getTotalTransactions(),
            'weekly_sales' => $transactionModel->getWeeklySalesData(),
            // --- DATA INTELIJEN BARU! ---
            'recent_transactions' => $transactionModel->getRecentTransactions(5) // Ambil 5 transaksi terbaru
        ];
        
        include __DIR__ . '/../views/dashboard.php';
    }
}