<?php
// File: app/controllers/ProductController.php (SUDAH DIPERBAIKI)

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function showProducts()
    {
        global $conn;
        $productModel = new Product($conn);
        $products = $productModel->getAll();
        include __DIR__ . '/../views/products.php';
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


    public function handleCreate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            global $conn;
            $productModel = new Product($conn);
            if ($productModel->create($_POST, $_FILES)) { /* ... */
            } else { /* ... */
            }
        }
        header('Location: index.php?action=products');
        exit;
    }
    public function handleUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            global $conn;
            $productModel = new Product($conn);
            if ($productModel->update($_POST['id'], $_POST, $_FILES)) { /* ... */
            } else { /* ... */
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
}
