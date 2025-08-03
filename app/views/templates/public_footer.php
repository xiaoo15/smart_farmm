<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const toastElement = document.getElementById('addCartToast');
        const toast = toastElement ? new bootstrap.Toast(toastElement) : null;
        const toastBody = document.getElementById('toast-body-message');

        function initializeCartButtons() {
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                const newButton = button.cloneNode(true);
                button.parentNode.replaceChild(newButton, button);
            });

            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const productId = this.dataset.id;

                    // --- INI DIA OTAK BARUNYA! ---
                    let productName = 'Produk'; // Default name
                    const card = this.closest('.product-card'); // Coba cari di kartu
                    if (card) {
                        productName = card.querySelector('.product-title').textContent;
                    } else {
                        // Jika tidak di kartu (berarti di hal. detail), cari judul utama
                        const mainTitle = document.querySelector('h1.h2');
                        if (mainTitle) {
                            productName = mainTitle.textContent;
                        }
                    }
                    // --- BATAS OTAK BARU ---

                    try {
                        const response = await fetch(`index.php?action=addToCartAjax`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: productId
                            })
                        });

                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        const result = await response.json();

                        if (result.success) {
                            if (toast && toastBody) {
                                toastBody.textContent = `"${productName.trim()}" berhasil ditambahkan!`;
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

        function updateCartBadge(count) {
            const badge = document.querySelector('.cart-badge');
            if (badge) {
                badge.innerText = count;
                badge.style.display = count > 0 ? 'inline-block' : 'none';
            }
        }

        initializeCartButtons();
        window.reinitializeCartButtons = initializeCartButtons;
    });
</script>