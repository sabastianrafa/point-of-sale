<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="icon" href="assets/iconbg.png" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo">
                    <img src="assets/icon.png" alt="icon" />
                </div>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="#">Penjualan</a></li>
                    <li><a href="#">Kontak Pelanggan</a></li>
                    <li><a type="button" id="#" href="index.php">Log out</a></li>
                </ul>
            </nav>
        </header>

        <main>isi halaman Dashboard</main>

        <footer>
            <div class="footer-content">
                <p>&copy; 2024 Point of Sale. All rights reserved.</p>
                <div class="sosmed-icons">
                    <a href="#"><i class="ph ph-facebook-logo"></i></a>
                    <a href="#"><i class="ph ph-instagram-logo"></i></a>
                    <a href="#"><i class="ph ph-twitter-logo"></i></a>
                </div>
            </div>
        </footer>
    </div>

    <div id="snackbar">Selamat Datang di Dashboard</div>

    <script>
        // Show snackbar when the page is loaded
        window.onload = function () {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function () {
                x.className = x.className.replace("show", "");
            }, 3000);
        };
    </script>
</body>

</html>