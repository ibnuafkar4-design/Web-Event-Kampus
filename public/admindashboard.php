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
            <button class="btn btn-outline-warning me-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Judul navbar -->
            <span class="navbar-brand mb-0 h1 text-warning"> Dashboard Admin</span>
        </div>
    </nav>
    </div>

    <!-- Sidebar -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-header justify-content-center">
            <div class="d-flex flex-column align-items-center gap-2">
                <img src="logopolibatam.jpg" alt="Logo Polibatam" width="50" height="50" class="rounded-circle">

                <h5 class="offcanvas-title text-warning mb-0 text-center">
                    EVENT POLITEKNIK NEGERI BATAM
                </h5>
            </div>

            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                data-bs-dismiss="offcanvas"></button>
        </div>


        <div class="offcanvas-body">
            <ul class="nav flex-column fs-5">
                <li class="nav-item mb-2">
                    <a class="nav-link text-light neon-hover" href="landingpage.php"><i class="fa-solid fa-house"></i>
                        Beranda</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-light neon-hover" href="logout.php"><i
                            class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container py-4 mt-5">
        <h2 class="text-center mb-4 text-warning"><i class="fa fa-calendar"></i> Daftar Event</h2>

        <!-- Tombol tambah event & logout -->
        <div class="d-flex justify-content-between mb-3">
            <button id="btnAdd" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fa fa-plus"></i> Tambah Event
            </button>
        </div>

        <body>
            <table class="table table-bordered table-dark text-light">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
               include __DIR__ . '/../database/koneksi2.php'; 
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
                                onclick="return confirm('Yakin ingin menghapus data ini?')"><i
                                    class="fas fa-trash-alt"></i>
                                DELETE</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="tambah_admin.php" enctype="multipart/form-data">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="tambah_admin.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-2 text-center">
                            </div>
                            <img id="fotoPreview" class="img-fluid mb-2" style="max-height:250px" ;>
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
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="2"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Upload Gambar</label>
                                <input type="file" name="foto" id="foto" class="form-control">
                            </div>
                            <button type="submit" name="save" class="btn btn-warning w-100 mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="editId" name="id">

                    <div class="mb-3">
                        <label for="editJudul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="editJudul" name="judul" required>
                    </div>

                    <div class="mb-3">
                        <label for="editTanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
                    </div>

                    <div class="mb-3">
                        <label for="editWaktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="editWaktu" name="waktu" required>
                    </div>

                    <div class="mb-3">
                        <label for="editTempat" class="form-label">Tempat</label>
                        <input type="text" class="form-control" id="editTempat" name="tempat" required>
                    </div>

                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDeskripsi" name="deskripsi" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto Saat Ini</label><br>
                        <img id="editFotoPreview" src="" alt="Foto" width="150" class="mb-3 border rounded"><br>
                        <label for="editFoto" class="form-label">Ganti Foto</label>
                        <input type="file" class="form-control" id="editFoto" name="foto">
                    </div>
                </div>

        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {

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
        document.getElementById('btnAdd').addEventListener('click', function() {
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