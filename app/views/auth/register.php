<?php
$title = "Registrasi Admin";
include __DIR__ . '/../templates/header.php';
?>

<div class="container">
    <div class="row login-container">
        <div class="col-md-5 col-lg-4 mx-auto">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-4 fw-bold fs-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-plus-fill me-2" viewBox="0 0 16 16" style="color: var(--primary-green);">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                        Daftar Akun Baru
                    </h5>

                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?= $_SESSION['flash_message_type'] ?? 'success' ?> alert-dismissible fade show" role="alert">
                            <?= $_SESSION['flash_message']; ?>
                        </div>
                    <?php 
                        unset($_SESSION['flash_message']); 
                        unset($_SESSION['flash_message_type']); 
                    endif; 
                    ?>

                    <form action="index.php?action=register" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>
                         <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                            <label for="confirm_password">Konfirmasi Password</label>
                        </div>
                        <div class="d-grid mb-2">
                            <button class="btn btn-primary btn-lg fw-bold" type="submit">Daftar</button>
                        </div>
                        <div class="text-center">
                            <a class="small" href="index.php?action=showLogin">Sudah punya akun? Login!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>