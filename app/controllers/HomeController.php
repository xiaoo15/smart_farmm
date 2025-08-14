<?php
// File: app/controllers/HomeController.php

// Pastikan kita memanggil model yang dibutuhkan
require_once __DIR__ . '/../models/Product.php';

class HomeController
{
    /**
     * Fungsi ini untuk menampilkan halaman utama (etalase toko)
     * untuk pelanggan.
     */


    /**
     * FUNGSI BARU: Untuk menampilkan halaman semua produk.
     * Logikanya sama persis dengan showHome(), tapi view yang dipanggil beda.
     */
    public function showAllProducts()
    {
        global $conn;
        $productModel = new Product($conn);
        $products = $productModel->getAll(); // Ambil semua data produk
        include __DIR__ . '/../views/all_products.php'; // Panggil view yang baru kita buat
    }
    public function showProductDetail()
    {
        global $conn;
        $productModel = new Product($conn);

        // Ambil ID produk dari URL (?id=...)
        $productId = $_GET['id'] ?? 0;

        // Ambil data produk dari database berdasarkan ID
        $product = $productModel->getById($productId);

        // Panggil view dan kirim data $product ke dalamnya
        include __DIR__ . '/../views/product_detail.php';
    }

    public function showHome()
    {
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
