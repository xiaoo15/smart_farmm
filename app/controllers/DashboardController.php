<?php
// File: app/controllers/DashboardController.php (VERSI INTELIJEN LENGKAP)

require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php'; // Panggil User model!

class DashboardController {
    public function showDashboard() {
        global $conn;
        
        // Buat instance dari semua model yang kita butuhkan
        $transactionModel = new Transaction($conn);
        $productModel = new Product($conn);
        $userModel = new User(); // Rekrut mata-mata pelanggan

        // Kumpulkan semua data intelijen ke dalam satu map
        $stats = [
            'todays_sales' => $transactionModel->getTodaysSales(),
            'total_products' => $productModel->getTotalProducts(),
            'low_stock_products' => $productModel->getLowStockProductsCount(),
            'total_transactions' => $transactionModel->getTotalTransactions(),
            'weekly_sales' => $transactionModel->getWeeklySalesData(),
            
            // --- INI DIA DATA INTELIJEN BARUNYA! ---
            'recent_transactions' => $transactionModel->getRecentTransactions(5), // Ambil 5 transaksi terbaru
            'best_selling_products' => $transactionModel->getBestSellingProducts(5), // Ambil 5 produk terlaris
            'recent_customers' => $userModel->getRecentCustomers(5) // Ambil 5 pelanggan terbaru
        ];
        
        // Kirim semua data intelijen ke ruang komando (view)
        include __DIR__ . '/../views/dashboard.php';
    }
}