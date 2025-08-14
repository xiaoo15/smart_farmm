<?php
// File: /index.php (VERSI FINAL ANTI-ERROR)
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Alamat absolut menggunakan __DIR__
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/controllers/HomeController.php';
require_once __DIR__ . '/app/controllers/CartController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
// Panggil juga PaymentController-nya
require_once __DIR__ . '/app/controllers/PaymentController.php';

// Inisialisasi controller
$homeController = new HomeController();
$cartController = new CartController();
$authController = new AuthController();
// ==========================================================
// INI DIA BAGIAN YANG KEMARIN KETINGGALAN!
// ==========================================================
$paymentController = new PaymentController();


$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        $homeController->showHome();
        break;
    case 'allProducts':
        $homeController->showAllProducts();
        break;
    case 'productDetail':
        $homeController->showProductDetail();
        break;

    // Rute Keranjang & Checkout
    case 'showCart':
        $cartController->showCart();
        break;
    case 'showCheckout':
        $cartController->showCheckoutPage();
        break;
    case 'processCheckout':
        $cartController->processCheckout();
        break;

    // Rute Pembayaran
    case 'showPayment':
        $paymentController->showPaymentPage();
        break;
    case 'handlePaymentProof':
        $paymentController->handlePaymentProof();
        break;

    // Rute User & Auth
    case 'showLogin':
        $authController->showLogin();
        break;
    case 'showRegister':
        $authController->showRegisterForm();
        break;
    case 'login':
        $authController->handleLogin();
        break;
    case 'register':
        $authController->handleRegister();
        break;
    case 'myOrders':
        $authController->showMyOrders();
        break;
    case 'orderDetails':
        $authController->showOrderDetails();
        break;
    case 'logout':
        $authController->handleLogout();
        break;

    // Rute AJAX
    case 'getCartData':
        $cartController->getCartData();
        break;
    case 'updateCartAjax':
        $cartController->updateCartAjax();
        break;
    case 'addToCartAjax':
        $cartController->addToCartAjax();
        break;
    case 'removeFromCartAjax':
        $cartController->removeFromCartAjax();
        break;

    default:
        $homeController->showHome();
        break;
}
