<?php
// File: app/controllers/ProductController.php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function showProducts()
    {
        global $conn; // Ambil koneksi dari database.php
        $productModel = new Product($conn);
        $products = $productModel->getAll();

        // Panggil view dan kirim data products
        include __DIR__ . '/../views/products.php';
    }

    public function handleCreate()
    {
        // --- ALAT SADAP CONTROLLER ---
        echo "<h1>Laporan Intelijen dari Controller:</h1>";
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";
        die("--- Misi di Controller Selesai ---");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conn;
            $productModel = new Product($conn);
            if ($productModel->create($_POST, $_FILES)) {
                // Set session flash message untuk notifikasi
                $_SESSION['flash_message'] = "Produk berhasil ditambahkan!";
            } else {
                $_SESSION['flash_message'] = "GAGAL menambahkan produk.";
            }
        }
        header('Location: index.php?action=products');
        exit;
    }
    public function getProductJson()
    {
        header('Content-Type: application/json');
        if (isset($_GET['id'])) {
            global $conn;
            $productModel = new Product($conn);
            $product = $productModel->getById($_GET['id']);
            if ($product) {
                echo json_encode($product);
            } else {
                echo json_encode(['error' => 'Produk tidak ditemukan.']);
            }
        }
        exit;
    }

    /**
     * Menangani proses update produk dari form edit.
     */
    public function handleUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            global $conn;
            $productModel = new Product($conn);
            if ($productModel->update($_POST['id'], $_POST, $_FILES)) {
                $_SESSION['flash_message'] = "Produk berhasil diperbarui!";
            } else {
                $_SESSION['flash_message'] = "GAGAL memperbarui produk.";
            }
        }
        header('Location: index.php?action=products');
        exit;
    }

    public function handleDelete()
    {
        if (isset($_GET['id'])) {
            global $conn;
            $productModel = new Product($conn);
            if ($productModel->delete($_GET['id'])) {
                $_SESSION['flash_message'] = "Produk berhasil dihapus!";
            } else {
                $_SESSION['flash_message'] = "GAGAL menghapus produk.";
            }
        }
        header('Location: index.php?action=products');
        exit;
    }

    // Nanti kita tambah fungsi update di sini
}
