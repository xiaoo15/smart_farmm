<?php
// File: app/controllers/PosController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Transaction.php';

class PosController {
    // Menampilkan halaman utama Point of Sales
    public function showPos() {
        global $conn;
        $productModel = new Product($conn);
        $products = $productModel->getAll(); // Ambil semua produk untuk ditampilkan

        include __DIR__ . '/../views/pos.php';
    }

    // Menangani data transaksi yang dikirim dari frontend
    public function handleTransaction() {
        // Ambil data JSON mentah dari body request
        $json = file_get_contents('php://input');
        // Ubah JSON menjadi array PHP
        $cartData = json_decode($json, true);

        if ($cartData) {
            global $conn;
            $transactionModel = new Transaction($conn);
            $transactionId = $transactionModel->create($cartData);

            if ($transactionId) {
                // Kirim response sukses dalam format JSON
                echo json_encode(['success' => true, 'transactionId' => $transactionId]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal memproses transaksi.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Tidak ada data keranjang.']);
        }
        exit; // Wajib ada exit setelah echo JSON
    }
}
?>