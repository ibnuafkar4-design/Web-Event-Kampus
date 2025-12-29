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
        
        /* Efek neon ungu untuk sidebar */
.nav-link.neon-hover {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.nav-link.neon-hover:hover,
.nav-link.neon-hover:focus {
    background: rgba(255, 193, 7, 0.18); /* ungu neon soft */
    color: #ffc107;
    box-shadow: 0 0 10px rgba(255, 193, 7, 0.75);
}

.nav-link.neon-hover i {
    transition: color 0.3s ease;
}

.nav-link.neon-hover:hover i {
    color: #ffc107;
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
        <img src="logopolibatam.jpg"
             alt="Logo Polibatam"
             width="50"
             height="50"
             class="rounded-circle">

        <h5 class="offcanvas-title text-warning mb-0 text-center">
            EVENT POLITEKNIK NEGERI BATAM
        </h5>
    </div>

    <button type="button"
            class="btn-close btn-close-white position-absolute end-0 me-3"
            data-bs-dismiss="offcanvas"></button>
</div>


        <div class="offcanvas-body">
            <ul class="nav flex-column fs-5">
                <li class="nav-item mb-2">
                    <a class="nav-link text-light neon-hover" href="landingpage.php"><i class="fa-solid fa-house"></i> Beranda</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-light neon-hover" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
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
                include 'koneksi.php';
                $query = mysqli_query($koneksi, "SELECT * FROM admin");
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?= $data['judul']; ?></td>
                        <td><?= $data['tanggal']; ?></td>
                        <td><?= $data['waktu']; ?></td>
                        <td><?= $data['tempat']; ?></td>
                        <td><?= $data['deskripsi']; ?></td>
                        <td><img src="uploads/<?= $data['foto']; ?>" alt="Foto" width="100"></td>
                        <td>
                            <button class="btn btn-warning btn-edit"
                                data-id="<?= $data['id']; ?>"
                                data-judul="<?= $data['judul']; ?>"
                                data-tanggal="<?= $data['tanggal']; ?>"
                                data-waktu="<?= $data['waktu']; ?>"
                                data-tempat="<?= $data['tempat']; ?>"
                                data-deskripsi="<?= $data['deskripsi']; ?>"
                                data-foto="<?= $data['foto']; ?>"> 
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <a href="hapus_admin.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt me-1"></i> Hapus</a>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="waktu" class="form-label">Waktu</label>
                        <input type="time" class="form-control" id="waktu" name="waktu" required>
                    </div>
                    <div class="mb-3">
                        <label for="tempat" class="form-label">Tempat</label>
                        <input type="text" class="form-control" id="tempat" name="tempat" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="ubah_admin.php" enctype="multipart/form-data">
            <div class="modal-content bg-dark text-light">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Simpan</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
    
<script>
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {

        // Isi data ke modal
        document.getElementById('editId').value = this.dataset.id;
        document.getElementById('editJudul').value = this.dataset.judul;
        document.getElementById('editTanggal').value = this.dataset.tanggal;
        document.getElementById('editWaktu').value = this.dataset.waktu;
        document.getElementById('editTempat').value = this.dataset.tempat;
        document.getElementById('editDeskripsi').value = this.dataset.deskripsi;

        // Preview Foto
        const fotoPath = this.dataset.foto ? `uploads/${this.dataset.foto}` : '';
        const fotoPreview = document.getElementById('editFotoPreview');
        fotoPreview.src = fotoPath;
        fotoPreview.style.display = fotoPath ? 'block' : 'none';

        // Tampilkan Modal
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>