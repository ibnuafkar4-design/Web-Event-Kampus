<?php
include 'koneksi.php';

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
    th {
        width: 200px;
    }

    a {
        text-shadow: 0 0 10px #ff3cac;
    }

    .navbar {
        background-color: #101a39;
        text-align: left;
    }

    .navbar-brand {
        color: #ff3cac;
        font-weight: bold;
    }

    h3 {
        color: #ff3cac;
        text-shadow: 0 0 10px #ff3cac;
    }

    body {
        background: #14204b;
        font-family: Arial, sans-serif;
    }

    td {
        height: 130px;
        vertical-align: top;
    }

    strong {
        color: #ff3cac;
        text-shadow: 0 0 10px #ff3cac;
    }

    .event-kampus {
        background: #14204b;
        color: #ffffffff;
        font-size: 12px;
        max-height: auto;
        padding: 6px 8px;
        margin-top: 5px;
        border-radius: 10px;
    }

    footer {
        background-color: #08132a;
        color: #ccc;
        text-align: center;
        padding: 15px;
        margin-top: 40px;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand sticky-top">
        <div class="container-fluid">
            <div class="d-flex me-auto" id="searchContainer" role="search">
                <input class="form-control me-2" type="text" name="searchBar" id="searchBar"
                    placeholder="Search for an event" aria-label="Search">
                <button class="btn btn-outline-light" type="button" id="btnSearch">Search</button>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand" href="kalender.php"> Kalender</a>
            <a class="navbar-brand" href="landingpage.php"> Home</a>
            <a class="navbar-brand" href="dashboardusers.php"> Events</a>
            <a class="navbar-brand" href="#contact"> Contact</a>
            <img src="logopolibatam.jpg" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">

        </div>
    </nav>
    <div class="container mt-4">


        <h3 class="text-center">Kalender Event Kampus</h3>

        <!-- Navigasi bulan -->
        <div class="d-flex justify-content-between mb-3">
            <a class="btn btn-sm btn-secondary" href="?bulan=<?= $bulan - 1 ?>&tahun=<?= $tahun ?>">‹ Sebelumnya</a>

            <strong>
                <?= date('M Y', strtotime("$tahun-$bulan")) ?>
            </strong>

            <a class="btn btn-sm btn-secondary" href="?bulan=<?= $bulan + 1 ?>&tahun=<?= $tahun ?>">Berikutnya ›</a>
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
// baris kosong sebelum hari pertama 
for ($spasi = 0; $spasi < $hari_pertama; $spasi++) {
    echo "<td></td>";
}

// loop tanggal
for ($tanggal = 1; $tanggal <= $jumlah_hari; $tanggal++) {

    echo "<td><b>$tanggal</b>";

    if (isset($data_event[$tanggal])) {
        foreach ($data_event[$tanggal] as $event) {
            echo "
            <div class='event-kampus'>{$event['judul']}<br>
                <small>" . date('H.i', strtotime($event['waktu'])) . " WIB | {$event['tempat']}</small>
            </div>";

        }
    }

    //tiap 1 minggu pindah baris
    if (($tanggal + $hari_pertama) % 7 == 0) {
        echo "</tr><tr>";
    }
    
}

// TAMBAHAN AGAR FULL
$total_sel = $hari_pertama + $jumlah_hari;
$sisa_sel = $total_sel % 7;

if ($sisa_sel != 0) {
    $sel_kosong = 7 - $sisa_sel;
    for ($sel = 0; $sel < $sel_kosong; $sel++) {
        echo "<td></td>";
    }
}

    //tiap 1 minggu pindah baris
    if (($tanggal + $hari_pertama) % 7 == 0) {
        echo "</tr><tr>";
    }
?>
            </tr>
        </table>

    </div>
    <div class="footer">
        <footer id="contact">
            <p>Whatsapp:</p><br>
            <p>+62 82289691770</p>
            <p>Team:</p><br>
            <p>-Jastin Reja</p><br>
            <p>-Anisya Miftahul Jannah</p><br>
            <p>-Ibnu Aqhila Afkar</p>
        </footer>
    </div>
</body>

</html>