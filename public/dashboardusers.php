<?php
$koneksi = mysqli_connect("localhost", "root", "", "pbl");

$input = $_GET['search'] ?? '';

preg_match('/@(\d{4}-\d{2}-\d{2})/', $input, $match);
$tanggal = $match[1] ?? '';

$keyword = trim(preg_replace('/@\d{4}-\d{2}-\d{2}/', '', $input));


$sql = "SELECT * FROM admin WHERE 1=1";

if ($keyword) {
    $sql .= " AND judul LIKE '%$keyword%'";
}

if ($tanggal) {
    $sql .= " AND tanggal = '$tanggal'";
}

$query = mysqli_query($koneksi, $sql);


$events = [];
while ($row = mysqli_fetch_assoc($query)) {
  $events[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Kampus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="dashboardusers.css" rel="stylesheet">

  <style>
    .carousel,
    .carousel-inner,
    .carousel-item {
      height: 90vh;
    }
    .carousel-item img {
      height: 90vh;
      object-fit: contain;
      filter: brightness(60%);
    }
  </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-dark navbar-expand sticky-top">
        <div class="container-fluid">
            <div class="d-flex me-auto" id="searchContainer" role="search">
                <input class="form-control me-2" type="text" name="searchBar" id="searchBar"
                    placeholder="Search for a event"
                    value="<?= htmlspecialchars($keyword) ?>" aria-label="Search">
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

<!-- ================= CAROUSEL ================= -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <?php if (count($events) > 0): ?>
      <?php foreach ($events as $i => $event): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
          <img src="upload/<?= $event['foto'] ?>" class="d-block w-100">
          <div class="carousel-caption bg-dark bg-opacity-50 rounded">
            <h5><?= $event['judul'] ?></h5>
            <p><?= $event['tanggal'] ?> • <?= $event['tempat'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="carousel-item active">
        <div class="d-flex justify-content-center align-items-center h-100 text-light">
          <h3>Tidak ada event</h3>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- ================= CARD EVENT ================= -->
<section class="container my-5">
  <h3 class="text-center text-warning mb-4">
    <i class="fa-solid fa-star me-2"></i>List Event
  </h3>

  <div class="scroll-wrapper d-flex flex-wrap gap-3 justify-content-center">
    <?php foreach ($events as $event): ?>
      <div class="event-card" data-bs-toggle="modal" data-bs-target="#modal<?= $event['id'] ?>">
        <img src="upload/<?= $event['foto'] ?>">
        <div class="event-info">
          <h5><?= $event['judul'] ?></h5>
          <p><?= $event['tanggal'] ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ================= MODAL DETAIL ================= -->
<?php foreach ($events as $event): ?>
<div class="modal fade" id="modal<?= $event['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header border-0">
        <h5 class="modal-title"><?= $event['judul'] ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img src="upload/<?= $event['foto'] ?>" class="img-fluid rounded mb-3"
             style="height:300px;object-fit:cover;">
        <p><strong>Tanggal:</strong> <?= $event['tanggal'] ?></p>
        <p><strong>Waktu:</strong> <?= $event['waktu'] ?></p>
        <p><strong>Tempat:</strong> <?= $event['tempat'] ?></p>
        <p><?= $event['deskripsi'] ?></p>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

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
        <a href="#"
           class="btn btn-warning fw-semibold px-4">
          CONTACT & SERVICE
        </a><br>
        <a href="login.php" class="text-dark me-3">Admin</a>
      </div>

    </div>

    <hr class="border-secondary my-3">

    <!-- BAWAH -->
    <div class="d-flex flex-wrap justify-content-between align-items-center">

      <div class="text-warning fs-5">
        <a href="#" class="me-3 text-warning"><i class="fab fa-facebook"></i></a>
        <a href="#" class="me-3 text-warning"><i class="fab fa-instagram"></i></a>
        <a href="#" class="me-3 text-warning"><i class="fab fa-youtube"></i></a>
        <a href="#" class="text-warning"><i class="fab fa-twitter"></i></a>
      </div>

      <div class="footer-copyright">
        © 2025 IFPagi1D-7.
      </div>

    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
