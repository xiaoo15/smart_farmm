<?php
// File: app/controllers/CartController.php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Transaction.php';

class CartController
{

    // Fungsi ini tidak berubah
    public function addToCart()
    {
        $id = $_GET['id'] ?? 0;
        if ($id > 0) {
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]++;
            } else {
                $_SESSION['cart'][$id] = 1;
            }
        }
        header('Location: index.php?action=home');
        exit;
    }

    // Fungsi ini tidak berubah
    public function showCart()
    {
        // Logika untuk menampilkan halaman cart.php pertama kali
        // Ini akan kita ganti dengan logika AJAX nanti, tapi biarkan dulu
        include __DIR__ . '/../views/cart.php';
    }

    /**
     * FUNGSI BARU: Mengambil data keranjang dalam format JSON.
     * Ini yang akan dipanggil oleh JavaScript.
     */
    public function getCartData()
    {
        header('Content-Type: application/json');
        global $conn;
        $cart_items = [];
        $total_price = 0;

        if (!empty($_SESSION['cart'])) {
            $productModel = new Product($conn);
            $product_ids = array_keys($_SESSION['cart']);
            $products_in_cart = $productModel->getProductsByIds($product_ids);

            foreach ($products_in_cart as $product) {
                $quantity = $_SESSION['cart'][$product['id']];
                $subtotal = $product['price'] * $quantity;
                $cart_items[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => (float)$product['price'],
                    'image_url' => $product['image_url'],
                    'quantity' => (int)$quantity,
                    'subtotal' => (float)$subtotal
                ];
                $total_price += $subtotal;
            }
        }

        echo json_encode(['items' => $cart_items, 'total' => $total_price]);
        exit;
    }

    /**
     * FUNGSI BARU: Mengupdate keranjang via AJAX.
     */
    public function updateCartAjax()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        $op = $data['op'] ?? 'inc';

        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            if ($op === 'inc') {
                $_SESSION['cart'][$id]++;
            } elseif ($op === 'dec') {
                $_SESSION['cart'][$id]--;
                if ($_SESSION['cart'][$id] <= 0) {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        // Setelah update, kirim balik data keranjang terbaru
        $this->getCartData();
    }
    

    /**
     * FUNGSI BARU: Menghapus item dari keranjang via AJAX.
     */
    public function removeFromCartAjax()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;

        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        // Setelah hapus, kirim balik data keranjang terbaru
        $this->getCartData();
    }

    // ... (method-method lain yang sudah ada)

    // --- TAMBAHKAN METHOD BARU INI UNTUK AJAX ---
    public function addToCartAjax()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;

        if ($id > 0) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]++;
            } else {
                $_SESSION['cart'][$id] = 1;
            }

            // Kirim response sukses beserta jumlah item di keranjang
            echo json_encode([
                'success' => true,
                'cartCount' => count($_SESSION['cart'])
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'ID Produk tidak valid.'
            ]);
        }
        exit;
    }

    // Fungsi processCheckout tidak berubah
    public function showCheckoutPage()
    {
        // Panggil model product untuk mendapatkan data harga terbaru
        global $conn;
        $productModel = new Product($conn);
        include __DIR__ . '/../views/checkout.php';
    }
    
    /**
     * FUNGSI LAMA (DIRENOVASI): Proses checkout sekarang lebih canggih.
     */
    public function processCheckout()
    {
        // Validasi dasar
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['payment_method']) || empty($_SESSION['cart'])) {
            header('Location: index.php?action=showCart'); // Jika aneh, balik ke keranjang
            exit;
        }

        global $conn;
        $productModel = new Product($conn);
        $transactionModel = new Transaction($conn);

        // Ambil data dari form
        $paymentMethod = $_POST['payment_method'];
        $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

        $cartData = [];
        $product_ids = array_keys($_SESSION['cart']);
        $products_in_cart = $productModel->getProductsByIds($product_ids);

        foreach ($products_in_cart as $product) {
            $cartData[] = [
                'id' => $product['id'],
                'price' => $product['price'],
                'quantity' => $_SESSION['cart'][$product['id']]
            ];
        }

        // Kirim semua data (termasuk metode pembayaran) ke model
        $transactionId = $transactionModel->create($cartData, $userId, $paymentMethod);

        if ($transactionId) {
            unset($_SESSION['cart']); // Kosongkan keranjang
            header('Location: index.php?action=orderDetails&id=' . $transactionId . '&status=success');
            exit;
        } else {
            $_SESSION['flash_message'] = "Maaf, terjadi kesalahan saat memproses pesanan Anda. Stok mungkin tidak mencukupi.";
            $_SESSION['flash_message_type'] = "danger";
            header('Location: index.php?action=showCart');
            exit;
        }
    }
}
