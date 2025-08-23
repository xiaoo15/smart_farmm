// File: syaa16/app.js (VERSI FINAL + RESPONSIVE)
document.addEventListener("DOMContentLoaded", function () {
  fetch("_sidebar.html")
    .then((response) =>
      response.ok ? response.text() : Promise.reject("Sidebar not found")
    )
    .then((data) => {
      document.getElementById("sidebar-container").innerHTML = data;
      highlightActiveMenu();
      // Panggil fungsi event listener SETELAH sidebar dimuat
      setupEventListeners();
    })
    .catch((error) => console.error("Error loading sidebar:", error));

  function highlightActiveMenu() {
    const currentPage = window.location.pathname.split("/").pop();
    const menuItems = document.querySelectorAll(".sidebar-nav .sidebar-item");
    menuItems.forEach((item) => {
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
