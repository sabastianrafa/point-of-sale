<?php
include '../koneksi.php';

// Check if the 'id_produk' parameter is provided and is a valid integer
if (isset($_GET['id_produk']) && is_numeric($_GET['id_produk'])) {
    $id_produk = (int) $_GET['id_produk']; // Casting to int to ensure it's a valid number

    // Fetch the product data safely
    $sql = "SELECT * FROM tb_produk WHERE id_produk = $id_produk";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_produk = $row['nama_produk'];
        $harga_produk = $row['harga_produk'];
        $jenis_produk = $row['jenis_produk'];
        $foto_produk = $row['foto_produk'];
        $deskripsi_produk = $row['deskripsi_produk'];
    } else {
        echo "Produk tidak ditemukan!";
        exit;
    }
} else {
    echo "ID produk tidak valid!";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk</title>
    <link rel="icon" href="../assets/iconbg.png" />
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/produk.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/icon.png" alt="Logo Point of Sale">
                <h2>Point of Sale</h2>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="ph-house"></i> Home</a></li>
                <li><a href="produk/produk.php"><i class="ph-bag"></i> Produk</a></li>
                <li><a href="penjualan.php"><i class="ph-chart-bar"></i> Penjualan</a></li>
                <li><a href="kontak.php"><i class="ph-phone"></i> Kontak Pelanggan</a></li>
                <li>
                    <a href="logout.php">
                        <i class="ph-sign-out"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-container">
                <h1>Edit Produk</h1>
                <form method="POST" enctype="multipart/form-data"
                    action="edit_process_produk.php?id_produk=<?php echo $id_produk; ?>">
                    <!-- Hidden Input to Include id_produk -->
                    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">

                    <!-- Produk Nama -->
                    <input type="text" name="produkNama" id="produkNama" value="<?php echo $nama_produk; ?>" required>

                    <!-- Produk Harga -->
                    <input type="number" name="produkHarga" id="produkHarga" value="<?php echo $harga_produk; ?>"
                        required>

                    <!-- Produk Jenis -->
                    <input type="text" name="produkJenis" id="produkJenis" value="<?php echo $jenis_produk; ?>"
                        placeholder="Jenis Produk" required>

                    <!-- Produk Gambar -->
                    <div
                        style="display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 20px;">
                        <!-- Pratinjau gambar lama -->
                        <img src="../assets/uploads/<?php echo $foto_produk; ?>" id="oldImage" alt="Gambar Produk Lama"
                            width="200" height="auto">

                        <!-- Pratinjau gambar baru -->
                        <img id="previewImage" src="#" alt="Pratinjau Gambar Baru"
                            style="display: none; width: 200px;" />

                        <!-- Tombol Ganti Gambar -->
                        <button style="background-color: gray" type="button" id="changeImageBtn"
                            class="cta-button">Ganti Gambar</button>

                        <!-- Input File -->
                        <input type="file" name="produkGambar" id="produkGambar" accept="image/*"
                            style="display: none;" />
                    </div>

                    <!-- Produk Deskripsi -->
                    <textarea name="produkDeskripsi" id="produkDeskripsi" rows="4" cols="50"
                        required><?php echo $deskripsi_produk; ?></textarea>

                    <!-- Tombol Submit -->
                    <button type="submit" class="cta-button">Update Produk</button>
                </form>

            </div>
        </div>

        <script>
            const changeImageBtn = document.getElementById('changeImageBtn');
            const fileInput = document.getElementById('produkGambar');
            const previewImage = document.getElementById('previewImage');
            const oldImage = document.getElementById('oldImage');

            // Saat tombol "Ganti Gambar" diklik
            changeImageBtn.addEventListener('click', function () {
                fileInput.click(); // Trigger input file
            });

            // Saat gambar baru dipilih
            fileInput.addEventListener('change', function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Tampilkan pratinjau gambar baru
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';

                        // Sembunyikan gambar lama
                        oldImage.style.display = 'none';
                    };

                    reader.readAsDataURL(file);
                }
            });
        </script>
</body>

</html>