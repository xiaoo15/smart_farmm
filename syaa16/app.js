// File: syaa16/app.js
document.addEventListener('DOMContentLoaded', function() {
    // Ambil isi _sidebar.html
    fetch('_sidebar.html')
        .then(response => {
            if (!response.ok) throw new Error("File _sidebar.html tidak ditemukan!");
            return response.text();
        })
        .then(data => {
            // Masukkan isinya ke dalam wadah sidebar
            document.getElementById('sidebar-container').innerHTML = data;
            // Setelah sidebar dimuat, jalankan fungsi untuk highlight menu
            highlightActiveMenu();
        })
        .catch(error => {
            console.error("Error memuat sidebar:", error);
            document.getElementById('sidebar-container').innerHTML = "<p class='text-danger p-3'>Gagal memuat sidebar.</p>";
        });

    function highlightActiveMenu() {
        // Dapatkan nama file halaman saat ini, misal "my_product.html"
        const currentPage = window.location.pathname.split("/").pop();
        const menuItems = document.querySelectorAll('.sidebar-nav .sidebar-item');
        
        menuItems.forEach(item => {
            // Cek data-page yang kita set di HTML tadi
            if (item.dataset.page === currentPage) {
                item.classList.add('active');
            }
        });
    }
});