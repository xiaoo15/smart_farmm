</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('overlay');
    const wrapper = document.getElementById('admin-wrapper');
    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        } else {
            wrapper.classList.toggle('sidebar-collapsed');
        }
    }
    if (sidebarToggle) { sidebarToggle.addEventListener('click', toggleSidebar); }
    if (overlay) { overlay.addEventListener('click', toggleSidebar); }
});
</script>
</body>
</html>