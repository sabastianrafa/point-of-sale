<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <style>
        /* CSS tetap sama */
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

        .register-container {
            background: white;
            padding: 40px;
            border-radius: 8px 0px 0px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .register-container input {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #422d6a;
            color: white;
            border: none;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .register-container button:hover {
            background-color: #422d6ada;
        }

        .register-container label {
            display: block;
            margin-bottom: 5px;
            opacity: 0.8;
            font-size: 14px;
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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .popup-content h3 {
            margin-bottom: 20px;
        }

        .popup-content p {
            margin: 10px 0;
        }

        .popup-content button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .confirm-btn {
            background-color: #422d6a;
            color: white;
        }

        .cancel-btn {
            background-color: #ccc;
        }

        @media (max-width: 800px) {
            .container {
                display: grid;
            }

            .register-container {
                border-radius: 8px 8px 0px 0px;
            }

            .register-container input {
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
        <div class="register-container">
            <h2>Register</h2>
            <form id="registerForm">
                <input type="text" name="username" id="username" placeholder="Username" required />
                <input type="email" name="email" id="email" placeholder="Email" required />
                <label for="bdaydate">Tanggal Lahir</label>
                <input type="date" name="bdaydate" id="bdaydate" required />
                <input type="text" name="nama_usaha" id="nama_usaha" placeholder="Nama Usaha" required />
                <input type="password" name="password" id="password" placeholder="Password" required />
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Konfirmasi Password"
                    required />
                <button type="button" id="registerBtn">Register</button>
            </form>
        </div>

        <div class="info-container">
            <h1>Welcome to Point of Sale</h1>
            <p>
                Platform untuk manajemen hubungan pelanggan (CRM),
                pemasaran, penjualan, dan layanan pelanggan.
            </p>
            <img src="assets/iconbg.png" alt="Logo Point of Sale" />
        </div>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <h3>Konfirmasi Data</h3>
            <p id="confirmUsername"></p>
            <p id="confirmEmail"></p>
            <p id="confirmBday"></p>
            <p id="confirmNamaUsaha"></p>
            <button class="confirm-btn" id="confirmBtn">Konfirmasi</button>
            <button class="cancel-btn" id="cancelBtn">Batal</button>
        </div>
    </div>

    <script>
        const button = document.getElementById("registerBtn");
        const popup = document.getElementById("popup");
        const confirmBtn = document.getElementById("confirmBtn");
        const cancelBtn = document.getElementById("cancelBtn");

        const usernameInput = document.getElementById("username");
        const emailInput = document.getElementById("email");
        const bdayInput = document.getElementById("bdaydate");
        const usahaInput = document.getElementById("nama_usaha");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirmPassword");

        button.addEventListener("click", function () {
            const username = usernameInput.value.trim();
            const email = emailInput.value.trim();
            const bday = bdayInput.value.trim();
            const usaha = usahaInput.value.trim();

            if (!username || !email || !bday || !usaha) {
                alert("Semua data harus diisi!");
                return;
            }

            if (password.value !== confirmPassword.value) {
                alert("Password dan konfirmasi password tidak cocok!");
                return;
            }

            document.getElementById("confirmUsername").innerText = `Username: ${username}`;
            document.getElementById("confirmEmail").innerText = `Email: ${email}`;
            document.getElementById("confirmBday").innerText = `Tanggal Lahir: ${bday}`;
            document.getElementById("confirmNamaUsaha").innerText = `Nama Usaha: ${usaha}`;
            popup.style.display = "flex";
        });

        confirmBtn.addEventListener("click", function () {
            popup.style.display = "none";
            document.getElementById("registerForm").submit();
            window.location.href = "login.php";
        });

        cancelBtn.addEventListener("click", function () {
            popup.style.display = "none";
        });
    </script>
</body>

</html>