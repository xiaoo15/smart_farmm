// File: public/js/pos.js

// Variabel untuk menyimpan item di keranjang
let cart = [];

// Fungsi untuk menambah produk ke keranjang
function addToCart(product) {
    // Cek apakah produk sudah ada di keranjang
    const existingProduct = cart.find(item => item.id === product.id);

    if (existingProduct) {
        // Jika sudah ada, tambah quantity-nya
        existingProduct.quantity++;
    } else {
        // Jika belum ada, tambahkan produk baru ke keranjang
        cart.push({ ...product, quantity: 1 });
    }
    renderCart();
}

// Fungsi untuk merender/menampilkan ulang isi keranjang
function renderCart() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');
    const processBtn = document.getElementById('process-payment-btn');
    let total = 0;

    // Kosongkan dulu tampilan keranjang
    cartItemsContainer.innerHTML = '';

    if (cart.length === 0) {
        cartItemsContainer.innerHTML = '<tr><td colspan="4" class="text-center">Keranjang kosong</td></tr>';
        processBtn.disabled = true;
    } else {
        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;

            const cartRow = `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                        ${item.quantity}
                        <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    </td>
                    <td>${formatRupiah(subtotal)}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="removeFromCart(${index})">X</button></td>
                </tr>
            `;
            cartItemsContainer.innerHTML += cartRow;
        });
        processBtn.disabled = false;
    }

    cartTotalElement.innerText = formatRupiah(total);
}

// Fungsi untuk mengubah jumlah item
function updateQuantity(index, change) {
    if (cart[index].quantity + change > 0) {
        cart[index].quantity += change;
    } else {
        // Jika quantity jadi 0, hapus item
        removeFromCart(index);
    }
    renderCart();
}

// Fungsi untuk menghapus item dari keranjang
function removeFromCart(index) {
    cart.splice(index, 1);
    renderCart();
}

// Fungsi untuk format angka ke Rupiah
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
}

// Event Listener untuk tombol Proses Pembayaran
document.getElementById('process-payment-btn').addEventListener('click', async () => {
    if (confirm('Proses transaksi ini?')) {
        try {
            const response = await fetch('index.php?action=processTransaction', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(cart)
            });
            const result = await response.json();

            if (result.success) {
                alert(`Transaksi berhasil! ID Transaksi: ${result.transactionId}`);
                cart = []; // Kosongkan keranjang
                renderCart();
                // Idealnya, di sini bisa redirect ke halaman cetak struk
                // window.open(`index.php?action=printReceipt&id=${result.transactionId}`);
                location.reload(); // Reload halaman untuk update stok produk
            } else {
                alert(`Error: ${result.message}`);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghubungi server.');
        }
    }
});

// Event listener untuk fitur pencarian produk
document.getElementById('product-search').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        const productName = card.dataset.name;
        if (productName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});