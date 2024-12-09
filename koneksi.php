<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan host database Anda, misalnya 'localhost'
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda (kosong jika tidak ada)
$dbname = "db_pointofsale"; // Nama database yang Anda gunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>