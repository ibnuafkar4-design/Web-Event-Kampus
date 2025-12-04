<?php 
require_once 'config.php';
require 'auth_middleware.php';


//cuman admin yang boleh masuk halaman ini
if ($_SESSION['role'] !== 'admin') {
die('Akses ditolak.');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad18.js" crossorigin="anonymous"></script>
</head>
<style>
body {
    background-color: #0b1b3a;
}
</style>

<body class="text-light">
    <div class="container py-4">
        <h2 class="text-center mb-4 text-warning"><i class="fa fa-calendar"></i> Admin Dashboard</h2>
        <!--tombol tambah event dan logout-->
        <div class="d-flex justify-content-between mb-3">
            <button id="btnAdd" class="btn btn-warning">
                <i class="fa fa-plus"></i> Tambah Event
            </button>
            <button id="btnLogout" class="btn btn-danger" onclick="window.location.href='login.html'">
                <i class="fa fa-right-from-bracket"></i> Logout
            </button>
        </div>
        <!--Tabel-->
        <table class="table table-dark table-bordered align-middle text-center">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Tempat</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="eventTable"></tbody>
        </table>
    </div>

    <!--Modal Tambah/Edit-->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit"></i> Event</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="index" />
                        <div class="mb-2">
                            <label>Judul</label>
                            <input type="text" id="title" class="form-control" required />
                        </div>
                        <div class="mb-2">
                            <label>Tanggal</label>
                            <input type="date" id="date" class="form-control" required />
                        </div>
                        <div class="mb-2">
                            <label>Waktu</label>
                            <input type="time" id="time" class="form-control" required />
                        </div>
                        <div class="mb-2">
                            <label>Tempat</label>
                            <input type="text" id="place" class="form-control" required />
                        </div>
                        <div class="mb-2">
                            <label>Deskripsi</label>
                            <textarea id="desc" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imgFile" class="form-label">Upload Gambar</label>
                            <input type="file" id="imgFile" class="form-control">
                        </div>
                        <label>Status Pendaftaran</label>
                        <select id="daftar" class="form-select">
                            <option value="true">Bisa Daftar</option>
                            <option value="false">Tidak Bisa</option>
                        </select>
                </div>
                <button type="submit" class="btn btn-warning w-100 mt-3"> Simpan </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!--Modal List peserta-->
    <div class="modal fade" id="pesertaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-users"></i> Daftar Peserta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul id="listPeserta" class="list-group list-group-flush"></ul>
                </div>
            </div>
        </div>
    </div>

    <?php
    include 'config.php';
    $query = mysqli_query

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let events = JSON.parse(localStorage.getItem("events"));
const table = document.getElementById("eventTable");
const form = document.getElementById("eventForm");
const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
const pesertaModal = new bootstrap.Modal(document.getElementById("pesertaModal"));
const listPeserta = document.getElementById("listPeserta");

// Render event ke tabel
function render() {
  table.innerHTML = "";
  //di dalam tabelnya
  events.forEach((event, i) => {
    table.innerHTML +=`
      <tr>
        <td>${event.title}</td>
        <td>${event.date}</td>
        <td>${event.time}</td>
        <td>${event.place}</td>
        <td>${event.daftar ? "Bisa" : "Tidak"}</td>
        <td>
          <img src="${
            event.img
          }" alt="img" width="80" height="60" style="object-fit:cover;border-radius:5px">
        </td>
        <td>
          <button class="btn btn-info btn-sm" onclick="lihatPeserta(${i})">Lihat (${event.peserta?.length || 0})</button>
        </td>
        <td>
          <button class="btn btn-warning btn-sm me-1" onclick="editEvent(${i})"><i class="fa fa-edit"></i>Edit</button>
          <button class="btn btn-danger btn-sm" onclick="hapusEvent(${i})"><i class="fa fa-trash"></i>Hapus</button>
        </td>
      </tr>`;
  });

  localStorage.setItem("events", JSON.stringify(events));
}

// Tambah/Edit event
form.addEventListener("submit", (tambah) => {
  tambah.preventDefault();
  const idx = document.getElementById("index").value;
  const fileInput = document.getElementById("imgFile");
  let imagePath = events[idx]?.img

  //input files
  if (fileInput.files && fileInput.files[0])
  {
    imagePath = URL.createObjectURL(fileInput.files[0]);
  }
  //untuk tambah event
  const newEvent = {
    title: document.getElementById("title").value,
    date: document.getElementById("date").value,
    time: document.getElementById("time").value,
    place: document.getElementById("place").value,
    desc: document.getElementById("desc").value,
    img: imagePath,
    daftar: document.getElementById("daftar"),
    peserta: events[idx]?.peserta || [],
  };

  if (idx === "") events.push(newEvent);
  else events[idx] = newEvent;

  localStorage.setItem("events", JSON.stringify(events));
  form.reset();
  document.getElementById("index").value = "";
  eventModal.hide();
  render();
});

// Edit event
function editEvent(i) {
  const e = events[i];
  document.getElementById("index").value = i;
  document.getElementById("title").value = e.title;
  document.getElementById("date").value = e.date;
  document.getElementById("time").value = e.time;
  document.getElementById("place").value = e.place;
  document.getElementById("desc").value = e.desc;
  document.getElementById("daftar").value = e.daftar ? "true" : "false";
  eventModal.show();
}

// Hapus event
function hapusEvent(i) {
  if (confirm("Yakin mau hapus event ini?")) {
    events.splice(i, 1);
    localStorage.setItem("events", JSON.stringify(events));
    render();
  }
}

// Lihat peserta
function lihatPeserta(i) {
  const ev = events[i];
  listPeserta.innerHTML = "";
  if (!ev.peserta || ev.peserta.length === 0) {
    listPeserta.innerHTML = `<li class="list-group-item bg-dark text-muted text-center">Belum ada peserta</li>`;
  } else {
    ev.peserta.forEach((p, idx) => {
      listPeserta.innerHTML += `
        <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
          ${idx + 1}. ${p}
          <button class="btn btn-outline-danger" onclick="hapusPeserta(${i}, ${idx})">Hapus<i class="fa fa-times"></i></button>
        </li>`;
    });
  }
  pesertaModal.show();
}

// Hapus peserta
function hapusPeserta(eventIdx, pesertaIdx) {
  events[eventIdx].peserta.splice(pesertaIdx, 1);
  localStorage.setItem("events", JSON.stringify(events));
  lihatPeserta(eventIdx);
}

// Tombol tambah event
document.getElementById("btnAdd").addEventListener("click", () => {
  form.reset();
  document.getElementById("index").value = "";
  eventModal.show();
});

// Render Event nya
render();

    </script>
</body>

</html>