<?php
include 'koneksi.php'; // File konfigurasi database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari formulir
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $bday = $conn->real_escape_string($_POST['bdaydate']);
    $company = $conn->real_escape_string($_POST['nama_usaha']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);

    // Validasi input
    if (empty($username) || empty($email) || empty($bday) || empty($company) || empty($password) || empty($confirmPassword)) {
        header("Location: register.php?error=Semua field wajib diisi");
        exit;
    }

    if ($password !== $confirmPassword) {
        header("Location: register.php?error=Password tidak cocok");
        exit;
    }

    // Periksa apakah username atau email sudah digunakan
    $checkQuery = "SELECT * FROM tb_pengguna WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        header("Location: register.php?error=Username atau email sudah digunakan");
        exit;
    }

    // Enkripsi password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data ke database
    $sql = "INSERT INTO tb_pengguna (username, email, date_bday, company, password) 
            VALUES ('$username', '$email', '$bday', '$company', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        // Hapus cookies
        setcookie("username", "", time() - 3600, "/");
        setcookie("email", "", time() - 3600, "/");
        setcookie("bdaydate", "", time() - 3600, "/");
        setcookie("nama_usaha", "", time() - 3600, "/");

        header("Location: login.php?message=register_berhasil");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>