document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById("sidebarToggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if (!toggleBtn || !sidebar) return;

    toggleBtn.addEventListener("click", function () {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle("show");
            if (overlay) overlay.classList.toggle("show");
        } else {
            sidebar.classList.toggle("collapsed");
        }
    });

    if (overlay) {
        overlay.addEventListener("click", function () {
            sidebar.classList.remove("show");
            overlay.classList.remove("show");
        });
    }

    // 🔥 event delegation (fix utama)
    document.addEventListener("click", function (e) {
        const link = e.target.closest(".sidebar .menu a");
        if (!link) return;

        if (window.innerWidth <= 768) {
            sidebar.classList.remove("show");
            if (overlay) overlay.classList.remove("show");
        }
    });

});