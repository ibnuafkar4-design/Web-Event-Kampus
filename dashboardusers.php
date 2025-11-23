<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Random Event - Jastin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link href="dashboardusers.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark navbar-expand sticky-top">
    <div class="container-fluid">
      <button class="btn btn-outline-light -2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar"><i class="fa-solid fa-bars"></i></button>
       <div class="d-flex me-auto" id="searchContainer" role="search">
        <input class="form-control me-2" type="text" name="searchBar" id="searchBar" placeholder="Search for a event" aria-label="Search">
          <button class="btn btn-outline-light" type="submit">Search</button>
        </div>
       </div>
      <a class="navbar-brand" href="home.html">Event Polibatam</a>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title text-warning"><i class="fa-solid fa-bolt me-2"></i>Event Polibatam</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column fs-5">
        <li class="nav-item mb-2">
          <a class="nav-link text-light" href="home.html"><i class="fa-solid fa-house"></i> Home</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-light" href="#events"><i class="fa-solid fa-calendar-days"></i> Events</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-light" href="#contact"><i class="fa-solid fa-envelope"></i> Contact</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link text-light" href="login.html"><i class="fa-solid fa-circle-info"></i> Logout</a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Carousel -->
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner" id="carouselInner"></div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- Event Section -->
  <section class="container my-5" id="events">
    <h3 class="text-center text-warning mb-4"><i class="fa-solid fa-star me-2"></i>List Event</h3>
    <div class="scroll-wrapper" id="eventScroll"></div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="detailTitle">Detail Event</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img id="detailImg" src="" class="img-fluid rounded mb-3" style="height:300px;object-fit:cover;">
          <p><strong><i class="fa-regular fa-calendar"></i> Tanggal:</strong> <span id="detailDate"></span></p>
          <p><strong><i class="fa-regular fa-clock"></i> Waktu:</strong> <span id="detailTime"></span></p>
          <p><strong><i class="fa-solid fa-location-dot"></i> Tempat:</strong> <span id="detailPlace"></span></p>
          <p id="detailDesc"></p>
          <button id="btnDaftar" class="btn btn-custom mt-2">Daftar Event</button>
        </div>
      </div>
    </div>
  </div>
  
<!-- Footer -->
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="dashboardusers.js"></script>
</body>
</html>
