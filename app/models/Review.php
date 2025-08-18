<?php
// File: app/models/Review.php (FILE BARU)

class Review {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi untuk menyimpan review baru ke database
    public function saveReview($productId, $userId, $rating, $reviewText) {
        $stmt = $this->conn->prepare(
            "INSERT INTO product_reviews (product_id, user_id, rating, review_text) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiis", $productId, $userId, $rating, $reviewText);
        return $stmt->execute();
    }
    
    // Fungsi untuk mengambil semua review untuk satu produk
    public function getReviewsByProductId($productId) {
        $stmt = $this->conn->prepare("
            SELECT r.*, u.username 
            FROM product_reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.product_id = ? 
            ORDER BY r.created_at DESC
        ");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }
}