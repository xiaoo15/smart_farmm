<?php
// File: app/views/auth/login.php
$title = "Login Admin"; // Variabel ini akan ditangkap oleh header.php
include __DIR__ . '/../templates/header.php'; // Panggil template header
?>

<div class="container">
    <div class="row login-container">
        <div class="col-md-5 col-lg-4 mx-auto">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <h5 class="card-title text-center mb-4 fw-bold fs-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-tree-fill me-2" viewBox="0 0 16 16" style="color: var(--primary-green);">
                            <path d="M8.416.223a.5.5 0 0 0-.832 0l-3 4.5A.5.5 0 0 0 5 5.5h.098L3.076 8.735A.5.5 0 0 0 3.5 9.5h.191l-1.638 3.276a.5.5 0 0 0 .447.724H7V16h2v-2.5h4.5a.5.5 0 0 0 .447-.724L12.31 9.5h.191a.5.5 0 0 0 .424-.765L10.902 5.5H11a.5.5 0 0 0 .416-.777z" />
                        </svg>
                        SmartFarm Login
                    </h5>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
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
                            <button class="btn btn-primary btn-lg fw-bold" type="submit">Login</button>
                        </div>
                        <div class="text-center mt-3">
                            <a class="small" href="index.php?action=showRegister">Belum punya akun? Daftar di sini!</a>
                        </div>
                    </form>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3 text-muted">© 2025 SmartFarm by Revan</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../templates/footer.php'; // Panggil template footer 
?>