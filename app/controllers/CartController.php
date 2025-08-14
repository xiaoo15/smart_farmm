<?php
// File: app/controllers/CartController.php (VERSI FINAL WAJIB LOGIN)

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Transaction.php';

class CartController
{
    /**
     * Helper function sakti yang jadi satpam utama kita.
     * Dia akan mengusir siapapun yang belum login.
     */
    private function forceLogin($isAjax = false)
    {
        if (!isset($_SESSION['user'])) {
            if ($isAjax) {
                // Kalau yang minta JavaScript (AJAX), kirim sinyal rahasia
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'login_required']);
            } else {
                // Kalau request biasa dari browser, tendang ke halaman login
                $_SESSION['flash_message'] = "Anda harus login untuk mengakses halaman ini.";
                $_SESSION['flash_message_type'] = "warning";
                header('Location: index.php?action=showLogin');
            }
            // Hentikan eksekusi script setelah mengusir user
            exit;
        }
    }

    /**
     * Halaman keranjang sekarang dijaga ketat.
     */
    public function showCart()
    {
        $this->forceLogin();
        include __DIR__ . '/../views/cart.php';
    }

    /**
     * Halaman checkout juga dijaga super ketat.
     */
    public function showCheckoutPage()
    {
        $this->forceLogin();
        // Kalau keranjang kosong, nggak boleh checkout juga
        if (empty($_SESSION['cart'])) {
            header('Location: index.php?action=showCart');
            exit;
        }
        global $conn;
        $productModel = new Product($conn);
        include __DIR__ . '/../views/checkout.php';
    }

    /**
     * Proses checkout dijaga berlapis-lapis.
     */
    public function processCheckout()
    {
        $this->forceLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['payment_method']) || empty($_SESSION['cart'])) {
            header('Location: index.php?action=showCart');
            exit;
        }

        $userId = $_SESSION['user']['id'];

        global $conn;
        $transactionModel = new Transaction($conn);
        $productModel = new Product($conn);

        $paymentMethod = $_POST['payment_method'];
        $cartData = [];

        $product_ids = array_keys($_SESSION['cart']);
        $products_in_cart = $productModel->getProductsByIds($product_ids);
        foreach ($products_in_cart as $product) {
            $cartData[] = ['id' => $product['id'], 'price' => $product['price'], 'quantity' => $_SESSION['cart'][$product['id']]];
        }

        $transactionId = $transactionModel->create($cartData, $userId, $paymentMethod);

        if ($transactionId) {
            unset($_SESSION['cart']); // Keranjang tetap dikosongkan

            // ==========================================================
            // INI DIA PERUBAHANNYA! TUJUAN ROKET SEKARANG BERBEDA!
            // ==========================================================
            header('Location: index.php?action=showPayment&id=' . $transactionId);
            exit;
        } else {
            $_SESSION['flash_message'] = "Gagal memproses transaksi. Stok mungkin tidak cukup.";
            $_SESSION['flash_message_type'] = "danger";
            header('Location: index.php?action=showCart');
            exit;
        }
    }

    // --- SEMUA FUNGSI AJAX JUGA DIJAGA KETAT ---

    public function addToCartAjax()
    {
        $this->forceLogin(true); // true = ini request AJAX
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        if ($id > 0) {
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]++;
            else $_SESSION['cart'][$id] = 1;
            echo json_encode(['success' => true, 'cartCount' => count($_SESSION['cart'])]);
        } else {
            echo json_encode(['success' => false, 'message' => 'ID Produk tidak valid.']);
        }
        exit;
    }

    public function updateCartAjax()
    {
        $this->forceLogin(true);
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        $op = $data['op'] ?? 'inc';
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            if ($op === 'inc') {
                $_SESSION['cart'][$id]++;
            } elseif ($op === 'dec') {
                $_SESSION['cart'][$id]--;
                if ($_SESSION['cart'][$id] <= 0) unset($_SESSION['cart'][$id]);
            }
        }
        $this->getCartData();
    }

    public function removeFromCartAjax()
    {
        $this->forceLogin(true);
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        $this->getCartData();
    }

    // Fungsi ini tidak perlu dijaga karena hanya mengambil data
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
                $cart_items[] = ['id' => $product['id'], 'name' => $product['name'], 'price' => (float)$product['price'], 'image_url' => $product['image_url'], 'quantity' => (int)$quantity, 'subtotal' => (float)$subtotal];
                $total_price += $subtotal;
            }
        }
        echo json_encode(['items' => $cart_items, 'total' => $total_price]);
        exit;
    }
}
