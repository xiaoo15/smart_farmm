<?php
// File: config/database.php

// Setting koneksi database
$db_host = 'localhost';   // Biasanya 'localhost'
$db_user = 'root';        // Default username XAMPP
$db_pass = '';            // Default password XAMPP (kosong)
$db_name = 'smart_farm_db';// Nama database yang kamu buat

// Membuat koneksi
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$conn) {
    die("KONEKSI GAGAL: " . mysqli_connect_error());
}

// Set timezone biar waktu transaksinya sesuai WIB
date_default_timezone_set('Asia/Jakarta');

// Fungsi helper buat query biar lebih rapi (opsional tapi sangat membantu)
function query($sql) {
    global $conn;
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

?>