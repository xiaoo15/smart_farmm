<?php 
$title = "Keranjang Belanja"; 
include 'templates/public_header.php'; 
?>

<div class="container my-5">
    <h2 class="mb-4">Keranjang Belanja Anda</h2>
    <div id="cart-container">
        <div class="text-center p-5">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat keranjang...</p>
        </div>
    </div>
</div>

<?php include 'templates/public_footer.php'; ?>

<script>
// Fungsi utama untuk mengambil dan merender keranjang
async function fetchAndRenderCart() {
    try {
        const response = await fetch('index.php?action=getCartData');
        const cart = await response.json();
        renderCart(cart);
    } catch (error) {
        console.error('Gagal memuat keranjang:', error);
        document.getElementById('cart-container').innerHTML = '<p class="text-danger text-center">Gagal memuat keranjang.</p>';
    }
}

// Fungsi untuk menampilkan data keranjang ke HTML
function renderCart(cart) {
    const container = document.getElementById('cart-container');
    
    if (!cart.items || cart.items.length === 0) {
        container.innerHTML = `
            <div class="text-center p-5 border rounded">
                <h3>Keranjang Anda Kosong</h3>
                <p class="text-muted">Sepertinya Anda belum menambahkan produk apapun ke keranjang.</p>
                <a href="index.php?action=home#katalog" class="btn btn-primary mt-2">Mulai Belanja</a>
            </div>
        `;
        return;
    }

    let tableRows = cart.items.map(item => `
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <img src="public/images/products/${item.image_url}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover;" class="me-3 rounded">
                    <div>
                        <h6 class="mb-0">${item.name}</h6>
                        <small class="text-muted">Rp ${formatRupiah(item.price)}</small>
                    </div>
                </div>
            </td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-secondary" onclick="updateCartItem(${item.id}, 'dec')">-</button>
                <span class="mx-2">${item.quantity}</span>
                <button class="btn btn-sm btn-outline-secondary" onclick="updateCartItem(${item.id}, 'inc')">+</button>
            </td>
            <td class="text-end fw-bold">Rp ${formatRupiah(item.subtotal)}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-danger" onclick="removeCartItem(${item.id})">&times;</button>
            </td>
        </tr>
    `).join('');

    container.innerHTML = `
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="width: 50%;">Produk</th>
                        <th scope="col" class="text-center">Jumlah</th>
                        <th scope="col" class="text-end">Subtotal</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>${tableRows}</tbody>
            </table>
        </div>
        <div class="row justify-content-end mt-4">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Belanja</h5>
                        <div class="d-flex justify-content-between fs-4 fw-bold">
                            <span>Total</span>
                            <span>Rp ${formatRupiah(cart.total)}</span>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="index.php?action=showCheckout" class="btn btn-success btn-lg">Checkout Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Fungsi untuk mengupdate item (tambah/kurang)
async function updateCartItem(id, op) {
    await fetch('index.php?action=updateCartAjax', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, op: op })
    });
    fetchAndRenderCart(); // Ambil dan render ulang keranjang
    updateCartBadge(); // Update badge di header
}

// Fungsi untuk menghapus item
async function removeCartItem(id) {
    if (confirm('Yakin hapus produk ini dari keranjang?')) {
        await fetch('index.php?action=removeFromCartAjax', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: id })
        });
        fetchAndRenderCart(); // Ambil dan render ulang keranjang
        updateCartBadge(); // Update badge di header
    }
}

// Fungsi untuk format Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}

// Fungsi untuk update badge di header (opsional tapi keren)
async function updateCartBadge() {
    const response = await fetch('index.php?action=getCartData');
    const cart = await response.json();
    const badge = document.querySelector('.cart-badge');
    if (badge) {
        badge.innerText = cart.items.length;
        if (cart.items.length > 0) {
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

// Panggil fungsi utama saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', fetchAndRenderCart);
</script>