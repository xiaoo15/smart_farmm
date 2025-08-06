<?php
// File: app/views/customers.php (FILE BARU!)
$title = "Manajemen Pelanggan";
global $action;
?>

<div class="admin-wrapper">
    <?php include 'templates/sidebar.php'; ?>
    <?php include 'templates/header.php'; ?>


    <div class="content-wrapper">
        <main class="p-4">
            <h1 class="h2 mb-4">Manajemen Pelanggan</h1>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID User</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($customers) && !empty($customers)): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= $customer['id'] ?></td>
                                            <td><?= htmlspecialchars($customer['username']) ?></td>
                                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($customer['role']) ?></span></td>
                                            <td class="text-center">
                                                <a href="index.php?action=customerDetail&id=<?= $customer['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-history me-1"></i> Lihat Riwayat
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center p-5 text-muted">Belum ada pelanggan yang terdaftar.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <?php include 'templates/footer.php'; ?>
    </div>
</div>