<?php
// cetak_kontak_pdf.php
require_once('../dompdf/autoload.inc.php');
use Dompdf\Dompdf;

// Koneksi ke database
include('../koneksi.php');

// Query untuk mengambil data dari tabel tb_pelanggan
$query = $conn->query("SELECT * FROM tb_pelanggan");

// Periksa jika query gagal
if (!$query) {
    die("Query gagal: " . $conn->error);
}

// Inisialisasi Dompdf
$dompdf = new Dompdf();

// Membuat konten HTML untuk PDF
$html = '<center><h3>Daftar Kontak Pelanggan</h3></center><hr/><br>';
$html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                </tr>
            </thead>
            <tbody>';

// Iterasi data untuk mengisi tabel
while ($row = $query->fetch_assoc()) {
    $html .= '<tr>
                <td>' . htmlspecialchars($row['id_pelanggan']) . '</td>
                <td>' . htmlspecialchars($row['nama_pelanggan']) . '</td>
                <td>' . htmlspecialchars($row['email_pelanggan']) . '</td>
                <td>' . htmlspecialchars($row['nomor_telepon']) . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Tambahkan konten HTML ke Dompdf
$dompdf->loadHtml($html);

// Atur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Tampilkan atau unduh file PDF
if (isset($_GET['download']) && $_GET['download'] === 'true') {
    $dompdf->stream('kontak_pelanggan.pdf', ['Attachment' => true]);
} else {
    $dompdf->stream('kontak_pelanggan.pdf', ['Attachment' => false]);
}
?>