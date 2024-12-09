<?php
include '../koneksi.php';

// Handle delete product
if (isset($_GET['delete_id'])) {
    $id_produk = intval($_GET['delete_id']); // Konversi menjadi integer untuk keamanan

    // Query delete
    $stmt = $conn->prepare("DELETE FROM tb_produk WHERE id_produk = ?");
    $stmt->bind_param('i', $id_produk);

    if ($stmt->execute()) {
        header("Location: produk.php?message=Produk berhasil dihapus.");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Add new product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['produkGambar'])) {
    // Retrieve and sanitize form data
    $nama_produk = htmlspecialchars($_POST['produkNama']);
    $harga_produk = filter_var($_POST['produkHarga'], FILTER_VALIDATE_FLOAT);
    $jenis_produk = htmlspecialchars($_POST['produkJenis']);
    $deskripsi_produk = htmlspecialchars($_POST['produkDeskripsi']);

    // Validate required fields
    if (!$nama_produk || !$harga_produk || !$deskripsi_produk) {
        header("Location: produk.php?error=Harap isi semua bidang yang diperlukan.");
        exit;
    }

    // Validate file upload
    $foto_produk = $_FILES['produkGambar']['name'];
    $foto_temp = $_FILES['produkGambar']['tmp_name'];
    $upload_dir = '../assets/uploads/';

    // Check if the upload directory exists, if not create it
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Check file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $file_type = mime_content_type($foto_temp);

    if (!in_array($file_type, $allowed_types)) {
        header("Location: produk.php?error=Hanya gambar dengan format JPG, PNG, atau GIF yang diperbolehkan.");
        exit;
    }

    // Check file extension
    $file_extension = strtolower(pathinfo($foto_produk, PATHINFO_EXTENSION));
    if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        header("Location: produk.php?error=Ekstensi file tidak valid.");
        exit;
    }

    // Generate a unique file name
    $unique_file_name = uniqid('img_', true) . '.' . $file_extension;
    $target_file = $upload_dir . $unique_file_name;

    // Move the file to the upload directory
    if (move_uploaded_file($foto_temp, $target_file)) {
        // Prepare SQL query with prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO tb_produk (nama_produk, jenis_produk, foto_produk, harga_produk, deskripsi_produk) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssis', $nama_produk, $jenis_produk, $unique_file_name, $harga_produk, $deskripsi_produk);

        if ($stmt->execute()) {
            header("Location: produk.php?message=Data berhasil ditambahkan.");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        header("Location: produk.php?error=Gagal mengunggah gambar. Silakan coba lagi.");
        exit;
    }
} else {
    header("Location: produk.php?error=Metode request tidak valid.");
    exit;
}
?>