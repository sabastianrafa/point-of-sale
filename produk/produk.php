<?php
include '../koneksi.php';

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
                <li><a href="../index.php"><i class="ph-house"></i> Home</a></li>
                <li><a href="../dashboard.php"><i class="ph-house"></i> Dashboard</a></li>
                <li><a href="produk.php"><i class="ph-bag"></i> Produk</a></li>
                <li><a href="../penjualan.php"><i class="ph-chart-bar"></i> Penjualan</a></li>
                <li><a href="../kontak/kontak_pelanggan.php"><i class="ph-phone"></i> Kontak Pelanggan</a></li>
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
                <h1>Halaman Produk</h1>
                <p>Daftar produk yang tersedia di toko Anda.</p>
                <div>
                    <a id="tambahBtn" href="#">Tambah Produk</a>
                </div>

                <form style="display: none;" id="tambahProdukForm" method="POST" enctype="multipart/form-data"
                    action="process_produk.php">
                    <input type="text" name="produkNama" id="produkNama" placeholder="Nama Produk" required>
                    <input type="number" name="produkHarga" id="produkHarga" placeholder="Harga" required>
                    <input type="text" name="produkJenis" id="produkJenis" placeholder="Jenis Produk">
                    <div
                        style="display: flex; justify-content: center; align-items: center; flex-direction: column;    ">
                        <img id="previewImage" src="#" alt="Pratinjau Gambar"
                            style="display: none; width: 200px; margin-top: 20px;" />
                    </div>
                    <button style="background-color: gray" type="button" id="fileButton">Pilih Gambar</button>
                    <input type="file" name="produkGambar" id="produkGambar" accept="image/*" required
                        style="display: none;" />
                    <textarea name="produkDeskripsi" id="produkDeskripsi" placeholder="Deskripsi Produk" rows="4"
                        cols="50" required></textarea>
                    <button type="submit">Tambah Produk</button>
                </form>
            </div>

            <div class="produk-list" id="produkList">
                <?php
                $sql = "SELECT * FROM tb_produk";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <div class="produk-item">
                                <img src="../assets/uploads/' . $row['foto_produk'] . '" alt="' . htmlspecialchars($row['nama_produk']) . '">
                                <p>' . htmlspecialchars($row['nama_produk']) . '</p>
                                <p class="harga">Harga: Rp. ' . number_format($row['harga_produk'], 2, ',', '.') . '</p>
                                <button class="edit-btn" onclick="showEditPopup(\'' . $row['id_produk'] . '\', \'' . addslashes($row['nama_produk']) . '\')">Edit</button>
                                <button class="delete-btn" onclick="showPopup(\'' . addslashes($row['nama_produk']) . '\', \'' . $row['id_produk'] . '\')">Delete</button>
                            </div>';
                    }
                } else {
                    echo "No products found.";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Popup Konfirmasi -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <h3>Konfirmasi Penghapusan</h3>
            <p id="confirmUsername"></p>
            <button class="confirm-btn" id="confirmBtn">Konfirmasi</button>
            <button class="cancel-btn" id="cancelBtn">Batal</button>
        </div>
    </div>

    <!-- Popup Edit Produk -->
    <div class="popup" id="editPopup">
        <div class="popup-content">
            <h3>Konfirmasi Edit Produk</h3>
            <p id="confirmEditText"></p>
            <button class="confirm-btn" id="editConfirmBtn">Konfirmasi</button>
            <button class="cancel-btn" id="editCancelBtn">Batal</button>
        </div>
    </div>

    <script>
        document.getElementById("tambahBtn").addEventListener("click", function () {
            var form = document.getElementById("tambahProdukForm");
            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });

        document.getElementById('produkGambar').addEventListener('change', function (event) {
            const file = event.target.files[0]; // Mendapatkan file yang dipilih
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result; // Set sumber gambar ke hasil baca file
                    previewImage.style.display = 'block'; // Tampilkan gambar
                };
                reader.readAsDataURL(file); // Membaca file gambar sebagai URL
            } else {
                previewImage.style.display = 'none'; // Sembunyikan jika tidak ada file
            }
        });

        document.getElementById('fileButton').addEventListener('click', function () {
            document.getElementById('produkGambar').click();
        });


        // Function to show popup for delete confirmation
        function showPopup(productName, productId) {
            document.getElementById("confirmUsername").innerText = "Apakah Anda yakin ingin menghapus " + productName + "?";
            document.getElementById("popup").style.display = "flex";

            // Action when clicking the "Confirm" button
            document.getElementById("confirmBtn").onclick = function () {
                // Redirect to 'process_produk.php' to handle the deletion
                window.location.href = 'process_produk.php?delete_id=' + productId;
            };

            // Action when clicking the "Cancel" button
            document.getElementById("cancelBtn").onclick = function () {
                // Hide the popup when "Cancel" is clicked
                document.getElementById("popup").style.display = "none";
            };
        }


        // Function to show popup for edit confirmation
        function showEditPopup(productId, productName) {
            // Menampilkan nama produk dalam popup
            document.getElementById("confirmEditText").innerText = "Apakah Anda yakin ingin mengedit " + productName + "?";
            // Menampilkan popup
            document.getElementById("editPopup").style.display = "flex";

            // Mengupdate aksi tombol "Konfirmasi" untuk redirect ke halaman edit
            document.getElementById("editConfirmBtn").onclick = function () {
                // Redirect ke halaman edit produk dengan ID produk
                window.location.href = 'edit_produk.php?id_produk=' + productId;
            };

            // Menyembunyikan popup jika tombol "Batal" diklik
            document.getElementById("editCancelBtn").onclick = function () {
                document.getElementById("editPopup").style.display = "none";
            };
        }


    </script>
</body>

</html>