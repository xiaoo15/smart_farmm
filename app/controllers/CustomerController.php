<?php
// File: app/controllers/CustomerController.php (FILE BARU!)

// Pastikan dia kenal sama si "pekerja gudang" User
require_once __DIR__ . '/../models/User.php';

class CustomerController
{

    /**
     * Fungsi utama untuk menampilkan halaman manajemen pelanggan.
     */
    public function showCustomers()
    {
        // Panggil model User
        $userModel = new User();

        // Perintahkan model untuk mengambil semua data customer
        $customers = $userModel->getAllCustomers();

        // Panggil file view (yang akan kita buat selanjutnya) 
        // dan kirim data $customers ke dalamnya
        include __DIR__ . '/../views/customers.php';
    }

    public function showCustomerDetail()
    {
        global $conn;

        // Ambil ID pelanggan dari URL
        $customerId = $_GET['id'] ?? 0;

        // Siapkan model-model yang dibutuhkan
        $userModel = new User(); // Kita mungkin butuh ini buat ambil nama user
        $transactionModel = new Transaction($conn);

        // Ambil data spesifik pelanggan (kamu bisa buat fungsi getById di User.php)
        // Untuk sekarang kita langsung ambil riwayatnya

        // Ambil semua transaksi milik pelanggan ini
        $transactions = $transactionModel->getTransactionsByUserId($customerId);

        // Panggil view baru (yang akan kita buat selanjutnya)
        include __DIR__ . '/../views/customer_detail.php';
    }

    // (Nanti kita bisa tambahkan fungsi lain di sini, 
    // misalnya untuk melihat detail transaksi per pelanggan)
}
