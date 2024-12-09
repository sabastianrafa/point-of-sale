<?php
include '../koneksi.php';

// Validasi 'id_produk'
if (!isset($_GET['id_produk']) || !is_numeric($_GET['id_produk'])) {
    echo "ID Produk tidak valid.";
    exit;
}
$id_produk = (int) $_GET['id_produk']; // Pastikan casting ke integer

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input pengguna
    $nama_produk = $conn->real_escape_string($_POST['produkNama']);
    $harga_produk = $conn->real_escape_string($_POST['produkHarga']);
    $jenis_produk = $conn->real_escape_string($_POST['produkJenis']);
    $deskripsi_produk = $conn->real_escape_string($_POST['produkDeskripsi']);

    // Validasi dan proses file upload
    if (isset($_FILES['produkGambar']) && $_FILES['produkGambar']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif']; // Format gambar yang diperbolehkan
        $file_type = mime_content_type($_FILES['produkGambar']['tmp_name']);

        if (in_array($file_type, $allowed_types)) {
            $foto_produk = $_FILES['produkGambar']['name'];
            $foto_temp = $_FILES['produkGambar']['tmp_name'];
            $upload_dir = '../assets/uploads/';

            if (move_uploaded_file($foto_temp, $upload_dir . $foto_produk)) {
                // Update query dengan gambar
                $sql = "UPDATE tb_produk 
                        SET nama_produk = '$nama_produk', 
                            harga_produk = '$harga_produk', 
                            jenis_produk = '$jenis_produk', 
                            foto_produk = '$foto_produk', 
                            deskripsi_produk = '$deskripsi_produk' 
                        WHERE id_produk = $id_produk";
            } else {
                echo "Gagal mengunggah gambar.";
                exit;
            }
        } else {
            echo "Format file tidak valid. Hanya JPG, PNG, dan GIF yang diperbolehkan.";
            exit;
        }
    } else {
        // Update query tanpa mengganti gambar
        $sql = "UPDATE tb_produk 
                SET nama_produk = '$nama_produk', 
                    harga_produk = '$harga_produk', 
                    jenis_produk = '$jenis_produk', 
                    deskripsi_produk = '$deskripsi_produk' 
                WHERE id_produk = $id_produk";
    }

    // Eksekusi query
    if ($conn->query($sql) === TRUE) {
        header("Location: produk.php?message=Produk berhasil diperbarui");
        exit;
    } else {
        echo "Error: " . $conn->error;
        exit;
    }
}

$conn->close();
?>