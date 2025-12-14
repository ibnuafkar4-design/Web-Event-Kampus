<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard Event</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.font-awesome.com/a2e0e6ad18.js" crossorigin="anonymous"></script>
<style>
body { background-color: #0b1b3a; 
}
/* Samain ukuran gambar di tabel */
.table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    background-color: transparent;
}
</style>
</head>
<body class="text-light">
    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand sticky-top">
        <div class="container-fluid">
            
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
                    <a class="nav-link text-light" href="home.html"><i class="fa-solid fa-house"></i> Tambah Event</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-light" href="login.html"><i class="fa-solid fa-circle-info"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <button class="btn btn-outline-light -2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
        <i class="fa-solid fa-bars"></i></button>
<div class="container py-4">
    <h2 class="text-center mb-4 text-warning"><i class="fa fa-calendar"></i> Admin Dashboard</h2>

    <!-- Tombol tambah event & logout -->
    <div class="d-flex justify-content-between mb-3">
        <button id="btnAdd" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#eventModal">
            <i class="fa fa-plus"></i> Tambah Event
        </button>
        <button id="btnLogout" class="btn btn-danger" onclick="window.location.href='login.php'">
            <i class="fa fa-right-from-bracket"></i> Logout
        </button>
    </div>

    <!-- Tabel Event -->
    <table class="table table-dark table-bordered align-middle text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Tempat</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'koneksi.php';
            $query = mysqli_query($koneksi, "SELECT * FROM admin");
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['judul']; ?></td>
                    <td><?= $data['tanggal']; ?></td>
                    <td><?= $data['waktu']; ?></td>
                    <td><?= $data['tempat']; ?></td>
                    <td><?= $data['deskripsi']; ?></td>
                    <td>
                        <img src="upload/<?= $data['gambar']; ?>" class="img-event">
                    </td>

                    <td>
                        <button class="btn btn-success btn-sm me-1 edit-button" data-bs-toggle="modal"
                            data-bs-target="#eventModal"
                            data-judul="<?= $data['judul']; ?>"
                            data-tanggal="<?= $data['tanggal']; ?>"
                            data-waktu="<?= $data['waktu']; ?>"
                            data-tempat="<?= $data['tempat']; ?>"
                            data-deskripsi="<?= $data['deskripsi']; ?>"
                            data-gambar="<?= $data['gambar']; ?>">
                            <i class="fas fa-edit"></i> EDIT
                        </button>

                        <a href="hapus_admin.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash-alt"></i> DELETE
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah/Edit Event -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-edit"></i> Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="tambah_admin.php"method="POST" enctype="multipart/form-data">
                <div class="mb-2 text-center">
                    <img id="editGambarPreview" src="" width="150" class="img-thumbnail d-none">
                </div>
                    <input type="hidden" name="id" id="id">
                    <div class="mb-2">
                        <label>Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Waktu</label>
                        <input type="time" name="waktu" id="waktu" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Tempat</label>
                        <input type="text" name="tempat" id="tempat" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control">
                    </div>
                    <button type="submit" name="save" class="btn btn-warning w-100 mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-button');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {

                document.getElementById('judul').value = this.dataset.judul;
                document.getElementById('tanggal').value = this.dataset.tanggal;
                document.getElementById('waktu').value = this.dataset.waktu;
                document.getElementById('tempat').value = this.dataset.tempat;
                document.getElementById('deskripsi').value = this.dataset.deskripsi;
                
                const preview = document.getElementById('editGambarPreview');
                if (this.dataset.gambar) {
                preview.src = 'upload/' + this.dataset.gambar;
                preview.classList.remove('d-none');
                } else {
                preview.classList.add('d-none');
                }
            });
        });
    });
</script>

</body>
</html>
