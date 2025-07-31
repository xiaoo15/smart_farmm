<?php
// File: app/controllers/DashboardController.php

require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Product.php';

class DashboardController {
    public function showDashboard() {
        global $conn;
        
        // Buat instance dari model
        $transactionModel = new Transaction($conn);
        $productModel = new Product($conn);

        // Ambil semua data statistik
        $stats = [
            'todays_sales' => $transactionModel->getTodaysSales(),
            'total_products' => $productModel->getTotalProducts(),
            'low_stock_products' => $productModel->getLowStockProductsCount(),
            'total_transactions' => $transactionModel->getTotalTransactions(),
            'weekly_sales' => $transactionModel->getWeeklySalesData()
        ];
        
        // Panggil view dan kirim data stats ke dalamnya
        include __DIR__ . '/../views/dashboard.php';
    }
}
?>