<?php
// File: /public/index.php (Pintu Masuk KHUSUS ADMIN)
session_start();

// --- KUNCI PENGAMAN PALING PENTING ---
// Jika tidak ada session user, atau rolenya bukan admin, tendang keluar!
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Arahkan ke halaman login customer, bukan admin
    header('Location: ../index.php?action=showLogin&auth_error=1');
    exit;
}
// ------------------------------------

// Memanggil file-file penting
require_once '../config/database.php';
require_once '../app/controllers/DashboardController.php';
require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/PosController.php';
require_once '../app/controllers/ReportController.php';
require_once '../app/controllers/OrderController.php';
require_once '../app/controllers/CustomerController.php';   

// Inisialisasi controller
$dashboardController = new DashboardController();
$productController = new ProductController();
$posController = new PosController();
$reportController = new ReportController();
$orderController = new OrderController();
$customerController = new CustomerController();

// Karena sudah pasti admin, halaman default-nya adalah dashboard
$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    // Rute Admin
    case 'dashboard':
        $dashboardController->showDashboard();
        break;
    case 'products':
        $productController->showProducts();
        break;
    case 'createProduct':
        $productController->handleCreate();
        break;
    case 'deleteProduct':
        $productController->handleDelete();
        break;
    case 'pos':
        $posController->showPos();
        break;
    case 'getProduct':
        $productController->getProductJson();
        break;
    case 'updateProduct':
        $productController->handleUpdate();
        break;
    case 'processTransaction':
        $posController->handleTransaction();
        break;
    case 'reports':
        $reportController->showReports();
        break;
    case 'getDetails':
        $reportController->getDetails();
        break;
    case 'orders':
        $orderController->showOrders();
        break;
    case 'showPayment':
        $paymentController->showPaymentPage();
        break;
    case 'handlePaymentProof':
        $paymentController->handlePaymentProof();
        break;
    case 'customerDetail':
        $customerController->showCustomerDetail();
        break;
    case 'updateOrderStatus':
        $orderController->updateOrderStatus();
        break;
    case 'customers':
        $customerController->showCustomers();
        break;
    case 'logout':
        session_destroy();
        header('Location: ../index.php?action=showLogin');
        exit;


        // Rute logout tetap bisa diakses dari sini
    case 'logout':
        session_destroy();
        header('Location: ../index.php?action=showLogin');
        exit;

    default:
        $dashboardController->showDashboard();
        break;
}
