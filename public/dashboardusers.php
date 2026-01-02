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
/* ===== SLIDER ===== */

.event-slider-wrapper {
    width: 100%;
    padding: 60px 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.event-slider {
    display: flex;
    gap: 30px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    padding: 10px calc(50% - 160px);
}


/* slide */
.event-slide {
    scroll-snap-align: center;
    flex: 0 0 auto;
    width: 320px;
    position: relative;
    transform: scale(0.85);
    opacity: 0.5;
    transition: 0.4s ease;
    cursor: pointer;
}

.event-slide.active {
    transform: scale(1);
    opacity: 1;
}

.event-slide img {
    width: 100%;
    border-radius: 18px;
    box-shadow: 0 18px 35px rgba(0,0,0,0.35);
}

/* caption */
.event-caption {
    position: absolute;
    bottom: 15px;
    left: 15px;
    right: 15px;
    background: rgba(0,0,0,0.55);
    color: #fff;
    padding: 10px;
    border-radius: 10px;
}

/* panah */
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #0d6efd;
    border: none;
    color: #fff;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    z-index: 10;
}

.slider-arrow.left { left: 10px; }
.slider-arrow.right { right: 10px; }

.slider-arrow:hover {
    background: #0b5ed7;
}

/* hide scrollbar */
.event-slider::-webkit-scrollbar { display: none; }
.event-slider { scrollbar-width: none; }

  </style>

</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-dark navbar-expand sticky-top">
        <div class="container-fluid">
            <div class="d-flex me-auto" id="searchContainer" role="search">
                <input class="form-control me-2" type="text" name="searchBar" id="searchBar"
                    placeholder="Cari Event"
                    value="<?= htmlspecialchars($keyword) ?>" aria-label="Search">
                <button class="btn btn-outline-light" type="submit" id="btnSearch">Cari</button>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand" href="kalender.php"> Kalender</a>
            <a class="navbar-brand" href="landingpage.php">Beranda</a>
            <a class="navbar-brand" href="dashboardusers.php">Event</a>
            <a class="navbar-brand" href="#contact">Kontak</a>
            <a class="navbar-brand" href="login.php">Login</a>
            <img src="logopolibatam.jpg" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">

        </div>
    </nav>

<!-- ================= SLIDER CAROUSEL ================= -->
<div class="event-slider-wrapper position-relative">

  <!-- Panah kiri -->
  <button class="slider-arrow left" id="prevSlide">
    <i class="fa-solid fa-chevron-left"></i>
  </button>

  <!-- Slider -->
  <div class="event-slider" id="eventSlider">

    <?php if (count($events) > 0): ?>
      <?php foreach ($events as $event): ?>
        <div class="event-slide"
             data-bs-toggle="modal"
             data-bs-target="#modal<?= $event['id'] ?>">
          <img src="uploads/<?= $event['foto'] ?>" alt="<?= $event['judul'] ?>">
          <div class="event-caption">
            <h5><?= $event['judul'] ?></h5>
            <p><?= $event['tanggal'] ?> • <?= $event['tempat'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-light">Tidak ada event</p>
    <?php endif; ?>

  </div>

  <!-- Panah kanan -->
  <button class="slider-arrow right" id="nextSlide">
    <i class="fa-solid fa-chevron-right"></i>
  </button>

</div>






<!-- ================= CARD EVENT ================= -->
<section class="container my-5">
  <h3 class="text-center text-warning mb-4">
    <i class="fa-solid fa-star me-2"></i>List Event
  </h3>

  <div class="scroll-wrapper d-flex flex-wrap gap-3 justify-content-center text-light">
    <?php foreach ($events as $event): ?>
      <div class="event-card" data-bs-toggle="modal" data-bs-target="#modal<?= $event['id'] ?>">
        <img src="uploads/<?= $event['foto'] ?>">
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
        <img src="uploads/<?= $event['foto'] ?>" class="img-fluid rounded mb-3"
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById("btnSearch").addEventListener("click", function () {
  const keyword = document.getElementById("searchBar").value;
  window.location.href = "?search=" + encodeURIComponent(keyword);
});

/* ===== SLIDER CAROUSEL ===== */
const slider = document.getElementById("eventSlider");
const slides = Array.from(document.querySelectorAll(".event-slide"));
const nextBtn = document.getElementById("nextSlide");
const prevBtn = document.getElementById("prevSlide");

let autoSlide;

/* ===== CARI SLIDE TENGAH ===== */
function getCenterIndex() {
  const sliderRect = slider.getBoundingClientRect();
  const sliderCenter = sliderRect.left + sliderRect.width / 2;

  let closestIndex = 0;
  let minDistance = Infinity;

  slides.forEach((slide, i) => {
    const rect = slide.getBoundingClientRect();
    const slideCenter = rect.left + rect.width / 2;
    const distance = Math.abs(slideCenter - sliderCenter);

    if (distance < minDistance) {
      minDistance = distance;
      closestIndex = i;
    }
  });

  return closestIndex;
}

/* ===== AKTIF SLIDE ===== */
function setActiveSlide() {
  const activeIndex = getCenterIndex();

  slides.forEach((slide, i) => {
    slide.classList.toggle("active", i === activeIndex);
  });
}

/* ===== SCROLL KE INDEX ===== */
function scrollToIndex(index) {
  const slide = slides[index];
  const slideLeft = slide.offsetLeft;
  const slideWidth = slide.offsetWidth;
  const sliderWidth = slider.offsetWidth;
  const targetScrollLeft = slideLeft - (sliderWidth / 2) + (slideWidth / 2);

  slider.scrollTo({
    left: targetScrollLeft,
    behavior: 'smooth'
  });
}

/* ===== PANAH ===== */
nextBtn.onclick = () => {
  const index = getCenterIndex();
  if (index < slides.length - 1) scrollToIndex(index + 1);
};

prevBtn.onclick = () => {
  const index = getCenterIndex();
  if (index > 0) scrollToIndex(index - 1);
};

/* ===== AUTO SLIDE ===== */
function startAuto() {
  autoSlide = setInterval(() => {
    const index = getCenterIndex();
    if (index < slides.length - 1) {
      scrollToIndex(index + 1);
    } else {
      scrollToIndex(0);
    }
  }, 4000);
}

startAuto();

/* pause */
slider.addEventListener("mouseenter", () => clearInterval(autoSlide));
slider.addEventListener("mouseleave", startAuto);

slider.addEventListener("scroll", setActiveSlide);
window.addEventListener("load", setActiveSlide);
</script>

</body>
</html>
