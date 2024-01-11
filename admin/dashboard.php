<?php
session_start();

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "testscript");

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

$level = $_SESSION["level"];

// jika level bukan pemilik toko (Super Admin)
if ($level != "admin") {
    echo "
        <script>
            alert('Anda tidak punya akses pada halaman admin');
            document.location.href = 'logout.php';
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
    <title>Dashboard Admin</title>
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
        <a class="navbar-brand" href="#">TESIT</a>
        <!-- tombol menampilkan dan menyembunyikan sidebar  -->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            <!-- Tombol logout -->
                <a class="btn btn-danger" href="logout.php" role="button"><i class="fas fa-sign-out-alt"></i>&nbsp;Keluar</a>
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
                        <!-- link admin -->
                        <a class="nav-link" href="admin/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            User
                        </a>
                        <!-- link Projek -->
                        <a class="nav-link" href="project/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Projek
                        </a>
                        <!-- link akses -->
                        <a class="nav-link" href="akses/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Akses
                        </a>
                        <!-- link Menu FCC -->
                        <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsFCC" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            FCC
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsFCC" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="bank_group/index.php">Bank Group</a>
                                <a class="nav-link" href="bank_admin/index.php">Bank Admin</a>
                                <a class="nav-link" href="client_admin/index.php">Client Admin</a>
                            </nav>
                        </div> -->
                        <!-- link Menu FTI -->
                        <!-- <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsFTI" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                            FTI
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsFTI" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="xxx/index.php">XXX</a>
                                <a class="nav-link" href="xxx/index.php">XXX</a>
                                <a class="nav-link" href="xxx/index.php">XXX</a>
                            </nav>
                        </div> -->
                    </div>
                </div>
            </nav>
        </div>
        <!-- kontennya -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard Admin</h1>
                    <div class="row">
                        <!-- Total data Admin -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="card-title">XXX</div>
                                    <!-- <div class="display-4"><?php echo $jumlah_admin; ?></div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Total Data Barang -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <div class="card-title">XXX</div>
                                    <!-- <div class="display-4"><?php echo $jumlah_barang; ?></div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Total Data Barang Masuk -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div class="card-title">XXX</div>
                                    <!-- <div class="display-4"><?php echo $jumlah_barangmasuk; ?></div> -->
                                </div>
                            </div>
                        </div>
                        <!-- Total Data Barang Keluar -->
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body dashboard">
                                    <div class="card-body-icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <div class="card-title">XXX</div>
                                    <!-- <div class="display-4"><?php echo $jumlah_barangkeluar; ?></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table Untuk Stok Barang Sedikit atau Habis -->
                    <div class="card mb-4">
                        <div class="card-header bg-info">
                            <i class="fas fa-table mr-1"></i>
                            <b>Test Script yang Tersedia</b>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Projek</th>
                                            <th>Menu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <?php
                                        // Query mengambil data barang dengan stok kurang dari 5
                                        $barang = mysqli_query($conn, "SELECT * FROM barang WHERE stok < 5 ORDER BY nama_barang ASC");
                                        $i = 1;
                                        // pengulangan menampilkan data
                                        while ($data = mysqli_fetch_array($barang)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_barang']; ?></td>
                                                <td><?= $data['stok']; ?></td>
                                            </tr>
                                        <?php
                                        endwhile;
                                        ?> -->
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
                // DataTable Bahasa Indonesia
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                }
            });
        });
    </script>
</body>

</html>