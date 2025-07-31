<?php
// File: app/controllers/ReportController.php

require_once __DIR__ . '/../models/Transaction.php';

class ReportController {
    // Menampilkan halaman laporan penjualan
    public function showReports() {
        global $conn;
        $transactionModel = new Transaction($conn);

        // Ambil tanggal dari filter (jika ada)
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        $transactions = $transactionModel->getReport($startDate, $endDate);

        include __DIR__ . '/../views/reports.php';
    }

    // Menangani request AJAX untuk mengambil detail transaksi
    public function getDetails() {
        if (isset($_GET['id'])) {
            global $conn;
            $transactionModel = new Transaction($conn);
            $details = $transactionModel->getTransactionDetails($_GET['id']);
            
            // Kembalikan data dalam format JSON
            header('Content-Type: application/json');
            echo json_encode($details);
            exit;
        }
    }
}
?>