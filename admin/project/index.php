<?php
    session_start();
    // memanggil fungsi 
    require 'functions.php';

    // jika tidak ada username yang masuk
    if (!isset($_SESSION["username"])) {
        echo "
            <script>
                alert('Anda Harus Login Dulu!');
                document.location.href = '../../index.php';
            </script>
            ";
        exit;
    }

    $level = $_SESSION["level"];

    // jika level bukan Admin
    if ($level != "admin") {
        echo "
            <script>
                alert('Anda tidak punya akses pada halaman Admin');
                document.location.href = '../logout.php';
            </script>
            ";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Projek</title>
    <style>
        table thead tr th {
            text-align: center;
        }
    </style>
    <link href="../assets/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- HEADER -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">TESIT</a>
        <!-- tombol mengatur sidebar -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            <!-- tombol logout -->
                <a class="btn btn-danger" href="../logout.php" role="button"><i class="fas fa-sign-out-alt"></i>&nbsp;Keluar</a>
            </div>
        </form>
    </nav>
    <!-- SIDEBAR -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menu</div>
                        <!-- link Dashboard -->
                        <a class="nav-link" href="../dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- link user -->
                        <a class="nav-link" href="../admin/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            User
                        </a>
                        <!-- link projek -->
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Projek
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- KONTEN -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Data Projek</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Tombol Tambah Projek -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus mr-1"></i>
                                Tambah
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- Table Data projek -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama CR</th>
                                            <th>Nomor CR</th>
                                            <th>PIC</th>
                                            <th>Tanggal Diterima</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // mengambil query data admin
                                        $project = mysqli_query($conn, "SELECT * FROM project");
                                        $i = 1;
                                        // Pengulangan data admin
                                        while ($data = mysqli_fetch_array($project)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_cr']; ?></td>
                                                <td><?= $data['no_cr']; ?></td>
                                                <td><?= $data['customer_pic']; ?></td>
                                                <td><?= $data['tanggal_diterima']; ?></td>
                                                <td><?= $data['tanggal_mulai']; ?></td>
                                                <td><?= $data['tanggal_selesai']; ?></td>
                                                <td>
                                                    <!-- Tombol untuk edit data admin -->
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?php echo $data['id_project']; ?>">
                                                        <i class="fas fa-edit mr-1"></i>Ubah
                                                    </button>
                                                    <!-- tombol untuk hapus data admin -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_project']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Hapus
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal edit -->
                                            <div class="modal fade" id="edit<?php echo $data['id_project']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Projek</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk edit -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_project" value="<?php echo $data['id_project']; ?>">

                                                                <div class="form-group">
                                                                    <label for="nama_projek">Nama Projek</label>
                                                                    <input type="text" name="nama_projek" placeholder="Masukkan Nama Projek" class="form-control" id="nama_projek" value="<?= $data['nama_project']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nama_cr">Nama CR & No Dev</label>
                                                                    <input type="text" name="nama_cr" placeholder="Masukkan Nama Projek" class="form-control" id="nama_cr" value="<?= $data['nama_cr']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="menu">Menu</label>
                                                                    <input type="text" name="menu" placeholder="Masukkan Nama Projek" class="form-control" id="menu" value="<?= $data['menu']; ?>" required>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-warning btn-lg btn-block" name="edit">Edit</button>
                                                            </div>
                                                        </form> 
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- modal hapus -->
                                            <div class="modal fade" id="delete<?php echo $data['id_project']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Projek</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk hapus -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Menghapus Projek "<?= $data['nama_project']; ?>" dengan nama CR & No Dev "<?= $data['nama_cr']; ?>" di Menu "<?= $data['menu']; ?>" ?</p>
                                                                <input type="hidden" name="id_project" value="<?php echo $data['id_project']; ?>">
                                                                <br>
                                                                <button type="submit" class="btn btn-danger btn-lg btn-block" name="hapus">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endwhile;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- All modal -->
    <!-- Modal tambah -->
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Projek</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form untuk tambah -->
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_projek">Nama Projek</label>
                            <input type="text" name="nama_projek" placeholder="Masukkan Nama Projek Baru" class="form-control" id="nama_projek" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_cr">Nama CR</label>
                            <input type="text" name="nama_cr" placeholder="Masukkan Nama CR & No Dev" class="form-control" id="nama_cr" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_cr">No CR</label>
                            <input type="text" name="no_cr" placeholder="Masukkan No CR" class="form-control" id="no_cr" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_diterima">Tanggal Diterima</label>
                            <input type="date" name="tanggal_diterima" class="form-control" id="tanggal_diterima" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_diterima">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_diterima">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="tambah">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    // DataTable Bahasa Indonesia
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });
        });
    </script>
</body>

</html>