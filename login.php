<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            max-width: 900px;
            padding: 20px;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 8px 0px 0px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-container input {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #422d6a;
            color: white;
            border: none;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #422d6ada;
        }

        .login-container a {
            font-size: small;
            text-decoration: none;
        }

        .info-container {
            background-color: #422d6a;
            padding: 40px;
            text-align: center;
            border-radius: 0px 8px 8px 0px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .info-container h1 {
            color: #ffffff;
        }

        .info-container p {
            color: #ffffff;
            line-height: 1.5;
        }

        .info-container img {
            width: 80%;
            height: auto;
            pointer-events: none;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
            z-index: 1000;
            display: none;
        }

        .popup button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .popup .confirm {
            background-color: #28a745;
            color: white;
        }

        .popup .cancel {
            background-color: #dc3545;
            color: white;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        @media (max-width: 800px) {
            .container {
                display: grid;
            }

            .login-container {
                border-radius: 8px 8px 0px 0px;
            }

            .login-container input {
                width: 96%;
            }

            .info-container {
                border-radius: 0px 0px 8px 8px;
            }
        }

        @media (max-width: 260px) {
            .info-container {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Login Container -->
        <div class="login-container">
            <h2>Login</h2>
            <form id="loginForm">
                <input type="text" name="username" id="username" placeholder="Username" required />
                <input type="password" name="password" id="password" placeholder="Password" required />
                <a href="#">Lupa Sandi?</a>
                <button type="submit" id="loginBtn">Login</button>
            </form>
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

    <script>
        // Fungsi untuk menyimpan cookie
        function setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); // Waktu kedaluwarsa
            const expires = "expires=" + date.toUTCString();
            document.cookie = `${name}=${value};${expires};path=/`;
        }

        // Fungsi untuk membaca cookie
        function getCookie(name) {
            const cookies = document.cookie.split("; ");
            for (let cookie of cookies) {
                const [key, value] = cookie.split("=");
                if (key === name) {
                    return decodeURIComponent(value);
                }
            }
            return null;
        }

        // Elemen HTML
        const loginForm = document.getElementById("loginForm");
        const usernameInput = document.getElementById("username");

        // Saat halaman dimuat, isi otomatis username jika ada di cookies
        document.addEventListener("DOMContentLoaded", function () {
            const savedUsername = getCookie("username");
            if (savedUsername) {
                usernameInput.value = savedUsername; // Isi input username
            }
        });

        // Event listener untuk form login
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Mencegah submit default

            const username = usernameInput.value.trim();
            const password = document.getElementById("password").value.trim();

            if (!username || !password) {
                alert("Username dan password harus diisi!");
            } else {
                // Simpan username ke cookies (berlaku selama 7 hari)
                setCookie("username", username, 7);

                // Redirect ke halaman admin
                console.log("Login berhasil. Username disimpan di cookies.");
                window.location.href = "admin.php";
            }
        });
    </script>
</body>

</html>