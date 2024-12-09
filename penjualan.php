<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Penjualan</title>
    <link rel="icon" href="assets/iconbg.png" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="logo">
                    <img src="assets/icon.png" alt="icon" />
                </div>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="kontak.html">Kontak</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="penjualan">
                <h1>Data Penjualan</h1>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Produk A</td>
                            <td>10</td>
                            <td>Rp 1.000.000</td>
                            <td>01/12/2024</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Produk B</td>
                            <td>5</td>
                            <td>Rp 500.000</td>
                            <td>03/12/2024</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>

        <footer>
            <p>&copy; 2024 Point of Sale. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>