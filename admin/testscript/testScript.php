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
    <title>Rekapitulasi Projek</title>
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
                        <a class="nav-link" href="../admin/index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            User
                        </a>
                        <!-- link projek -->
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Projek
                        </a>
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
                    <h1 class="mt-4">Test Script</h1>

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
                                            <th>Excel</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // mengambil query data admin
                                            $project_testcase = mysqli_query($conn, "SELECT * FROM testscript WHERE id_project = '$id_project'");
                                            $i = 1;

                                            // Pengulangan data admin
                                            while ($data = mysqli_fetch_array($project_testcase)) :
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $data['test_date'] ?></td>
                                                <td>
                                                    <!-- tombol untuk melihat data project -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_test_script']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Hapus
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Form Modal hapus -->
                                            <div class="modal fade" id="delete<?php echo $data['id_test_script']; ?>">
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
                                                                <input type="hidden" name="id_project" value="<?php echo $data['id_project']; ?>">
                                                                <br>
                                                                <button type="submit" class="btn btn-danger btn-lg btn-block" name="hapus">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Modal edit -->
                                            <div class="modal fade" id="edit<?php echo $data['id_test_script']; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Projek</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <!-- Form untuk edit data projek -->
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
                                                                        // Query untuk menampilkan nama user
                                                                        $user = mysqli_query($conn, "SELECT * FROM user WHERE level = 'operator' ORDER BY nama_lengkap ASC");

                                                                        // Kondisi untuk mengecek datanya ada atau tidak
                                                                        if(mysqli_num_rows($user) > 0):
                                                                            // Pengulangan untuk menampilkan nama user
                                                                            foreach($user as $row):
                                                                                ?>
                                                                                    <option
                                                                                        value="<?=$row['id_user']?>"
                                                                                        <?= in_array($row['id_user'], $users_project) ? 'selected':''?>
                                                                                    >
                                                                                        <?=$row['nama_lengkap'] ?>
                                                                                    </option>
                                                                                <?php
                                                                            endforeach;
                                                                        endif;
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

    <!-- Form Modal tambah -->
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Test Script</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <!-- Form untuk tambah data projek -->
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="test_date">Test Date</label>
                            <input type="date" name="test_date" class="form-control" id="test_date" required>
                        </div>
                        <!-- Dibuat Select mengambil data query -->
                        <div class="form-group">
                            <label for="pic">PIC</label>
                            <select class="form-control" name="pic" id="pic">
                                <?php
                                    // Query untuk menampilkan nama user
                                        $user_pic = mysqli_query($conn, "SELECT user.nama_lengkap, user.id_user FROM user JOIN akses ON user.id_user = akses.id_user JOIN project ON akses.id_project = project.id_project WHERE akses.id_project = '$id_project';");
                                        // pengulangan untuk menampilkan data user
                                        while ($data_pic = mysqli_fetch_array($user_pic)) :
                                ?>
                                            <option value="<?php echo $data_pic['id_user']; ?>"><?php echo $data_pic['nama_lengkap']; ?></option>
                                <?php
                                    endwhile;
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="test_case_id">Test Case ID</label>
                            <input type="text" name="test_case_id" placeholder="Masukkan Test Case ID" class="form-control" id="test_case_id" required>
                        </div>
                        <div class="form-group">
                            <label for="module">Module</label>
                            <input type="text" name="module" placeholder="Masukkan Module" class="form-control" id="module" required>
                        </div>
                        <div class="form-group">
                            <label for="feature">Feature</label>
                            <input type="text" name="feature" placeholder="Masukkan Feature" class="form-control" id="feature" required>
                        </div>
                        <div class="form-group">
                            <label for="test_case">Test Case</label>
                            <input type="text" name="test_case" placeholder="Masukkan Test Case" class="form-control" id="test_case" required>
                        </div>
                        <div class="form-group">
                            <label for="test_type">Test Type</label>
                            <select class="form-control" name="test_type" id="test_type">
                                <option value="positif">Positif</option>
                                <option value="negatif">Negatif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="precondition">Pre-Condition</label>
                            <input type="text" name="precondition" placeholder="Masukkan Pre-Condition" class="form-control" id="precondition" required>
                        </div>
                        <div class="form-group">
                            <label for="test_step">Test Step</label>
                            <input type="text" name="test_step" placeholder="Masukkan Test Step" class="form-control" id="test_step" required>
                        </div>
                        <div class="form-group">
                            <label for="test_data">Test Data</label>
                            <input type="text" name="test_data" placeholder="Masukkan Test Data" class="form-control" id="test_data" required>
                        </div>
                        <div class="form-group">
                            <label for="expected_result">Expected Result</label>
                            <input type="text" name="expected_result" placeholder="Masukkan Expected Result" class="form-control" id="expected_result" required>
                        </div>
                        <!-- dibuat select -->
                        <div class="form-group">
                            <label for="tc_web_status">TC Web Status</label>
                            <select class="form-control" name="tc_web_status" id="tc_web_status">
                                <option value="not tested">Not Tested</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="on tested">On Testing</option>
                            </select>
                        </div>
                        <!-- dibuat select -->
                        <div class="form-group">
                            <label for="severity">Severity</label>
                            <select class="form-control" name="severity" id="severity">
                                <option value="none">None</option>
                                <option value="showstopper">Showstopper</option>
                                <option value="blocker">Blocker</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <input type="text" name="note" placeholder="Masukkan Note" class="form-control" id="note" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="tambah">Tambah</button>
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
                        </div>
                        <!-- Pakai Javascript -->
                        <!-- <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="upload_file">
                            <label class="custom-file-label" for="upload_file">Choose file</label>
                        </div> -->
                        <br>
                        <button type="submit" class="btn btn-success btn-lg btn-block" name="upload">Upload</button>
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
                // scrollX: true
            });
        });
    </script>
</body>

</html>