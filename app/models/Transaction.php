<?php
// File: app/models/Transaction.php

class Transaction
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }




    public function create($cartData, $userId, $paymentMethod) {
        // Kita pastikan sekali lagi $userId adalah angka
        $userId = (int)$userId;
        if ($userId <= 0) {
            // Jika karena suatu alasan aneh $userId tetap tidak valid, gagalkan dari awal.
            return false;
        }

        mysqli_begin_transaction($this->conn);
        try {
            $totalPrice = 0;
            // ... (logika hitung total harga sama) ...
            foreach ($cartData as $item) { $totalPrice += $item['price'] * $item['quantity']; }

            $queryTrans = "INSERT INTO transactions (user_id, total_price, payment_method) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->conn, $queryTrans);
            mysqli_stmt_bind_param($stmt, "ids", $userId, $totalPrice, $paymentMethod);
            mysqli_stmt_execute($stmt);
            $transactionId = mysqli_insert_id($this->conn);

            // ... (sisa logika insert item & update stok sama persis) ...
            
            mysqli_commit($this->conn);
            return $transactionId;

        } catch (Exception $exception) {
            mysqli_rollback($this->conn);
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

    // ---- TAMBAHKAN FUNGSI BARU DI BAWAH INI ----
    public function getTransactionsByUserId($userId)
    {
        $userId = (int)$userId;
        $query = "SELECT * FROM transactions WHERE user_id = $userId ORDER BY transaction_date DESC";
        return mysqli_query($this->conn, $query);
    }

    public function getTransactionDetailsForUser($transactionId, $userId)
    {
        $transactionId = (int)$transactionId;
        $userId = (int)$userId;

        // Query ini menggabungkan pengecekan ID transaksi dan ID pengguna
        $query = "
            SELECT ti.*, p.name as product_name, t.total_price, t.transaction_date
            FROM transaction_items ti
            JOIN products p ON ti.product_id = p.id
            JOIN transactions t ON ti.transaction_id = t.id
            WHERE ti.transaction_id = $transactionId AND t.user_id = $userId
        ";
        $result = mysqli_query($this->conn, $query);
        $details = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $details[] = $row;
        }
        return $details;
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
