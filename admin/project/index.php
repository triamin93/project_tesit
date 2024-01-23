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
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" integrity="sha512-CbQfNVBSMAYmnzP3IC+mZZmYMP2HUnVkV4+PwuhpiMUmITtSpS7Prr3fNncV1RBOnWxzz4pYQ5EAGG4ck46Oig==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
                    <h1 class="mt-4">Rekapitulasi Projek</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Tombol Tambah Projek -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus mr-1"></i>
                                Tambah
                            </button>
                        <div class="card-body">
                            <!-- Table Data projek -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Projek</th>
                                            <th>Nama CR</th>
                                            <th>Nomor CR</th>
                                            <th>PIC</th>
                                            <th>Tanggal Diterima</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>User</th>
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
                                        <!-- mengambil data id project -->
                                        <?php 
                                            $id_project = $data['id_project'];
                                        ?>
                                        <!-- mengambil data macam-macam user berdasarkan project -->
                                        <?php 
                                            $ambil_data_user_perproject = "SELECT id_user FROM akses WHERE id_project = '$id_project'";
                                            $data_user_perproject_run = mysqli_query($conn, $ambil_data_user_perproject);

                                            $users_project = [];

                                            foreach($data_user_perproject_run  as $user_project_row)
                                            {
                                                $users_project[] = $user_project_row['id_user'];
                                            }
                                        ?>
                                            <tr>
                                                
                                                
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_project']; ?></td>
                                                <td><?= $data['nama_cr']; ?></td>
                                                <td><?= $data['no_cr']; ?></td>
                                                <td><?= $data['customer_pic']; ?></td>
                                                <td><?= $data['tanggal_diterima']; ?></td>
                                                <td><?= $data['tanggal_mulai']; ?></td>
                                                <td><?= $data['tanggal_selesai']; ?></td>
                                                <td><?php $users = mysqli_query($conn, "SELECT nama_lengkap FROM user INNER JOIN akses ON user.id_user = akses.id_user INNER JOIN project ON akses.id_project = project.id_project WHERE akses.id_project = '$id_project';"); ?>
                                                    <?php while ($nama_user = mysqli_fetch_array($users)) : ?>
                                                        <p> <?php echo $nama_user['nama_lengkap']; ?> </p> 
                                                    <?php endwhile; ?>
                                                </td>
                                                <td>
                                                    <!-- Tombol untuk edit data project -->
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?php echo $data['id_project']; ?>">
                                                        <i class="fas fa-edit mr-1"></i>Ubah
                                                    </button>
                                                    <!-- tombol untuk hapus data project -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_project']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                            <!-- modal hapus -->
                                            <div class="modal fade" id="delete<?php echo $data['id_project']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus User</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk hapus -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Menghapus <?= $data['nama_project']; ?> ?</p>
                                                                <input type="hidden" name="id_project" value="<?php echo $data['id_project']; ?>">
                                                                <br>
                                                                <button type="submit" class="btn btn-danger btn-lg btn-block" name="hapus">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

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
                                                                <div class="form-group">
                                                                    <label for="nama_cr">Nama CR</label>
                                                                    <input type="text" name="nama_cr" placeholder="Masukkan Nanam CR" class="form-control" id="nama_cr" value="<?= $data['nama_cr']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="no_cr">No CR</label>
                                                                    <input type="text" name="no_cr" placeholder="Masukkan No CR" class="form-control" id="no_cr" value="<?= $data['no_cr']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="customer_pic">Customer PIC</label>
                                                                    <input type="text" name="customer_pic" placeholder="Masukkan Nama PIC" class="form-control" id="customer_pic" value="<?= $data['customer_pic']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tanggal_diterima">Tanggal Diterima</label>
                                                                    <input type="date" name="tanggal_diterima" class="form-control" id="tanggal_diterima" value="<?= $data['tanggal_diterima']; ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tanggal_mulai">Tanggal mulai</label>
                                                                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai" value="<?= $data['tanggal_mulai']; ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tanggal_selesai">Tanggal selesai</label>
                                                                    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai" value="<?= $data['tanggal_selesai']; ?>" >
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="useredit">Nama User</label>
                                                                    <br>
                                                                    <select class="form-control multiple-select" id="useredit" name="useredit[]" multiple="multiple" >
                                                                        <?php
                                                                        // Query untuk menampilkan nama barang
                                                                        $user = mysqli_query($conn, "SELECT * FROM user WHERE level = 'operator'");

                                                                        if(mysqli_num_rows($user) > 0)
                                                                        {
                                                                            foreach($user as $row)
                                                                            {
                                                                                ?>
                                                                                    <option
                                                                                        value="<?=$row['id_user']?>"
                                                                                        <?= in_array($row['id_user'], $users_project) ? 'selected':''?>
                                                                                    >
                                                                                        <?=$row['nama_lengkap'] ?>
                                                                                    </option>
                                                                                <?php
                                                                            }   
                                                                        }

                                                                        ?>
                                                                    </select> 
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-warning btn-lg btn-block" name="edit">Edit</button>
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
                            <label for="no_cr">No CR</label>
                            <input type="text" name="no_cr" placeholder="Masukkan No CR" class="form-control" id="no_cr" required>
                        </div>
                        <div class="form-group">
                            <label for="customer_pic">Customer PIC</label>
                            <input type="text" name="customer_pic" placeholder="Masukkan Customer PIC" class="form-control" id="customer_pic" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_diterima">Tanggal Diterima</label>
                            <input type="date" name="tanggal_diterima" class="form-control" id="tanggal_diterima" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai">
                        </div>
                        <div class="form-group">
                            <label for="user">Nama User</label>
                            <br>
                            <select class="form-control multiple-select" id="user" name="user[]" multiple="multiple">
                                <?php
                                // Query untuk menampilkan nama user
                                $user = mysqli_query($conn, "SELECT * FROM user WHERE level = 'operator'");
                                while ($data = mysqli_fetch_array($user)) {
                                ?>
                                    <option value="<?php echo $data['id_user']; ?>"><?php echo $data['nama_lengkap']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $(".multiple-select").select2({
            // maximumSelectionLength: 2
            // placeholder: 'This is my placeholder',
            allowClear: true,
            closeOnSelect: false, 
            theme: "bootstrap"
        });
    </script>
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