<?php
// File: app/controllers/OrderController.php (FILE BARU!)

require_once __DIR__ . '/../models/Transaction.php';

class OrderController {
    
    public function showOrders() {
        global $conn;
        $transactionModel = new Transaction($conn);
        $transactions = $transactionModel->getAllTransactionsWithUser();
        include __DIR__ . '/../views/orders.php';
    }

    public function updateOrderStatus() {
        header('Content-Type: application/json');
        
        // Cek apakah admin yang melakukan ini
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak.']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
            global $conn;
            $transactionModel = new Transaction($conn);
            
            $transactionId = (int)$_POST['id'];
            $newStatus = $_POST['status'];
            
            if ($transactionModel->updateStatus($transactionId, $newStatus)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal update di database.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        }
        exit;
    }
}