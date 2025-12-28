<?php
include __DIR__ . "/../app/koneksi2.php";



//ambil bulan dan tahun dari URL
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

//batasan bulan dari 1-12
if ($bulan < 1) {
    $bulan = 12;
    $tahun--;
}
if ($bulan > 12) {
    $bulan = 1;
    $tahun++;
}

//ambil data dari database
$data_event = [];
$query_event = mysqli_query(
    $koneksi,"SELECT * FROM admin WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'"
);

while ($baris_event = mysqli_fetch_assoc($query_event)) {
    $tanggal_event = date('j', strtotime($baris_event['tanggal']));
    $data_event[$tanggal_event][] = $baris_event;
}

//data kalender 
$hari_pertama = date('w', strtotime("$tahun-$bulan-01"));
$jumlah_hari  = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kalender Event Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    a {
        text-shadow: 0 0 10px #ff3cac;
    }

    .navbar {
        background-color: #0b0614;
        text-align: left;
    }

    .navbar-brand {
        color: #a855f7;
        font-weight: bold;
    }

    h3 {
        color: #a855f7;
    }

    body {
        background: #0b0614;
        font-family: Arial, sans-serif;
    }

    td {
        height: 130px;
        vertical-align: top;
    }

    strong {
        color: #a855f7;
    }

    .event-kampus {
        background: #14204b;
        color: #fff;
        font-size: 12px;
        max-height: 50px;

    }
    </style>
</head>


<nav class="navbar navbar-expand navbar-dark sticky-top px-3">


    <div class="d-flex align-items-center">
        <img src="logopolibatam.jpg" alt="logo" width="45" class="me-3">

        <a class="navbar-brand me-3" href="landingpage.php">Home</a>
        <a class="navbar-brand me-3" href="dashboardusers.php">Events</a>
        <a class="navbar-brand me-3" href="#contact">Kontak</a>
        <a class="navbar-brand me-3" href="kalender.php">Kalender</a>
    </div>
    <form method="GET" class="d-flex ms-auto me-3" style="width: 320px;">
        <input class="form-control me-2" type="text" name="search" placeholder="event / YYYY-MM-DD"
            value="<?= htmlspecialchars($keyword) ?>">
        <button class="btn btn-outline-light" style="width:80px;">Search</button>
    </form>

</nav>

<div class="container mt-4">


    <h3 class="text-center">Kalender Event Kampus</h3>

    <!-- Navigasi bulan -->
    <div class="d-flex justify-content-between mb-3">
        <a class="btn btn-sm btn-secondary" href="?bulan=<?= $bulan - 1 ?>&tahun=<?= $tahun ?>">
            ‹ Sebelumnya</a>

        <strong>
            <?= date('F Y', strtotime("$tahun-$bulan-01")) ?>
        </strong>

        <a class="btn btn-sm btn-secondary" href="?bulan=<?= $bulan + 1 ?>&tahun=<?= $tahun ?>">
            Berikutnya ›</a>
    </div>

    <table class="table table-bordered text-center">
        <tr>
            <th>Minggu</th>
            <th>Senin</th>
            <th>Selasa</th>
            <th>Rabu</th>
            <th>Kamis</th>
            <th>Jumat</th>
            <th>Sabtu</th>
        </tr>

        <tr>
            <?php
// space sebelum hari pertama
for ($i = 0; $i < $hari_pertama; $i++) {
    echo "<td></td>";
}

// loop tanggal
for ($tanggal = 1; $tanggal <= $jumlah_hari; $tanggal++) {

    echo "<td align=\"left\"><b>$tanggal</b>";

    if (isset($data_event[$tanggal])) {
        foreach ($data_event[$tanggal] as $event) {
            echo "
            <div class='event-kampus'>{$event['judul']}<br>
                <small>" . date('H.i', strtotime($event['waktu'])) . " WIB | {$event['tempat']}</small>
            </div>";
        }
    }

    echo "</td>";

    //tiap 1 minggu pindah baris
    if (($tanggal + $hari_pertama) % 7 == 0) {
        echo "</tr><tr>";
    }
?>
        </tr>
    </table>

</div>
</body>

</html>