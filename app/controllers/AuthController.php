<?php
// File: app/controllers/AuthController.php

require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function showLogin() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->attemptLogin($_POST['username'], $_POST['password']);
            if ($user) {
                $_SESSION['user'] = $user;

                if ($user['role'] === 'admin') {
                    // Jika admin, arahkan ke pintu masuk admin
                    header('Location: public/index.php?action=dashboard');
                } else {
                    // Jika customer, arahkan ke pintu masuk customer
                    header('Location: index.php?action=home');
                }
                exit;
            } else {
                // Jika gagal, kembali ke form login customer
                header('Location: index.php?action=showLogin&error=1');
                exit;
            }
        } else {
            $this->showLogin();
        }
    }

    public function handleLogout() {
        session_destroy();
        // Selalu arahkan ke halaman login customer setelah logout
        header('Location: index.php?action=showLogin');
        exit;
    }

    public function showRegisterForm() {
        include __DIR__ . '/../views/auth/register.php';
    }

    

    public function handleRegister() {
        // Validasi data
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['username']) || empty($_POST['password'])) {
            header('Location: index.php?action=showRegister');
            exit;
        }

        if ($_POST['password'] !== $_POST['confirm_password']) {
            $_SESSION['flash_message'] = "Password dan Konfirmasi Password tidak cocok!";
            $_SESSION['flash_message_type'] = "danger";
            header('Location: index.php?action=showRegister');
            exit;
        }

        // Panggil model untuk proses registrasi
        $userModel = new User();
        $result = $userModel->register($_POST['username'], $_POST['password']);

        if ($result === 'success') {
            $_SESSION['flash_message'] = "Registrasi berhasil! Silakan login.";
            $_SESSION['flash_message_type'] = "success";
            header('Location: index.php?action=showLogin');
            exit;
        } elseif ($result === 'exists') {
            $_SESSION['flash_message'] = "Username sudah digunakan, coba yang lain.";
            $_SESSION['flash_message_type'] = "danger";
            header('Location: index.php?action=showRegister');
            exit;
        } else {
            $_SESSION['flash_message'] = "Terjadi kesalahan, registrasi gagal.";
            $_SESSION['flash_message_type'] = "danger";
            header('Location: index.php?action=showRegister');
            exit;
        }
    }
}


?>