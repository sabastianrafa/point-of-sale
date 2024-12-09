<?php
include '../koneksi.php';

// Ambil data dari formulir
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Validasi koneksi database
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Proses update atau insert
if ($id) {
    // Update kontak
    $sql = "UPDATE tb_pelanggan SET nama_pelanggan = ?, email_pelanggan = ?, nomor_telepon = ? WHERE id_pelanggan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $phone, $id);
} else {
    // Tambah kontak baru
    $sql = "INSERT INTO tb_pelanggan (nama_pelanggan, email_pelanggan, nomor_telepon) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $phone);
}

// Eksekusi query
if ($stmt->execute()) {
    header("Location: kontak_pelanggan.php"); // Redirect ke halaman daftar kontak pelanggan
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>