<?php
include 'koneksi.php';


session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #0b1b3a;
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
    <nav class="navbar navbar-dark fixed-top shadow" style="background-color:#0b1b3a;">
        <div class="container-fluid">
            <!-- Tombol sidebar -->
            <button class="btn btn-outline-light me-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Judul navbar -->
            <span class="navbar-brand mb-0 h1 text-warning"> Admin Dashboard</span>
        </div>
    </nav>
    </div>

    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title text-warning"><i class="fa-solid fa-bolt me-2"></i>Event Polibatam</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column fs-5">
                <li class="nav-item mb-2">
                    <a class="nav-link text-light" href="landingpage.php"><i class="fa-solid fa-house"></i> Beranda</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-light" href="logout.php"><i class="fa-solid fa-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container py-4 mt-4">
        <h2 class="text-center mb-4 text-warning"><i class="fa fa-calendar"></i> Daftar Event</h2>

        <!-- Tombol tambah event & logout -->
        <div class="d-flex justify-content-between mb-3">
            <button id="btnAdd" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#eventModal">
                <i class="fa fa-plus"></i> Tambah Event
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
                        <td align="left"><?= $no++; ?></td>
                        <td align="left"><?= $data['judul']; ?></td>
                        <td align="left"><?= $data['tanggal']; ?></td>
                        <td align="left"><?= $data['waktu']; ?></td>
                        <td align="left"><?= $data['tempat']; ?></td>
                        <td align="justify"><?= $data['deskripsi']; ?></td>
                        <td><img src="uploads/<?= $data['foto']; ?>" alt="Foto" width="0"></td>

                        <td>
                            <button class="btn btn-warning btn-edit" data-id="<?= $data['id']; ?>"
                                data-bs-target="#eventModal" data-bs-toggle="modal" data-judul="<?= $data['judul']; ?>"
                                data-tanggal="<?= $data['tanggal']; ?>" data-waktu="<?= $data['waktu']; ?>"
                                data-tempat="<?= $data['tempat']; ?>" data-deskripsi="<?= $data['deskripsi']; ?>"
                                data-foto="<?= $data['foto']; ?>">
                                <i class="fas fa-edit"></i> EDIT
                            </button>

                            <a href="hapus_admin.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i>
                                DELETE</a>
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
                    <form action="tambah_admin.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-2 text-center">
                        </div>
                        <img id="fotoPreview" class="img-fluid mb-2" style="max-height:250px";>
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
                            <label for="foto" class="form-label">Upload Gambar</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>
                        <button type="submit" name="save" class="btn btn-warning w-100 mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {

                    // isi data ke modal
                    document.getElementById('id').value = this.dataset.id;
                    document.getElementById('judul').value = this.dataset.judul;
                    document.getElementById('tanggal').value = this.dataset.tanggal;
                    document.getElementById('waktu').value = this.dataset.waktu;
                    document.getElementById('tempat').value = this.dataset.tempat;
                    document.getElementById('deskripsi').value = this.dataset.deskripsi;

                    const fotoPreview = document.getElementById('fotoPreview');
                    const fotoPath = this.dataset.foto ? `uploads/${this.dataset.foto}` : '';
                    fotoPreview.src = fotoPath;
                    fotoPreview.style.display = fotoPath ? 'block' : 'none';


                });
            });
        })
    </script>
    <script>
        document.getElementById('btnAdd').addEventListener('click', function () {
            document.getElementById('id').value = '';
            document.getElementById('judul').value = '';
            document.getElementById('tanggal').value = '';
            document.getElementById('waktu').value = '';
            document.getElementById('tempat').value = '';
            document.getElementById('deskripsi').value = '';

            const fotoPreview = document.getElementById('fotoPreview');
            if (fotoPreview) fotoPreview.style.display = 'none';
        });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>