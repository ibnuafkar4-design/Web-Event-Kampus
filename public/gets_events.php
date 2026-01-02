<?php
include "../app/koneksi2.php";

$query = mysqli_query($koneksi, "SELECT * FROM admin");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>