<?php
// File: app/controllers/HomeController.php

// Pastikan kita memanggil model yang dibutuhkan
require_once __DIR__ . '/../models/Product.php';

class HomeController {
    /**
     * Fungsi ini untuk menampilkan halaman utama (etalase toko)
     * untuk pelanggan.
     */
    public function showHome() {
        // Ambil koneksi database global
        global $conn;

        // Buat objek dari model Product
        $productModel = new Product($conn);
        
        // Ambil semua data produk dari database
        $products = $productModel->getAll();
        
        // Panggil file view untuk menampilkan halaman home,
        // sambil mengirimkan data $products
        include __DIR__ . '/../views/home.php';
    }
}
?>