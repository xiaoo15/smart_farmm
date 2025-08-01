<?php
// File: app/models/User.php (VERSI FINAL)

require_once __DIR__ . '/../../config/database.php';

class User {
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

    public function register($username, $password) {
        global $conn;
        $username = mysqli_real_escape_string($conn, $username);
        
        $checkUserSql = "SELECT id FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $checkUserSql);
        if (mysqli_num_rows($result) > 0) {
            return 'exists';
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ===== INI YANG DIBENERIN! ROLE-NYA SEKARANG 'customer' =====
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashedPassword', 'customer')";
        
        if (mysqli_query($conn, $sql)) {
            return 'success';
        } else {
            return 'fail';
        }
    }
}