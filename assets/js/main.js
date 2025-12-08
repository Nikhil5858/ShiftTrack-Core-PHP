document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("sidebar-open");
        overlay.classList.toggle("active");
    });

    overlay.addEventListener("click", function () {
        sidebar.classList.remove("sidebar-open");
        overlay.classList.remove("active");
    });

});

document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".sidebar .nav-link");

    navLinks.forEach(link => {
        link.addEventListener("click", function () {

            navLinks.forEach(l => l.classList.remove("active"));

            this.classList.add("active");

            localStorage.setItem("active_sidebar", this.getAttribute("href"));
        });
    });

    const activePage = localStorage.getItem("active_sidebar");
    if (activePage) {
        navLinks.forEach(link => {
            if (link.getAttribute("href") === activePage) {
                link.classList.add("active");
            }
        });
    }
});
