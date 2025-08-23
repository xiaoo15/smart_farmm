// File: syaa16/app.js (VERSI FINAL + RESPONSIVE)
document.addEventListener("DOMContentLoaded", function () {
  const sidebarContainer = document.getElementById("sidebar-container");
  
  // Pastikan ada container sidebar, kalau tidak, berarti halaman itu tidak pakai sidebar
  if (sidebarContainer) {
    fetch("_sidebar.html")
      .then((response) =>
        response.ok ? response.text() : Promise.reject("Sidebar not found")
      )
      .then((data) => {
        sidebarContainer.innerHTML = data;
        highlightActiveMenu();
        setupEventListeners();
      })
      .catch((error) => console.error("Error loading sidebar:", error));
  }


  function highlightActiveMenu() {
    const currentPage = window.location.pathname.split("/").pop();
    const menuItems = document.querySelectorAll(".sidebar-nav .sidebar-item");
    menuItems.forEach((item) => {
      // Periksa atribut data-page pada <li>
      if (item.dataset.page === currentPage) {
        item.classList.add("active");
      }
    });
  }

  // FUNGSI BARU UNTUK KONTROL SIDEBAR DI HP
  function setupEventListeners() {
    const hamburgerBtn = document.querySelector(".hamburger-btn");
    const sidebar = document.querySelector(".sidebar");
    
    // Buat overlay jika belum ada
    let overlay = document.getElementById("overlay");
    if (!overlay) {
      overlay = document.createElement("div");
      overlay.id = "overlay";
      document.body.appendChild(overlay);
    }
    
    // Pastikan tombol dan sidebar ada
    if (hamburgerBtn && sidebar) {
      hamburgerBtn.addEventListener("click", () => {
        sidebar.classList.add("active");
        overlay.classList.add("active");
      });

      overlay.addEventListener("click", () => {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
      });
    }
  }
});

document.addEventListener('DOMContentLoaded', function () {

  // Load sidebar HTML
  fetch('_sidebar.html')
    .then(res => res.text())
    .then(html => {
      document.getElementById('sidebar-container').innerHTML = html;
      setupSidebarToggle();
      setupSidebarActive();
    });

  function setupSidebarToggle() {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.querySelector('.hamburger-btn');
    if (hamburger && sidebar) {
      hamburger.addEventListener('click', function () {
        sidebar.classList.toggle('active');
        hamburger.classList.toggle('active');
      });
      // Optional: close sidebar when clicking outside (mobile)
      document.addEventListener('click', function (e) {
        if (window.innerWidth < 992 && sidebar.classList.contains('active')) {
          if (!sidebar.contains(e.target) && !hamburger.contains(e.target)) {
            sidebar.classList.remove('active');
            hamburger.classList.remove('active');
          }
        }
      });
    }
  }

  function setupSidebarActive() {
    // Highlight menu yang aktif saat diklik
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;
    const links = sidebar.querySelectorAll('a');
    links.forEach(link => {
      link.addEventListener('click', function () {
        links.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });
    // Highlight menu sesuai url saat load
    const current = window.location.pathname.split('/').pop();
    links.forEach(link => {
      if (link.getAttribute('href') && link.getAttribute('href').includes(current)) {
        link.classList.add('active');
      }
    });
  }

  function setupSidebarActive() {
    // Highlight menu yang aktif saat diklik
    const sidebar = document.getElementById('sidebar');
    if (!sidebar) return;
    const links = sidebar.querySelectorAll('a');
    links.forEach(link => {
      link.addEventListener('click', function () {
        links.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });
    // Highlight menu sesuai url saat load
    const current = window.location.pathname.split('/').pop();
    links.forEach(link => {
      if (link.getAttribute('href') && link.getAttribute('href').includes(current)) {
        link.classList.add('active');
      }
    });
  }
});