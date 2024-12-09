<!-- program untuk mengecek aku yang sudah dipakai -->

<?php
include 'koneksi.php';

$field = isset($_GET['field']) ? $_GET['field'] : '';
$value = isset($_GET['value']) ? $_GET['value'] : '';

if ($field && $value) {
    $query = "SELECT * FROM tb_pengguna WHERE $field = '$value'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
} else {
    echo json_encode(['exists' => false]);
}

$conn->close();
?>