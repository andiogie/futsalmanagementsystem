// resources/js/landing.js

// Contoh fungsi sederhana: scroll halus ke bagian tertentu
document.addEventListener("DOMContentLoaded", function () {
    // Tangkap semua link dengan tanda #
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault(); // hentikan aksi default
            document.querySelector(this.getAttribute("href")).scrollIntoView({
                behavior: "smooth"
            });
        });
    });
});