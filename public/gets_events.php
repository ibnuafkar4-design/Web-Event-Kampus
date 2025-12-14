<?php
include "../app/configuser.php";

$query = mysqli_query($koneksi, "SELECT * FROM admin");

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}

echo json_encode($data);
