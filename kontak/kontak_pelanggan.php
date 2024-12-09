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

include '../koneksi.php';

// Ambil data pelanggan
$sql = "SELECT * FROM tb_pelanggan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<style>
    /* Table Styling */
    .contact-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-table th,
    .contact-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
    }

    .contact-table th {
        background-color: #422d6a;
        color: white;
        text-transform: uppercase;
    }

    .contact-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .contact-table tr:hover {
        background-color: #f1f1f1;
    }

    .contact-table .action-links a {
        color: #422d6a;
        text-decoration: none;
        padding: 5px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .contact-table .action-links a:hover {
        background-color: #422d6a;
        color: whitesmoke;
    }

    /* Add Contact Button Styling */
    .add-contact-button {
        display: inline-block;
        padding: 12px 24px;
        background-color: #422d6a;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .add-contact-button:hover {
        background-color: #574b7b;
    }

    .print-button {
        margin-left: 20px;
        display: inline-block;
        padding: 12px 24px;
        background-color: #422d6a;
        color: white;
        border: none;
        cursor: pointer;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .print-button:hover {
        background-color: #574b7b;
    }

    /* Responsif untuk perangkat mobile */
    @media (max-width: 768px) {

        .contact-table th,
        .contact-table td {
            font-size: 12px;
        }

        .add-contact-button {
            padding: 10px 18px;
            font-size: 14px;
        }

        .print-button {
            padding: 10px 18px;
            font-size: 14px;
        }
    }
</style>

<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/icon.png" alt="Logo Point of Sale">
                <h2>Point of Sale</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="../index.php"><i class="ph-house"></i> Home</a></li>
                <li><a href="../dashboard.php"><i class="ph-house"></i> Dashboard</a></li>
                <li><a href="../produk/produk.php"><i class="ph-bag"></i> Produk</a></li>
                <li><a href="../penjualan.php"><i class="ph-chart-bar"></i> Penjualan</a></li>
                <li><a href="kontak_pelanggan.php"><i class="ph-phone"></i> Kontak Pelanggan</a></li>
                <li>
                    <a href="logout.php">
                        <i class="ph-sign-out"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Daftar Kontak Pelanggan</h1>

            <!-- Add Contact Button -->
            <a href="edit_kontak.php" class="add-contact-button">Tambah Kontak Baru</a>

            <a href="cetak_kontak_pdf.php?download=false" class="print-button">Cetak PDF</a>

            <!-- Contact Table -->
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($row['email_pelanggan']) ?></td>
                            <td><?= htmlspecialchars($row['nomor_telepon']) ?></td>
                            <td class="action-links">
                                <a href="edit_kontak.php?id=<?= htmlspecialchars($row['id_pelanggan']) ?>">Edit</a> |
                                <a href="proses_kontak.php?action=delete&id=<?= htmlspecialchars($row['id_pelanggan']) ?>"
                                    onclick="return confirm('Hapus kontak ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>