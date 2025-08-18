<?php
// File: app/controllers/ReviewController.php (FILE BARU)

require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../models/Review.php';

class ReviewController {
    public function showReviewPage() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=showLogin');
            exit;
        }

        global $conn;
        $transactionModel = new Transaction($conn);
        $order_id = $_GET['order_id'] ?? 0;
        $user_id = $_SESSION['user']['id'];
        
        // Ambil detail produk dari transaksi ini
        $items = $transactionModel->getTransactionDetailsForUser($order_id, $user_id);

        include __DIR__ . '/../views/write_review.php';
    }
    
    public function submitReview() {
        if (!isset($_SESSION['user']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=home');
            exit;
        }
        
        global $conn;
        $reviewModel = new Review($conn);
        
        $user_id = $_SESSION['user']['id'];
        $product_id = $_POST['product_id'];
        $rating = $_POST['rating'];
        $review_text = $_POST['review_text'];
        
        $reviewModel->saveReview($product_id, $user_id, $rating, $review_text);
        
        // Arahkan kembali ke halaman riwayat pesanan dengan pesan sukses
        header('Location: index.php?action=myOrders&review_success=1');
        exit;
    }
}