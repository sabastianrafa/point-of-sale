<?php
include '../koneksi.php';

if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tb_pelanggan WHERE id_pelanggan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: kontak_pelanggan.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>