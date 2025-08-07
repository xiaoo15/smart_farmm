<?php

require_once __DIR__ . '/../models/Transaction.php';

class PaymentController {


    public function showPaymentPage() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=showLogin');
            exit;
        }

        global $conn;
        $transactionModel = new Transaction($conn);
        $transactionId = $_GET['id'] ?? 0;
        $userId = $_SESSION['user']['id'];

        // Ambil data transaksi, tapi pastikan ini punya user yang lagi login
        $transaction = $transactionModel->getTransactionForUser($transactionId, $userId);

        // Lempar data transaksi ke 'view'
        include __DIR__ . '/../views/payment.php';
    }

    /**
     * Fungsi untuk memproses upload bukti pembayaran.
     */
    public function handlePaymentProof() {
        // Cek dulu, user harus login
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=showLogin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id']) && isset($_FILES['payment_proof'])) {
            
            global $conn;
            $transactionModel = new Transaction($conn);
            $transactionId = (int)$_POST['transaction_id'];
            $userId = $_SESSION['user']['id'];

            // Verifikasi sekali lagi kalau transaksi ini milik user yang login
            $transaction = $transactionModel->getTransactionForUser($transactionId, $userId);
            if (!$transaction) {
                die("Error: Anda tidak punya akses ke transaksi ini.");
            }

            // Proses upload gambarnya
            $proofFileName = $this->uploadProof($_FILES['payment_proof']);

            if ($proofFileName) {
                // Simpan nama file ke database dan update status
                $transactionModel->updatePaymentProof($transactionId, $proofFileName);
                
                // Arahkan ke halaman "Riwayat Pesanan" dengan pesan sukses
                header('Location: index.php?action=myOrders&payment_success=1');
                exit;
            } else {
                // Kalau upload gagal
                die("Upload bukti pembayaran gagal. Pastikan file adalah gambar (JPG/PNG).");
            }
        }
    }

    /**
     * Helper function buat ngurusin upload file bukti bayar.
     */
    private function uploadProof($file) {
        $uploadDir = dirname(__DIR__, 2) . '/public/images/proofs/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'proof_' . time() . '_' . basename($file['name']);
        $targetFile = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Cek apakah file adalah gambar
        $check = getimagesize($file["tmp_name"]);
        if($check === false) {
            return false;
        }

        // Cek ekstensi file
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return false;
        }

        // Coba upload
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $fileName;
        } else {
            return false;
        }
    }
}