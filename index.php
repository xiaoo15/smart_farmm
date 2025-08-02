<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// File: /index.php (Pintu Masuk untuk Customer)
session_start();

// Alamat absolut menggunakan __DIR__
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/controllers/HomeController.php';
require_once __DIR__ . '/app/controllers/CartController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

// Inisialisasi controller
$homeController = new HomeController();
$cartController = new CartController();
$authController = new AuthController();

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        $homeController->showHome();
        break;
    case 'showCart':
        $cartController->showCart();
        break;
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
    case 'processCheckout':
        $cartController->processCheckout();
        break;
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
    case 'showCart':

        $cartController->showCart();
        break;
    case 'showCheckout': // <--- INI ROUTE BARUNYA
        $cartController->showCheckoutPage();
        break;
    case 'allProducts':
        $homeController->showAllProducts();
        break;
    case 'logout':
    session_destroy();
    // Arahkan ke halaman login customer di folder utama
    header('Location: ../index.php?action=showLogin');
    exit;
    default:
        $homeController->showHome();
        break;
}
