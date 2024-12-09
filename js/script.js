window.onload = function() {
    // Cek apakah snackbar ada
    var snackbar = document.getElementById("snackbar");

    // Jika snackbar ada, tampilkan dan sembunyikan setelah beberapa detik
    if (snackbar) {
        snackbar.classList.add("show");

        // Sembunyikan snackbar setelah 3 detik
        setTimeout(function() {
            snackbar.classList.remove("show");
        }, 3000); // 3000ms = 3 detik
    }
};
