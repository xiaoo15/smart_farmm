<?php
$title = "Keranjang Belanja";
include 'templates/public_header.php';
?>

<style>
    /* Sembunyikan tampilan kartu di layar besar (md ke atas) */
    @media (min-width: 768px) {
        .cart-cards-view {
            display: none;
        }
    }

    /* Sembunyikan tampilan tabel di layar kecil (di bawah md) */
    @media (max-width: 767.98px) {
        .cart-table-view {
            display: none;
        }

        .cart-summary {
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
            margin-top: 1rem;
        }
    }

    /* Styling untuk tampilan kartu di mobile */
    .cart-card-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .cart-card-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }

    .cart-card-item .item-details {
        flex-grow: 1;
        margin-left: 1rem;
    }

    .cart-card-item .item-actions {
        display: flex;
        align-items: center;
    }
</style>

<div class="container my-5">
    <h1 class="display-6 fw-bold mb-4">Keranjang Belanja Anda</h1>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi utama untuk mengambil dan merender keranjang
        async function fetchAndRenderCart() {
            try {
                const response = await fetch('index.php?action=getCartData');
                const cart = await response.json();
                renderCart(cart);
            } catch (error) {
                console.error('Gagal memuat keranjang:', error);
                document.getElementById('cart-container').innerHTML = '<p class="text-danger text-center">Gagal memuat keranjang. Coba refresh halaman.</p>';
            }
        }

        // Fungsi untuk menampilkan data keranjang ke HTML
        function renderCart(cart) {
            // DEBUGGING: Cek data yang diterima dari server
            console.log("Data keranjang diterima:", cart);

            const container = document.getElementById('cart-container');

            if (!cart.items || cart.items.length === 0) {
                container.innerHTML = `
                <div class="text-center p-5 border rounded bg-white">
                    <h3 class="fw-bold">Keranjang Anda Kosong</h3>
                    <p class="text-muted">Sepertinya Anda belum menambahkan produk apapun.</p>
                    <a href="index.php?action=home" class="btn btn-success mt-2">Mulai Belanja</a>
                </div>
            `;
                return;
            }

            // --- TEMPLATE UNTUK TAMPILAN TABEL (DESKTOP) ---
            let tableRows = cart.items.map(item => `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="public/images/products/${item.image_url}" alt="${item.name}" style="width: 70px; height: 70px; object-fit: cover;" class="me-3 rounded">
                        <div>
                            <h6 class="mb-0">${item.name}</h6>
                            <small class="text-muted">Rp ${formatRupiah(item.price)}</small>
                        </div>
                    </div>
                </td>
                <td class="text-center align-middle">
                    <div class="input-group" style="width: 120px; margin: auto;">
                        <button class="btn btn-outline-secondary btn-sm" onclick="updateCartItem(${item.id}, 'dec')">-</button>
                        <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                        <button class="btn btn-outline-secondary btn-sm" onclick="updateCartItem(${item.id}, 'inc')">+</button>
                    </div>
                </td>
                <td class="text-end align-middle fw-bold">Rp ${formatRupiah(item.subtotal)}</td>
                <td class="text-center align-middle">
                    <button class="btn btn-sm btn-outline-danger" onclick="removeCartItem(${item.id})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');

            // --- TEMPLATE UNTUK TAMPILAN KARTU (MOBILE) ---
            let cardItems = cart.items.map(item => `
            <div class="cart-card-item">
                <img src="public/images/products/${item.image_url}" alt="${item.name}">
                <div class="item-details">
                    <h6 class="mb-1">${item.name}</h6>
                    <p class="fw-bold text-success mb-2">Rp ${formatRupiah(item.subtotal)}</p>
                    <div class="item-actions">
                        <div class="input-group input-group-sm" style="width: 100px;">
                            <button class="btn btn-outline-secondary" onclick="updateCartItem(${item.id}, 'dec')">-</button>
                            <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                            <button class="btn btn-outline-secondary" onclick="updateCartItem(${item.id}, 'inc')">+</button>
                        </div>
                        <button class="btn btn-sm text-danger ms-auto" onclick="removeCartItem(${item.id})"><i class="fas fa-trash fs-5"></i></button>
                    </div>
                </div>
            </div>
        `).join('');

            // --- GABUNGKAN SEMUA TAMPILAN ---
            container.innerHTML = `
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-table-view card">
                        <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead class="table-light"><tr><th scope="col" style="width: 50%;">Produk</th><th scope="col" class="text-center">Jumlah</th><th scope="col" class="text-end">Subtotal</th><th scope="col" class="text-center">Aksi</th></tr></thead><tbody>${tableRows}</tbody></table></div>
                    </div>
                    <div class="cart-cards-view card card-body">
                        ${cardItems}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card cart-summary">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Ringkasan Belanja</h5><hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <span>Rp ${formatRupiah(cart.total)}</span>
                            </div>
                            <div class="d-flex justify-content-between fs-5 fw-bold">
                                <span>Total</span>
                                <span>Rp ${formatRupiah(cart.total)}</span>
                            </div>
                            <div class="d-grid mt-3">
                                <a href="index.php?action=showCheckout" class="btn btn-success btn-lg">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        }

        // Fungsi untuk mengupdate item (tambah/kurang)
        window.updateCartItem = async function(id, op) {
            await fetch('index.php?action=updateCartAjax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    op: op
                })
            });
            fetchAndRenderCart();
            updateCartBadge();
        }

        // Fungsi untuk menghapus item
        window.removeCartItem = async function(id) {
            if (confirm('Yakin hapus produk ini dari keranjang?')) {
                await fetch('index.php?action=removeFromCartAjax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                });
                fetchAndRenderCart();
                updateCartBadge();
            }
        }

        // Fungsi untuk format Rupiah (DENGAN PENGAMAN)
        function formatRupiah(angka) {
            // Jika angka bukan number (undefined, null, dll), anggap saja 0
            if (isNaN(parseFloat(angka))) {
                return '0';
            }
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        // Fungsi untuk update badge di header
        async function updateCartBadge() {
            const response = await fetch('index.php?action=getCartData');
            const cart = await response.json();
            const badge = document.querySelector('.cart-badge');
            if (badge) {
                badge.innerText = cart.items ? cart.items.length : 0;
                if (cart.items && cart.items.length > 0) {
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            }
        }

        // Panggil fungsi utama saat halaman pertama kali dimuat
        fetchAndRenderCart();
    });
</script>