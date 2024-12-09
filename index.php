<?php
session_start();

// Tentukan waktu kedaluwarsa sesi (12 jam dalam detik)
$session_timeout = 12 * 60 * 60; // 12 jam = 12 * 60 * 60 detik

// Cek apakah sesi 'login_time' sudah ada
if (isset($_SESSION['login_time'])) {
    // Hitung selisih waktu antara sekarang dan waktu login
    $elapsed_time = time() - $_SESSION['login_time'];

    // Jika sudah lebih dari 12 jam, logout otomatis
    if ($elapsed_time > $session_timeout) {
        // Hapus sesi dan redirect ke halaman login
        session_unset();
        session_destroy();

        // Hapus status login di localStorage
        echo "<script>
                localStorage.removeItem('logged_in');
                window.location.href = 'login.php'; // Redirect ke halaman login
              </script>";
        exit(); // Pastikan script berhenti setelah logout
    }
}

// Perbarui waktu login setiap kali halaman dimuat
$_SESSION['login_time'] = time();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php" id="login-button">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>

        <main>
            <section class="konten-utama">
                <div class="konten-box">
                    <h1>Selamat Datang di Platform Manajemen Pelanggan</h1>
                    <p>
                        Kami menyediakan layanan untuk mempermudah bisnis
                        Anda dalam mengelola pelanggan, penjualan,
                        pemasaran, dan pelaporan. Dengan sistem yang
                        terintegrasi, Anda dapat meningkatkan produktivitas
                        dan efisiensi.
                    </p>
                    <button class="cta-button">
                        Pelajari Lebih Lanjut
                    </button>
                </div>
                <img src="assets/businessimage.jpg" alt="Business Image" class="img-konten" />
            </section>
        </main>

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

</body>

<script>
    // Menggunakan localStorage hanya jika Anda menginginkan solusi berbasis sisi klien (misalnya untuk aplikasi tanpa login berbasis sesi).
    // Pastikan hanya mengubah localStorage jika login berhasil, dan hapus saat logout.

    document.addEventListener("DOMContentLoaded", function () {
        // Cek status login di sesi (jika menggunakan sesi PHP) atau di localStorage
        if (localStorage.getItem('logged_in') === 'true') {
            document.getElementById('login-button').innerHTML = 'Logout';
            document.getElementById('login-button').setAttribute('href', 'logout.php');
        }
    });
</script>

</html>