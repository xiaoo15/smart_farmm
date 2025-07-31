<?php
// File: app/models/User.php

require_once __DIR__ . '/../../config/database.php';

class User {
    // ... (method attemptLogin yang sudah ada sebelumnya) ...

    public function attemptLogin($username, $password) {
        global $conn;
        $username = mysqli_real_escape_string($conn, $username);
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    // --- TAMBAHKAN METHOD DI BAWAH INI ---
    public function register($username, $password) {
        global $conn;

        $username = mysqli_real_escape_string($conn, $username);
        
        // 1. Cek dulu apakah username sudah ada
        $checkUserSql = "SELECT id FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $checkUserSql);
        if (mysqli_num_rows($result) > 0) {
            return 'exists'; // User sudah ada
        }

        // 2. Hash password sebelum disimpan (SUPER PENTING!)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 3. Insert user baru ke database
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', 'admin')";
        
        if (mysqli_query($conn, $sql)) {
            return 'success'; // Registrasi berhasil
        } else {
            return 'fail'; // Gagal karena error database
        }
    }
}
?>