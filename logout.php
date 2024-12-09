<?php
session_start();

// Hapus sesi pengguna
session_unset();
session_destroy();

// Hapus status login di localStorage (di sisi klien)
echo "<script>
        localStorage.removeItem('logged_in');
        window.location.href = 'index.php'; // Redirect ke halaman utama
      </script>";
?>