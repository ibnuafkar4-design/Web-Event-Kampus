<?php 
require_once 'config.php';
require 'auth_middleware.php';


// Hanya admin yang boleh masuk halaman ini
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admindashboard.js"></script>
</body>

</html>