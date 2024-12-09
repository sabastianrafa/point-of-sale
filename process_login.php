<?php
session_start();
include 'koneksi.php'; // Menghubungkan ke database

// Periksa jika pengguna sudah login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=" . urlencode("Username dan password wajib diisi."));
        exit();
    }

    // Lindungi dari SQL Injection
    $username = $conn->real_escape_string($username);

    // Query untuk mencari username di database
    $sql = "SELECT * FROM tb_pengguna WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data pengguna
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil, set sesi
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id_user']; // Menyimpan ID pengguna
            $_SESSION['username'] = $user['username']; // Simpan username untuk referensi

            // Redirect ke halaman utama atau admin
            echo "<script>
                    localStorage.setItem('logged_in', 'true');
                    window.location.href = 'index.php'; // Redirect ke halaman utama
                  </script>";
            exit();
        } else {
            // Password salah
            header("Location: login.php?error=" . urlencode("Password salah."));
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("Location: login.php?error=" . urlencode("Username tidak ditemukan."));
        exit();
    }
}

// Tutup koneksi database
$conn->close();
?>