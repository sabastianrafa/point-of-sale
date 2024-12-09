<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$name = '';
$email = '';
$phone = '';

if ($id) {
    $sql = "SELECT * FROM tb_pelanggan WHERE id_pelanggan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if ($data) {
        $nama_pelanggan = $data['nama_pelanggan'];
        $email_pelanggan = $data['email_pelanggan'];
        $nomor_telepon = $data['nomor_telepon'];
    }
}
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
    /* Styling untuk keseluruhan halaman */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    h1 {
        text-align: center;
        color: #422d6a;
        margin-bottom: 20px;
    }

    /* Styling form */
    .form-container {
        background-color: #ffffff;
        padding: 20px 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    label {
        display: block;
        font-size: 14px;
        color: #333333;
        margin-bottom: 6px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="hidden"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="text"]:focus,
    input[type="email"]:focus {
        border-color: #422d6a;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        margin-bottom: 30px;
        font-size: 16px;
        background-color: #422d6a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #574b7b;
    }

    /* Link kembali */
    .back-link {
        display: block;
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
        text-decoration: none;
        color: #422d6a;
    }

    .back-link:hover {
        color: #574b7b;
    }

    .keluar a {
        border-radius: 4px;
        background-color: #422d6a;
        color: whitesmoke;
        padding: 10px 100px;
        text-decoration: none;
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
            <!-- Contact Table -->
            <table class="contact-table">
                <h1><?= $id ? 'Edit' : 'Tambah' ?> Kontak</h1>
                <form action="proses_edit_kontak_pelanggan.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <label>Nama:</label><br>
                    <input type="text" name="name" value="<?= $name ?>" required><br>
                    <label>Email:</label><br>
                    <input type="email" name="email" value="<?= $email ?>" required><br>
                    <label>Telepon:</label><br>
                    <input type="text" name="phone" value="<?= $phone ?>"><br><br>
                    <button type="submit"><?= $id ? 'Update' : 'Simpan' ?></button>
                </form>
                <div class="keluar">
                    <a href="kontak_pelanggan.php">Kembali</a>
                </div>
            </table>
        </div>
    </div>
</body>

</html>