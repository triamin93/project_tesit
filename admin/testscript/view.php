<?php
    // Memanggil phpspreedsheet
    require 'vendor/autoload.php';

    // Memanggil fungsi start session
    session_start();

    // memanggil fungsi program
    require 'functions.php';

    // Ambil data id di URL
    $tmp_excel = $_GET["tmp_excel"];

    // Queary data project berdasarkan id
    $excel = mysqli_query($conn, "SELECT excel.nama_excel, excel.tmp_excel, excel.tanggal_upload, project.id_project, project.nama_project, project.no_cr, project.customer_pic FROM excel JOIN project ON excel.id_project = project.id_project WHERE excel.tmp_excel = '$tmp_excel'");
    
    // mengambil data project
    $data_excel = mysqli_fetch_assoc($excel);

    // mengambil id project
    $id_project = $data_excel['id_project'];

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
    <title>View Test Script</title>
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
                    <h1 class="mt-4">Test Script</h1>

                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Detail Data Projek -->
                            <div class="table-responsive">
                                <table width="100%" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td><b>Nama Projek</b></td>
                                            <td>: <?php echo $data_excel['nama_project']?></td>
                                            <td><b>Nama Test Script</b></td>
                                            <td>: <?php echo $data_excel['nama_excel']?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nomor CR</b></td>
                                            <td>: <?php echo $data_excel['no_cr']?></td>
                                            <td><b>Tanggal Upload</b></td>
                                            <td>: <?php echo dateIndonesian($data_excel['tanggal_upload'])?></td>
                                        </tr>
                                        <tr>
                                            <td><b>PIC</b></td>
                                            <td>: <?php echo $data_excel['customer_pic']?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Table Data projek -->
                            <div class="table-responsive">
                                <table class="table table-bordered display nowrap" id="dataTable" width="100%" cellspacing="0" >
                                    <?php 
                                        // Ambil direktori excel
                                        $inputFileName = '../../upload/'. $tmp_excel;

                                        // Create and Load Spreadsheet
                                        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                                        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                                        $spreadsheet = $reader->load($inputFileName);
                                        $sheetData = $spreadsheet->getActiveSheet()->toArray();
                                        // echo count($sheetData);

                                        // Ambil head dalam table
                                        $headTestDate       = $sheetData['0']['0'];
                                        $headPIC            = $sheetData['0']['1'];
                                        $headTestCaseID     = $sheetData['0']['2'];
                                        $headModul          = $sheetData['0']['3'];
                                        $headFeature        = $sheetData['0']['4'];
                                        $headTestCase       = $sheetData['0']['5'];
                                        $headTestType       = $sheetData['0']['6'];
                                        $headPrecondition   = $sheetData['0']['7'];
                                        $headTestStep       = $sheetData['0']['8'];
                                        $headTestData       = $sheetData['0']['9'];
                                        $headExpectedResult = $sheetData['0']['10'];
                                        $headTCWebStatus    = $sheetData['0']['11'];
                                        $headSeverity       = $sheetData['0']['12'];
                                        $headNotes          = $sheetData['0']['13'];
                                        $headTCWebCapture   = $sheetData['0']['14'];
                                    ?>
                                    <!-- Menampilkan isi Header -->
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th><?= $headTestDate;?></th>
                                            <th><?= $headPIC;?></th>
                                            <th><?= $headTestCaseID;?></th>
                                            <th><?= $headModul;?></th>
                                            <th><?= $headFeature;?></th>    
                                            <th><?= $headTestCase;?></th>
                                            <th><?= $headTestType;?></th>
                                            <th><?= $headPrecondition;?></th>
                                            <th><?= $headTestStep;?></th>
                                            <th><?= $headTestData;?></th>
                                            <th><?= $headExpectedResult;?></th>
                                            <th><?= $headTCWebStatus;?></th>
                                            <th><?= $headSeverity;?></th>
                                            <th><?= $headNotes;?></th>
                                            <th><?= $headTCWebCapture;?></th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            for($i=1;$i<count($sheetData);$i++): 
                                            // Mengambil nilai row di excel 
                                            $rowTestDate         = $sheetData[$i]['0'];
                                            $rowPIC              = $sheetData[$i]['1'];
                                            $rowTestCaseID       = $sheetData[$i]['2'];
                                            $rowModul            = $sheetData[$i]['3'];
                                            $rowFeature          = $sheetData[$i]['4'];
                                            $rowTestCase         = $sheetData[$i]['5'];
                                            $rowTestType         = $sheetData[$i]['6'];
                                            $rowPrecondition     = $sheetData[$i]['7'];
                                            $rowTestStep         = $sheetData[$i]['8'];
                                            $rowTestData         = $sheetData[$i]['9'];
                                            $rowExpectedResult   = $sheetData[$i]['10'];
                                            $rowTCWebStatus      = $sheetData[$i]['11'];
                                            $rowSeverity         = $sheetData[$i]['12'];
                                            $rowNotes            = $sheetData[$i]['13'];
                                            $rowTCWebCapture     = $sheetData[$i]['14'];
                                        ?>
                                        <tr>
                                            <td><?= $i;?></td>
                                            <td><?= $rowTestDate;?></td>
                                            <td><?= $rowPIC;?></td>
                                            <td><?= $rowTestCaseID;?></td>
                                            <td><?= $rowModul;?></td>
                                            <td><?= $rowFeature;?></td>
                                            <td><?= $rowTestCase;?></td>
                                            <td><?= $rowTestType;?></td>
                                            <td><?= $rowPrecondition;?></td>
                                            <td><?= $rowTestStep;?></td>
                                            <td><?= $rowTestData;?></td>
                                            <td><?= $rowExpectedResult;?></td>
                                            <td><?= $rowTCWebStatus;?></td>
                                            <td><?= $rowSeverity;?></td>
                                            <td><?= $rowNotes;?></td>
                                            <td><?= $rowTCWebCapture;?></td>
                                            <td>
                                                <!-- Tombol untuk edit data isi excel -->
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$i; ?>">
                                                        <i class="fas fa-edit mr-1"></i>Ubah
                                                    </button>

                                                    <!-- tombol untuk hapus data isi excel -->
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?php echo $data['id_project']; ?>">
                                                        <i class="fas fa-trash-alt mr-1"></i>Hapus
                                                    </button>
                                            </td>
                                        </tr>

                                        <!-- Form Modal hapus -->
                                        <div class="modal fade" id="delete<?php echo $data['id_project']; ?>">
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
                                        <div class="modal fade" id="edit<?=$i; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Test Script</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <!-- Form untuk edit data test script -->
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="cellRow" value="<?=$i; ?>">
                                                            <input type="hidden" name="tmp" value="<?=$tmp_excel; ?>">

                                                            <div class="form-group">
                                                                <label for="testDate">Test Date</label>
                                                                <input type="date" name="testDate" class="form-control" id="testDate" value="<?= $rowTestDate; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="pic">PIC</label>
                                                                <br>
                                                                <select class="form-control" id="pic" name="pic">
                                                                    <?php
                                                                    // Query untuk menampilkan nama user
                                                                        $user = mysqli_query($conn, "SELECT nama_lengkap FROM user JOIN akses ON user.id_user = akses.id_user JOIN project ON akses.id_project = project.id_project WHERE akses.id_project = '$id_project' ORDER BY nama_lengkap ASC;");
                                                                        // Pengulangan untuk menampilkan data user
                                                                        while ($data = mysqli_fetch_array($user)) :
                                                                    ?>
                                                                            <option value="<?php echo $data['nama_lengkap']; ?>"><?php echo $data['nama_lengkap']; ?></option>
                                                                    <?php
                                                                        endwhile;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="testCaseID">Test Case ID</label>
                                                                <input type="text" name="testCaseID" class="form-control" id="testCaseID" value="<?= $rowTestCaseID; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="module">Module</label>
                                                                <input type="text" name="module" placeholder="Masukkan Module" class="form-control" id="module" value="<?= $rowModul; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="feature">Feature</label>
                                                                <input type="text" name="feature" placeholder="Masukkan Feature" class="form-control" id="feature" value="<?= $rowFeature; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="testCase">Test Case</label>
                                                                <input type="text" name="testCase" placeholder="Masukkan Test Case" class="form-control" id="testCase" value="<?= $rowTestCase; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="testType">Test Type</label>
                                                                <input type="text" name="testType" placeholder="Masukkan Test Type" class="form-control" id="testType" value="<?= $rowTestType; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="preCondition">Pre Condition</label>
                                                                <input type="text" name="preCondition" placeholder="Masukkan Pre Condition" class="form-control" id="preCondition" value="<?= $rowPrecondition; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="testStep">Test Step</label>
                                                                <input type="text" name="testStep" placeholder="Masukkan Test Step" class="form-control" id="testStep" value="<?= $rowTestStep; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="testData">Test Data</label>
                                                                <input type="text" name="testData" placeholder="Masukkan Test Data" class="form-control" id="testData" value="<?= $rowTestData; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="expectedResult">Expected Result</label>
                                                                <input type="text" name="expectedResult" placeholder="Masukkan Expected Result" class="form-control" id="expectedResult" value="<?= $rowExpectedResult; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tcWebStatus">TC Web Status</label>
                                                                <input type="text" name="tcWebStatus" class="form-control" id="tcWebStatus" value="<?= $rowTCWebStatus; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="severity">Severity</label>
                                                                <input type="text" name="severity" class="form-control" id="severity" value="<?= $rowSeverity; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="notes">Notes</label>
                                                                <input type="text" name="notes" class="form-control" id="notes" value="<?= $rowNotes; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tcWebCapture">TC Web Capture</label>
                                                                <input type="text" name="tcWebCapture" class="form-control" id="tcWebCapture" value="<?= $rowTCWebCapture; ?>" required>
                                                            </div>
                                                            <br>
                                                            <button type="submit" class="btn btn-warning btn-lg btn-block" name="editRow">Edit</button>
                                                        </div>
                                                    </form> 
                                                </div>
                                            </div>
                                        </div>    
                                        <?php
                                            endfor;
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
                ],
                scrollX: true
            });
        });
    </script>
</body>

</html>