<?php
// Menampilkan pesan error jika ada
if (isset($_GET['error'])) {
    $error_message = htmlspecialchars($_GET['error']);
} else {
    $error_message = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <!-- Login Container -->
        <div class="login-container">
            <h2>Login</h2>
            <form method="POST" action="process_login.php"> <!-- Form mengarah ke process_login.php -->
                <input type="text" name="username" id="username" placeholder="Username" required />
                <input type="password" name="password" id="password" placeholder="Password" required />
                <button type="submit">Login</button>
            </form>

            <!-- Display Error if any -->
            <?php if ($error_message): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <p style="font-size: small">
                Belum Memiliki Akun? <a href="register.php">Register</a>
            </p>
        </div>

        <!-- Info Box -->
        <div class="info-container">
            <div class="info">
                <h1>Welcome to Point of Sale</h1>
                <p>
                    Platform untuk manajemen hubungan pelanggan (CRM),
                    pemasaran, penjualan, dan layanan pelanggan.
                </p>
                <img src="assets/loginimg.png" alt="Logo Point of Sale" />
            </div>
        </div>
    </div>
</body>

</html>