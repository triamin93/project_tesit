<?php
    // Memanggil fungsi start session
    session_start();

    // memanggil fungsi program
    require 'functions.php';

    // Ambil data id di URL
    $id_project = $_GET["id_project"];

    // Queary data project berdasarkan id
    $project = mysqli_query($conn, "SELECT * FROM project WHERE id_project = $id_project");

    // mengambil data project
    $row_project = mysqli_fetch_assoc($project);

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
    <title>Data Test Script</title>
    <style>
        table thead tr th {
            text-align: center;
        }

        div.dataTables_wrapper {
        margin: 0 auto;
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
                        <a class="nav-link" href="../user/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            User
                        </a>
                        <!-- link Projek -->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayoutsFCC" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Projek
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsFCC" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="../project/index.php">Data Projek</a>
                                <a class="nav-link" href="index.php">Data Test Script</a>
                            </nav>
                        </div>
                        <!-- link Audit Trail -->
                        <a class="nav-link" href="../audit/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Audit Trail
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
                    <h1 class="mt-4">Rekaptulasi Test Script</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Detail Data Projek -->
                            <div class="table-responsive">
                                <table width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td><b>Nama Projek</b></td>
                                            <td>: <?php echo $row_project['nama_project']?></td>
                                            <td><b>Tanggal Terima</b></td>
                                            <td>: <?php echo dateIndonesian($row_project['tanggal_diterima'])?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nama CR</b></td>
                                            <td>: <?php echo $row_project['nama_cr']?></td>
                                            <td><b>Tanggal Mulai</b></td>
                                            <td>: <?php echo dateIndonesian($row_project['tanggal_mulai'])?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nomor CR</b></td>
                                            <td>: <?php echo $row_project['no_cr']?></td>
                                            <td><b>Tanggal Selesai</b></td>
                                            <td>: <?php echo dateIndonesian($row_project['tanggal_selesai'])?></td>
                                        </tr>
                                        <tr>
                                            <td><b>PIC</b></td>
                                            <td>: <?php echo $row_project['customer_pic']?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- Tombol Tambah File -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="fas fa-plus mr-1"></i>
                                Tambah File
                            </button>
                            <!-- Tombol upload File -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload" style="float: right;"><i class="fas fa-file-alt mr-1"></i>
                                Upload File
                            </button>
                        </div>
                        <div class="card-body">
                            <!-- Table Data projek -->
                            <div class="table-responsive">
                                <table class="table table-bordered display nowrap" id="dataTable" width="100%" cellspacing="0" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Excel</th>
                                            <th>Tanggal Buat / Upload</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // mengambil query data admin
                                            $project_testcase = mysqli_query($conn, "SELECT * FROM excel WHERE id_project = '$id_project'");
                                            $i = 1;

                                            // Pengulangan data admin
                                            while ($data = mysqli_fetch_array($project_testcase)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['nama_excel']; ?></td>
                                                <td><?= $data['tanggal_upload']; ?></td>
                                                <td>
                                                    <!-- Tombol untuk view data excel -->
                                                    <a class="btn btn-primary" href="view.php?tmp_excel=<?=$data['tmp_excel']?>" role="button"><i class="fas fa-eye mr-1"></i>View</a>

                                                    <!-- tombol untuk menghapus data project -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_excel']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Hapus
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Form Modal hapus -->
                                            <div class="modal fade" id="delete<?php echo $data['id_excel']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Projek</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Pesan untuk hapus projek -->
                                                        <form method="POST">
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin Menghapus Data Projek ?</p>
                                                                <p>Nama Projek:<b><?= $data['nama_project']; ?></b></p>
                                                                <p>Nomor CR:<b><?= $data['no_cr']; ?></b></p>
                                                                <p>PIC:<b><?= $data['customer_pic']; ?></b></p>
                                                                <input type="hidden" name="id_excel" value="<?php echo $data['id_excel']; ?>">
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

    <!-- Form Modal tambah -->
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah File Test Script</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form untuk tambah data projek -->
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaFile">Nama File</label>
                            <input type="text" name="id_project" value="<?php echo $row_project['id_project']; ?>">
                            <input type="text" name="namaFile" placeholder="Masukkan Nama File Baru" class="form-control" id="namaFile" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="tambahFile">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Modal upload -->
    <div class="modal fade" id="upload">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Upload Test Script</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form untuk tambah data projek dengan upload -->
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Upload File</label>
                            <input type="file" class="form-control-file" id="file" name="file">
                            <input type="hidden" name="id_project" value="<?php echo $row_project['id_project']; ?>">
                        </div>
                        <!-- Pakai Javascript -->
                        <!-- <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="upload_file">
                            <label class="custom-file-label" for="upload_file">Choose file</label>
                        </div> -->
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block" name="upload">Upload</button>
                    </div>
                </form>
            </div>
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
                ],
                scrollX: true
            });
        });
    </script>
</body>

</html>