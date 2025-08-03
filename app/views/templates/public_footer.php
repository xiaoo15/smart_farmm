<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Siapkan notifikasi (toast)
    const toastElement = document.getElementById('addCartToast');
    const toast = toastElement ? new bootstrap.Toast(toastElement) : null;
    const toastBody = document.getElementById('toast-body-message');

    // Fungsi untuk meng-handle semua tombol "Tambah ke Keranjang"
    function initializeCartButtons() {
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            // Hapus event listener lama biar nggak numpuk
            button.replaceWith(button.cloneNode(true));
        });

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const productId = this.dataset.id;
                const productName = this.closest('.product-card').querySelector('.product-title').textContent;

                try {
                    const response = await fetch(`index.php?action=addToCartAjax`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: productId })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();
                    
                    if (result.success) {
                        if (toast && toastBody) {
                            toastBody.textContent = `"${productName}" berhasil ditambahkan!`;
                            toast.show();
                        }
                        updateCartBadge(result.cartCount);
                    } else {
                        if (result.message === 'login_required') {
                            alert('Anda harus login untuk menambahkan produk!');
                            window.location.href = 'index.php?action=showLogin';
                        } else {
                            alert('Gagal: ' + (result.message || 'Error tidak diketahui'));
                        }
                    }
                } catch (error) { 
                    console.error('Fetch Error:', error);
                    alert('Terjadi kesalahan saat menghubungi server.');
                }
            });
        });
    }

    // Fungsi untuk update badge keranjang di Navbar
    function updateCartBadge(count) {
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.innerText = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }
    
    // Jalankan fungsi inisialisasi saat halaman pertama kali dimuat
    initializeCartButtons();

    // PENTING! Kita buat fungsi ini bisa diakses dari luar
    // Biar nanti halaman filter bisa manggil ulang fungsi ini
    window.reinitializeCartButtons = initializeCartButtons;
});
</script>