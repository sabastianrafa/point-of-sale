<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <div class="container">
        <div class="register-container">
            <h2>Register</h2>
            <form id="registerForm" action="process_register.php" method="POST">
                <input type="text" name="username" id="username" placeholder="Username" required />
                <input type="email" name="email" id="email" placeholder="Email" required />
                <label style="font-size: small" for="bdaydate">Tanggal Lahir</label>
                <input type="date" name="bdaydate" id="bdaydate" required />
                <input type="text" name="nama_usaha" id="nama_usaha" placeholder="Nama Usaha" required />
                <input type="password" name="password" id="password" placeholder="Password" required />
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Konfirmasi Password"
                    required />
                <button type="submit">Register</button>
            </form>
            <p style="font-size: small">
                Sudah Memiliki Akun? <a style="text-decoration: none" href="login.php">Login</a>
            </p>
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
        // Inisialisasi elemen
        const form = document.getElementById("registerForm");
        const popup = document.getElementById("popup");
        const confirmBtn = document.getElementById("confirmBtn");
        const cancelBtn = document.getElementById("cancelBtn");

        const usernameInput = document.getElementById("username");
        const emailInput = document.getElementById("email");
        const bdayInput = document.getElementById("bdaydate");
        const usahaInput = document.getElementById("nama_usaha");
        const passwordInput = document.getElementById("password");
        const confirmPasswordInput = document.getElementById("confirmPassword");

        const confirmUsername = document.getElementById("confirmUsername");
        const confirmEmail = document.getElementById("confirmEmail");
        const confirmBday = document.getElementById("confirmBday");
        const confirmNamaUsaha = document.getElementById("confirmNamaUsaha");

        usernameInput.addEventListener("blur", () => {
            checkAvailability("username", usernameInput.value);
        });

        emailInput.addEventListener("blur", () => {
            checkAvailability("email", emailInput.value);
        });

        function checkAvailability(field, value) {
            if (!value) return;

            fetch(`check_availability.php?field=${field}&value=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        alert(`${field} sudah digunakan. Silakan gunakan yang lain.`);

                        // Kosongkan field setelah alert
                        if (field === "username") {
                            document.getElementById("username").value = "";
                        } else if (field === "email") {
                            document.getElementById("email").value = "";
                        }
                    }
                })
                .catch(error => console.error("Error:", error));
        }


        // Event saat form di-submit
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Mencegah form langsung terkirim

            // Validasi data
            if (!usernameInput.value || !emailInput.value || !bdayInput.value || !usahaInput.value) {
                alert("Semua data harus diisi!");
                return;
            }

            // Validasi usia minimal 18 tahun
            const birthDate = new Date(bdayInput.value);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            const dayDifference = today.getDate() - birthDate.getDate();

            // Jika usia kurang dari 18 tahun
            if (age < 18 || (age === 18 && (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)))) {
                alert("Maaf, usia Anda tidak memenuhi persyaratan minimum untuk mendaftar. Silakan periksa kembali data yang Anda masukkan.");
                return;
            }

            if (passwordInput.value !== confirmPasswordInput.value) {
                alert("Password dan konfirmasi password tidak cocok!");
                return;
            }

            // Menampilkan data di popup
            confirmUsername.innerText = `Username: ${usernameInput.value}`;
            confirmEmail.innerText = `Email: ${emailInput.value}`;
            confirmBday.innerText = `Tanggal Lahir: ${bdayInput.value}`;
            confirmNamaUsaha.innerText = `Nama Usaha: ${usahaInput.value}`;

            // Tampilkan popup
            popup.style.display = "flex";

            event.preventDefault(); // Mencegah form langsung terkirim

            // Validasi data
            if (!usernameInput.value || !emailInput.value || !bdayInput.value || !usahaInput.value) {
                alert("Semua data harus diisi!");
                return;
            }

            if (passwordInput.value !== confirmPasswordInput.value) {
                alert("Password dan konfirmasi password tidak cocok!");
                return;
            }

            // Menampilkan data di popup
            confirmUsername.innerText = `Username: ${usernameInput.value}`;
            confirmEmail.innerText = `Email: ${emailInput.value}`;
            confirmBday.innerText = `Tanggal Lahir: ${bdayInput.value}`;
            confirmNamaUsaha.innerText = `Nama Usaha: ${usahaInput.value}`;

            // Tampilkan popup
            popup.style.display = "flex";
        });

        // Event tombol Konfirmasi
        confirmBtn.addEventListener("click", function () {
            popup.style.display = "none";
            form.submit(); // Submit form setelah konfirmasi
        });

        // Event tombol Batal
        cancelBtn.addEventListener("click", function () {
            popup.style.display = "none";
        });
    </script>

</body>

</html>