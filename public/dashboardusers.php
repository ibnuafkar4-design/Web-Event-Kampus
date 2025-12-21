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
<nav class="navbar navbar-expand sticky-top px-3">
  <form method="GET" class="d-flex me-auto">
    <input class="form-control me-2" type="text" name="search"
           placeholder="event title or date (YYYY-MM-DD)"
           value="<?= htmlspecialchars($keyword) ?>">
    <button class="btn btn-outline-light" type="submit">Search</button>
  </form>

  <a class="navbar-brand ms-3" href="dashboardusers.php">Home</a>
  <a class="navbar-brand ms-3" href="dashboardusers.php">Events</a>
  <a class="navbar-brand ms-3" href="#contact">contact</a>
  <a class="navbar-brand ms-3" href="kalender.php">Calender</a>
  <img src="logopolibatam.jpg" class="navbar-logo" alt="logo" width="50">
</nav>

<!-- ================= CAROUSEL ================= -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <?php if (count($events) > 0): ?>
      <?php foreach ($events as $i => $event): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
          <img src="upload/<?= $event['gambar'] ?>" class="d-block w-100">
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
        <img src="upload/<?= $event['gambar'] ?>">
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
        <img src="upload/<?= $event['gambar'] ?>" class="img-fluid rounded mb-3"
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
