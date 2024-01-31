<?php
    // Memanggil fungsi start session
    session_start();

    // memanggil fungsi program
    require 'functions.php';

    // Fungsi untuk mengecek session user
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
    <title>Audit Login</title>
    <style>
        table thead tr th {
            text-align: center;
        }
    </style>

    <!-- Memanggil CSS -->
    <link href="../assets/styles.css" rel="stylesheet" />

    <!-- CSS Datatable -->
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <!-- CSS Select2 -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" integrity="sha512-CbQfNVBSMAYmnzP3IC+mZZmYMP2HUnVkV4+PwuhpiMUmITtSpS7Prr3fNncV1RBOnWxzz4pYQ5EAGG4ck46Oig==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>

<body class="sb-nav-fixed">
    <!-- HEADER -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">TESIT</a>
        <!-- tombol untuk mengatur menu sidebar (menampilkan atau tidak menu side bar)-->
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
            <!-- tombol untuk logout -->
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
                    <!-- Semua tombol Menu -->
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
                        <a class="nav-link" href="../project/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Projek
                        </a>
                        <!-- link Audit Trail -->
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Audit Trail
                        </a>
                        <!-- link Test Script -->
                        <a class="nav-link" href="../testscript/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Test Script
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <!-- KONTEN -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <!-- Header nama tampilan konten -->
                    <h1 class="mt-4">Rekapitulasi Projek</h1>
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
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // mengambil query data admin
                                            $audit = mysqli_query($conn, "SELECT user.username, audit_login.status, audit_login.time FROM audit_login JOIN user ON audit_login.id_user = user.id_user");
                                            $i = 1;

                                            // Pengulangan data admin
                                            while ($data = mysqli_fetch_array($audit)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['username']; ?></td>
                                                <td><?= $data['status']; ?></td>
                                                <td><?= dateIndonesian($data['time']) . " " . date_format(date_create($data['time']), "H:i:s"); ?></td>
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

    <!-- Library JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <!-- Library Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Library File JS -->
    <script src="../assets/scripts.js"></script>

    <!-- Library Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <!-- Library Datatable -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

    <!-- Library Select2 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <!-- Script Select2 -->
    <script>
        $(".multiple-select").select2({
            // maximumSelectionLength: 2
            // placeholder: 'This is my placeholder',
            allowClear: true,
            closeOnSelect: false, 
            theme: "bootstrap"
        });
    </script>

    <!-- Script Datatable -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable({
                // Bahasa DataTable : Bahasa Indonesia
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
                },
                dom: 'Bfrtip',
                // Tombol di Datatabel
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'collection',
                        className: 'custom-html-collection',
                        buttons: [
                            '<h6 class="not-top-heading">Column Visibility</h6>',
                            'columnsToggle'
                        ]
                    },
                    'pageLength'
                ]
            });
        });
    </script>
</body>

</html>