<?php
session_start();

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "testscript");

$username = $_SESSION["username"];

// jika tidak ada username yang masuk
if (!isset($_SESSION["username"])) {
    echo "
        <script>
            alert('Anda Harus Login Dulu!');
            document.location.href = '../index.php';
        </script>
        ";
    exit;
}

echo $username;

$level = $_SESSION["level"];

// // jika level bukan pegawai
if ($level != "operator") {
    echo "
        <script>
            alert('Anda tidak punya akses pada halaman Admin');
            document.location.href = 'logout.php';
        </script>
        ";
    exit;
}

// JUMLAH DATA
// Mengambil Data Projek pada user operator
$projek = mysqli_query($conn, "SELECT akses.id_project, akses.id_user, user.username FROM akses JOIN user ON akses.id_user = user.id_user
WHERE user.username = '$username'");
$jumlah_projek = mysqli_num_rows($projek);

// Mengambil Data Banyaknya Test Script
$testScript = mysqli_query($conn, "SELECT excel.nama_excel FROM excel JOIN project ON excel.id_project = project.id_project JOIN akses ON	 project.id_project = akses.id_project JOIN user ON akses.id_user = user.id_user WHERE user.username = '$username'");
$jumlah_testScript = mysqli_num_rows($testScript);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="assets/styles.css" rel="stylesheet" />
    <style>
        table thead tr th,
        td {
            text-align: center;
        }

        .display-4 {
            font-weight: bold;
        }

        .dashboard {
            font-weight: bold;
        }

        .card-body-icon {
            position: absolute;
            z-index: 0;
            top: 15px;
            right: 20px;
            opacity: 0.4;
            font-size: 80px;
        }
    </style>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <!-- headernya -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dashboard</a>
        <!-- Tombol untuk menampilkan dan menyembunyikan sidebar -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            <!-- Tombol logout -->
                <a class="btn btn-danger" href="logout.php" role="button"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
            </div>
        </form>
    </nav>
    <!-- sidebarnya -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <!-- link Dashboard -->
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <!-- link Projek -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsFCC" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Projek
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsFCC" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="project/index.php">Data Projek</a>
                                <a class="nav-link" href="testscript/index.php">Data Test Script</a>
                            </nav>
                        </div>
                        <!-- link Audit Trail -->
                        <a class="nav-link" href="audit/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Audit Trail
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- kontennya -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>
                    <div class="row">

                        <!-- Menampilkan total jumlah data barang -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-tasks"></i>
                                    </div>
                                    <div class="card-title">Project</div>
                                    <div class="display-4"><?php echo $jumlah_projek; ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Menampilkan total jumlah data barang Masuk -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="card-title">Test Script</div>
                                    <div class="display-4"><?php echo $jumlah_testScript; ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Menampilkan total jumlah data barang Keluar-->
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="card-title">Proses</div>
                                    <div class="display-4">22</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header bg-info">
                            <i class="fas fa-table mr-1"></i>
                            <b>Test Script yang tersedia</b>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Projek</th>
                                            <th>No CR</th>
                                            <th>Test Script</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Query mengambil data barang dengan stok kurang dari 5
                                        $testScriptUser = mysqli_query($conn, "SELECT excel.nama_excel, project.nama_project, project.no_cr FROM excel JOIN project ON excel.id_project = project.id_project JOIN akses ON project.id_project = akses.id_project JOIN user ON akses.id_user = user.id_user WHERE user.username = '$username' ORDER BY excel.id_excel DESC");
                                        $i = 1;
                                        // pengulangan menampilkan data
                                        while ($data = mysqli_fetch_array($testScriptUser)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_project']; ?></td>
                                                <td><?= $data['no_cr']; ?></td>
                                                <td><?= $data['nama_excel']; ?></td>
                                            </tr>
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
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });
        });
    </script>
</body>

</html>