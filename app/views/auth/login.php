<?php
// File: app/views/auth/login.php (VERSI DENGAN QR CODE)
$title = "Login ke SmartFarm";
include __DIR__ . '/../templates/public_header.php';
?>

<style>
    body {
        background: linear-gradient(135deg, #e9f5e9 0%, #f8f9fa 100%);
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: row;
        max-width: 900px;
        width: 100%;
    }
    
    /* ===== INI DIA BAGIAN BARUNYA! ===== */
    .login-qr-section {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        color: #ffffff;
        text-align: center;
    }

    .login-qr-section img {
        background-color: #ffffff;
        padding: 10px;
        border-radius: 15px;
        max-width: 200px;
        width: 100%;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    /* ==================================== */

    .login-form-section {
        padding: 3rem;
        background-color: #ffffff;
        flex: 1;
    }

    .form-floating > .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }

    .btn-login-submit {
        background-color: #28a745;
        border-color: #28a745;
        font-weight: 600;
        padding: 12px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    .btn-login-submit:hover {
        background-color: #218838;
        border-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 767.98px) {
        .login-qr-section {
            display: none; /* Sembunyikan QR di HP biar nggak menuhin layar */
        }
        .login-card {
            flex-direction: column;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-qr-section">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=https://github.com/xiaoo15&bgcolor=ffffff&color=28a745&qzone=2" alt="QR Code Login">
            <h4 class="fw-bold">Login via Aplikasi?</h4>
            <p class="small">Scan QR code di atas untuk masuk lebih cepat melalui aplikasi mobile SmartFarm.</p>
        </div>

        <div class="login-form-section">
            <div class="text-center mb-4">
                <a class="navbar-brand fs-3" href="index.php?action=home">
                    <i class="fas fa-leaf text-success me-2"></i>
                    SmartFarm
                </a>
                <p class="text-muted mt-2">Selamat datang kembali!</p>
            </div>

            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?= $_SESSION['flash_message_type'] ?? 'success' ?> mb-3">
                    <?= $_SESSION['flash_message']; ?>
                </div>
            <?php 
                unset($_SESSION['flash_message']); 
                unset($_SESSION['flash_message_type']); 
            endif; 
            ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger mb-3">
                    Username atau password salah!
                </div>
            <?php endif; ?>

            <form action="index.php?action=login" method="POST">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-login-submit" type="submit">Login</button>
                </div>
                <div class="text-center mt-3">
                    <small>Belum punya akun? <a href="index.php?action=showRegister">Daftar di sini!</a></small>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
// Panggil public_footer karena ini halaman customer
include __DIR__ . '/../templates/public_footer.php'; 
?>