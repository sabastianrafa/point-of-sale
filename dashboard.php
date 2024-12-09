<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Arahkan ke login.php jika belum login
    exit();
}

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

// Koneksi database
include('koneksi.php');

// Query untuk menghitung jumlah data produk
$query_produk = "SELECT COUNT(*) AS total_produk FROM tb_produk";
$result_produk = $conn->query($query_produk);
$data_produk = $result_produk->fetch_assoc();
$total_produk = $data_produk['total_produk'];

// Query untuk menghitung jumlah data pelanggan
$query_pelanggan = "SELECT COUNT(*) AS total_pelanggan FROM tb_pelanggan";
$result_pelanggan = $conn->query($query_pelanggan);
$data_pelanggan = $result_pelanggan->fetch_assoc();
$total_pelanggan = $data_pelanggan['total_pelanggan'];

// Tutup koneksi
$conn->close();

// Mendapatkan nama pengguna dari sesi
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna';

// Mendapatkan waktu saat ini
$current_time = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .welcome-message {
        background-color: #f4f4f4;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .welcome-message h2 {
        color: #333;
        margin-bottom: 10px;
    }

    .welcome-message p {
        color: #666;
        font-size: 1.1em;
    }

    .widget {
        background-color: #f4f4f4;
        padding: 20px;
        margin: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .widget h3 {
        margin-bottom: 10px;
        font-size: 1.2em;
        color: #333;
    }

    .widget p {
        font-size: 1.5em;
        color: #007BFF;
    }
</style>

<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="assets/icon.png" alt="Logo Point of Sale">
                <h2>Point of Sale</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="ph-house"></i> Home</a></li>
                <li><a href="dashboard.php"><i class="ph-house"></i> Dashboard</a></li>
                <li><a href="produk/produk.php"><i class="ph-bag"></i> Produk</a></li>
                <li><a href="penjualan.php"><i class="ph-chart-bar"></i> Penjualan</a></li>
                <li><a href="kontak/kontak_pelanggan.php"><i class="ph-phone"></i> Kontak Pelanggan</a></li>
                <li>
                    <a href="logout.php">
                        <i class="ph-sign-out"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Dashboard</h1>

            <!-- Ucapan selamat datang -->
            <div class="welcome-message">
                <h2>Selamat datang, <?php echo $user_name; ?>!</h2>
                <p>Waktu saat ini: <?php echo $current_time; ?></p>
            </div>

            <!-- Widget Produk -->
            <div class="widget">
                <h3>Total Produk</h3>
                <p><?php echo $total_produk; ?> Produk</p>
            </div>

            <!-- Widget Pelanggan -->
            <div class="widget">
                <h3>Total Pelanggan</h3>
                <p><?php echo $total_pelanggan; ?> Pelanggan</p>
            </div>

        </div>
    </div>
</body>

</html>