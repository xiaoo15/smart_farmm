<?php
// File: app/models/Transaction.php

class Transaction
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }




    public function create($cartData, $userId, $paymentMethod)
    {
        // Kita pastikan sekali lagi $userId adalah angka
        $userId = (int)$userId;
        if ($userId <= 0) {
            return false; // Gagalkan jika user ID tidak valid
        }

        // Mulai "mode aman" database
        mysqli_begin_transaction($this->conn);

        try {
            // 1. Hitung total harga
            $totalPrice = 0;
            foreach ($cartData as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            // 2. Masukkan data ke tabel transactions (Folder Struk)
            $queryTrans = "INSERT INTO transactions (user_id, total_price, payment_method) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->conn, $queryTrans);
            mysqli_stmt_bind_param($stmt, "ids", $userId, $totalPrice, $paymentMethod);
            mysqli_stmt_execute($stmt);
            $transactionId = mysqli_insert_id($this->conn);

            // Jika gagal buat transaksi utama, langsung hentikan
            if ($transactionId == 0) {
                throw new Exception("Gagal mendapatkan ID transaksi.");
            }

            // --- INI BAGIAN YANG HILANG & DIBENERIN ---
            // 3. Masukkan setiap barang ke transaction_items (Rincian Barang)
            $queryItem = "INSERT INTO transaction_items (transaction_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmtItem = mysqli_prepare($this->conn, $queryItem);

            $queryStock = "UPDATE products SET stock = stock - ? WHERE id = ?";
            $stmtStock = mysqli_prepare($this->conn, $queryStock);

            foreach ($cartData as $item) {
                // Masukkan item
                mysqli_stmt_bind_param($stmtItem, "iiid", $transactionId, $item['id'], $item['quantity'], $item['price']);
                mysqli_stmt_execute($stmtItem);

                // Kurangi stok
                mysqli_stmt_bind_param($stmtStock, "ii", $item['quantity'], $item['id']);
                mysqli_stmt_execute($stmtStock);
            }
            // --- BATAS BAGIAN YANG DIBENERIN ---

            // 4. Jika semua berhasil, permanenkan perubahan
            mysqli_commit($this->conn);
            return $transactionId;
        } catch (Exception $e) {
            // 5. Jika ada satu saja yang gagal, batalkan semua
            mysqli_rollback($this->conn);
            error_log("Gagal membuat transaksi: " . $e->getMessage()); // Catat error buat kita liat nanti
            return false;
        }
    }

    public function getReport($startDate = null, $endDate = null)
    {
        $query = "SELECT * FROM transactions";
        if ($startDate && $endDate) {
            $endDate = $endDate . ' 23:59:59';
            $query .= " WHERE transaction_date BETWEEN '$startDate' AND '$endDate'";
        }
        $query .= " ORDER BY transaction_date DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getTransactionDetails($transactionId)
    {
        $id = (int)$transactionId;
        $query = "SELECT ti.*, p.name as product_name 
                  FROM transaction_items ti
                  JOIN products p ON ti.product_id = p.id
                  WHERE ti.transaction_id = $id";
        $result = mysqli_query($this->conn, $query);
        $items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
        return $items;
    }

    // --- INI FUNGSI-FUNGSI BARU YANG SEBELUMNYA HILANG ---

    public function getTodaysSales()
    {
        $today = date('Y-m-d');
        $query = "SELECT SUM(total_price) as total FROM transactions WHERE DATE(transaction_date) = '$today'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function getTotalTransactions()
    {
        $query = "SELECT COUNT(id) as total FROM transactions";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
    public function getRecentTransactions($limit = 5)
    {
        $limit = (int)$limit;
        $query = "
            SELECT t.id, t.total_price, u.username
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            ORDER BY t.transaction_date DESC
            LIMIT ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        return $transactions;
    }

    public function updatePaymentProof($transactionId, $proofFileName)
    {
        $id = (int)$transactionId;
        // Status baru setelah bukti di-upload
        $newStatus = 'Menunggu Konfirmasi';

        // Kita pakai prepared statement biar super aman
        $stmt = $this->conn->prepare(
            "UPDATE transactions SET payment_proof = ?, payment_status = ? WHERE id = ?"
        );
        // "ssi" artinya tipe datanya string, string, integer
        $stmt->bind_param("ssi", $proofFileName, $newStatus, $id);

        return $stmt->execute();
    }
    public function getTransactionDetailsForUser($transactionId, $userId)
    {
        $transactionId = (int)$transactionId;
        $userId = (int)$userId;

        // KODE BARU YANG BENAR
        $query = "
            SELECT ti.*, p.name as product_name, t.total_price, t.transaction_date
            FROM transaction_items ti
            JOIN products p ON ti.product_id = p.id
            JOIN transactions t ON ti.transaction_id = t.id
            WHERE ti.transaction_id = ? AND t.user_id = ?
        ";

        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $transactionId, $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $details = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $details[] = $row;
        }
        return $details;
    }

    public function getBestSellingProducts($limit = 5)
    {
        $limit = (int)$limit;
        $query = "
            SELECT p.name, SUM(ti.quantity) as total_sold
            FROM transaction_items ti
            JOIN products p ON ti.product_id = p.id
            GROUP BY ti.product_id, p.name
            ORDER BY total_sold DESC
            LIMIT ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public function getTransactionForUser($transactionId, $userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $transactionId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getAllTransactionsWithUser()
    {
        // Pastikan `t.payment_proof` ada di dalam SELECT
        $query = "
        SELECT t.*, u.username 
        FROM transactions t
        JOIN users u ON t.user_id = u.id
        ORDER BY t.transaction_date DESC
    ";
        $result = mysqli_query($this->conn, $query);
        $transactions = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $transactions[] = $row;
        }
        return $transactions;
    }

    /**
     * FUNGSI BARU: Untuk update status pesanan.
     */
    public function updateStatus($transactionId, $newStatus)
    {
        $id = (int)$transactionId;
        // Kita pakai prepared statement biar aman dari SQL Injection
        $stmt = $this->conn->prepare("UPDATE transactions SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $id);
        return $stmt->execute();
    }
    public function getTransactionsByUserId($userId)
    {
        $userId = (int)$userId;
        $query = "SELECT * FROM transactions WHERE user_id = ? ORDER BY transaction_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        return $transactions;
    }

    public function getWeeklySalesData()
    {
        $query = "
            SELECT 
                DATE_FORMAT(transaction_date, '%W') as day_name,
                DATE_FORMAT(transaction_date, '%Y-%m-%d') as sale_date,
                SUM(total_price) as total_sales
            FROM transactions
            WHERE transaction_date >= CURDATE() - INTERVAL 6 DAY
            GROUP BY sale_date, day_name
            ORDER BY sale_date ASC;
        ";
        $result = mysqli_query($this->conn, $query);

        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dayName = date('l', strtotime($date));
            $days[$dayName] = 0;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $days[$row['day_name']] = (int)$row['total_sales'];
        }

        return [
            'labels' => array_keys($days),
            'data' => array_values($days)
        ];
    }
}
