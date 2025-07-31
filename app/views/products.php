<?php
// File: app/views/products.php (Versi Bersih)
$title = "Manajemen Produk";
global $action;
?>

<div class="d-flex">
    <?php include 'templates/sidebar.php'; ?>

    <div class="flex-grow-1">
        <?php include 'templates/header.php'; ?>
        
        <main class="p-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Produk</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        + Tambah Produk Baru
                    </button>
                </div>
            </div>

            <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($products) && mysqli_num_rows($products) > 0): $i = 1; ?>
                            <?php while($row = mysqli_fetch_assoc($products)): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><img src="../images/products/<?= htmlspecialchars($row['image_url']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" width="60" height="60" class="rounded" style="object-fit: cover;"></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td>Rp <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                <td><?= $row['stock']; ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#editProductModal">Edit</button>
                                    <a href="index.php?action=deleteProduct&id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Belum ada produk.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php include 'templates/footer.php'; ?>
    </div>
</div>

<div class="modal fade" id="addProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Tambah Produk Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <form action="index.php?action=createProduct" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="mb-3"><label for="name" class="form-label">Nama Produk</label><input type="text" class="form-control" name="name" required></div>
            <div class="mb-3"><label for="price" class="form-label">Harga</label><input type="number" class="form-control" name="price" required></div>
            <div class="mb-3"><label for="stock" class="form-label">Stok Awal</label><input type="number" class="form-control" name="stock" required></div>
            <div class="mb-3"><label for="image" class="form-label">Gambar Produk</label><input class="form-control" type="file" name="image"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan</button></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editProductModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Produk</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="edit-form" action="index.php?action=updateProduct" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="hidden" id="edit-id" name="id">
            <div class="mb-3"><label for="edit-name" class="form-label">Nama Produk</label><input type="text" class="form-control" id="edit-name" name="name" required></div>
            <div class="mb-3"><label for="edit-price" class="form-label">Harga</label><input type="number" class="form-control" id="edit-price" name="price" required></div>
            <div class="mb-3"><label for="edit-stock" class="form-label">Stok</label><input type="number" class="form-control" id="edit-stock" name="stock" required></div>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <img id="edit-current-image" src="" alt="Gambar Produk" width="100" class="mb-2">
            </div>
            <div class="mb-3"><label for="edit-image" class="form-label">Upload Gambar Baru (Opsional)</label><input class="form-control" type="file" id="edit-image" name="image"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editProductModal = document.getElementById('editProductModal');
    editProductModal.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const productId = button.dataset.id;
        const response = await fetch(`index.php?action=getProduct&id=${productId}`);
        const product = await response.json();
        document.getElementById('edit-id').value = product.id;
        document.getElementById('edit-name').value = product.name;
        document.getElementById('edit-price').value = product.price;
        document.getElementById('edit-stock').value = product.stock;
        document.getElementById('edit-current-image').src = `../images/products/${product.image_url}`;
    });
});
</script>