<?php
session_start();
header('Content-Type: application/json');

// Pastikan koneksi ke database udah ada
$conn = mysqli_connect("localhost", "root", "", "nama_database_kamu");
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal terhubung ke database.']);
    exit;
}

// Cek data yang dikirim dari frontend
if (!isset($_POST['product_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

$productId = $_POST['product_id'];

// Ambil data produk (nama) dari database
$query = "SELECT name FROM products WHERE id = " . mysqli_real_escape_string($conn, $productId);
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan.']);
    exit;
}

$productName = $product['name'];

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Tambahkan produk ke keranjang
if (isset($_SESSION['keranjang'][$productId])) {
    $_SESSION['keranjang'][$productId]['quantity']++;
} else {
    $_SESSION['keranjang'][$productId] = [
        'id' => $productId,
        'name' => $productName,
        'quantity' => 1
    ];
}

// Hitung total produk di keranjang (opsional)
$keranjangCount = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $keranjangCount += $item['quantity'];
}

// Kirim respons sukses ke JavaScript
echo json_encode([
    'status' => 'success',
    'product_name' => $productName,
    'keranjangCount' => $keranjangCount
]);

mysqli_close($conn);
?>