<?php
include '../app/koneksi2.php';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    .footer-dashboard {
  background: linear-gradient(180deg, #0b1f3a, #102c54);
  color: #fff;
}

.footer-dashboard a {
  text-decoration: none;
  color: #f8f9fa;
}

.footer-dashboard a:hover {
  color: #ffc107;
}

.footer-links a {
  font-size: 14px;
  color: #ddd;
}
    </style>
</head>

<body>
    <nav class="navbar navbar-dark sticky-top">
        <div class="container-fluid d-flex justify-content-end align-items-center">
            <a class="navbar-brand" href="kalender.php">Kalender</a>
            <a class="navbar-brand" href="landingpage.php">Beranda</a>
            <a class="navbar-brand" href="dashboardusers.php">Event</a>
            <a class="navbar-brand" href="#contact">Kontak</a>
            <a class="navbar-brand" href="login.php">Login</a>
            <img src="logopolibatam.jpg" alt="Logo" width="40" height="40">
        </div>
    </nav>

    <div class="container mt-4">


        <h3 class="text-center">Kalender Event Kampus</h3>

        <!--navigasi bulan-->
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
    <!-- ================= FOOTER ================= -->
<footer class="footer-dashboard mt-5" id="contact">
  <div class="container py-4">
    <div class="row align-items-start">

      <!-- KIRI -->
      <div class="col-md-4 text-light mb-3">
        <h6 class="fw-bold">Politeknik Negeri Batam</h6>
        <p class="mb-1">Jl. Ahmad Yani, Batam Center</p>
        <p class="mb-0">Kepulauan Riau</p>
      </div>

      <!-- TENGAH -->
      <div class="col-md-4 text-light mb-3">
        <p class="mb-1"><i class="fa-solid fa-phone me-2"></i>+62 778 469858</p>
        <p class="mb-1"><i class="fa-solid fa-envelope me-2"></i>info@polibatam.ac.id</p>
        <p class="mb-0"><i class="fa-solid fa-globe me-2"></i>www.polibatam.ac.id</p>
      </div>

      <!-- KANAN -->
      <div class="col-md-4 text-md-end">
        <a href="https://wa.me/62895600308271"
           class="btn btn-warning fw-semibold px-4">
          CONTACT & SERVICE
        </a>
      </div>

    </div>

    <hr class="border-secondary my-3">

    <!-- BAWAH -->
    <div class="d-flex flex-wrap justify-content-between align-items-center">

      <div class="text-warning fs-5">
        <a href="https://www.facebook.com/share/1CAhCEMLZT/" class="me-3 text-warning"><i class="fab fa-facebook"></i></a>
        <a href="https://www.instagram.com/polibatamofficial?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="me-3 text-warning"><i class="fab fa-instagram"></i></a>
        <a href="https://www.youtube.com/c/PolibatamTV/" class="me-3 text-warning"><i class="fab fa-youtube"></i></a>
        <a href="https://www.youtube.com/redirect?event=channel_description&redir_token=QUFFLUhqbUtXSWlQMUZzeXQ4Vkk0WTNkbGZkRzBidEZTZ3xBQ3Jtc0tsWTNXLXpSekpZZ0tkQnYtaFgydEFnOHQxOFhsanNrRUh5VFF5MkpqWHEwX3NyR0lDU1ltWXY5c2VVZmVHNU5Ya2psUU40YXpWMVZWWG96ZXpNZTNEWUJkUGhqUC1HVktZYmN2V0pRLUZGMnRNeWROSQ&q=https%3A%2F%2Ftwitter.com%2Fpolibatam_" class="text-warning"><i class="fab fa-twitter"></i></a>
      </div>

      <div class="footer-copyright">
       Copyright © 2025 IFPagi1D-7. All Right Reserved.
      </div>

    </div>
  </div>
</footer>

</body>

</html>