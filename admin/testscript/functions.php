<?php
// Memanggil phpspreedsheet
require 'vendor/autoload.php';

// Load phpspreadsheet class using namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// Call phpspreadsheet IOfactory
use PhpOffice\PhpSpreadsheet\IOFactory;
// Call xlxs writer class to make an xlsx file
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "testscript");

// fungsi tanggal dan waktu indonesia
function dateIndonesian($date)
{
    $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $date  = strtotime($date);
    $hari  = $array_hari[date('N', $date)];
    $tanggal = date('j', $date);
    $bulan = $array_bulan[date('n', $date)];
    $tahun = date('Y', $date); 
    $formatTanggal = $hari . ", " . $tanggal . " " . $bulan . " " . $tahun;
    return $formatTanggal;
}

// Coding untuk upload file
if(isset($_POST['upload'])){
    // mengambil ID Project
    $id_project = $_POST['id_project'];

    // isi file
    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];

    // Mengecek untuk melihat file kosong
    if(empty($namaFile)){
        $err .= "<li>Silakan masukkan file yang kamu inginkan</li>";
    }else{
        $ekstensi = pathinfo($namaFile)['extension'];
        $namaFileDepan = pathinfo($namaFile)['filename'];
    }

    $ekstensiValid = ['xls', 'xlsx'];
    
    // Mengecek untuk cek file ekstensi excel
    if (!in_array($ekstensi, $ekstensiValid)){
        echo "<script>
                alert('yang anda upload bukan excel <b>$namaFile</b> punya tipe <b>$ekstensi</b>');
              </script>";
    }

    // $ekstensiGambar = explode('.', $namaFile);

    // menamakan dan mengupload file
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensi;
    move_uploaded_file($tmpName, '../../upload/' . $namaFileBaru);

    // memasukan ke dalam database
    $simpanFile = mysqli_query($conn, "INSERT INTO excel (id_project, nama_excel, tmp_excel, tanggal_upload) values('$id_project', '$namaFile', '$namaFileBaru', NOW())");

    // masukkan kodingan id project
    if ($simpanFile > 0) {
        echo "
        <script>
            alert('Data Berhasil Ditambahkan!');
            // document.location.href = 'testScript.php?id_project='$id_project';
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

// coding untuk membuat file baru
if(isset($_POST['tambahFile'])){
    // Mengambil nilai post yang ke hidden
    $id_project = $_POST['id_project'];

    // Mengambil nilai post yang di input
    $namaFile = $_POST['namaFile'];

    // Membuat file baru
    $spreadsheet = new Spreadsheet();
    // mendapatkan sheet yang aktif
    $sheet = $spreadsheet->getActiveSheet();
    // mengisi value setiap cell
    $sheet->setCellValue('A1', 'Test Date');
    $sheet->setCellValue('B1', 'PIC');
    $sheet->setCellValue('C1', 'Test Case ID');
    $sheet->setCellValue('D1', 'Modul');
    $sheet->setCellValue('E1', 'Feature');
    $sheet->setCellValue('F1', 'Test Case');
    $sheet->setCellValue('G1', 'Test Type');
    $sheet->setCellValue('H1', 'Pre-Condition');
    $sheet->setCellValue('I1', 'Test Step');
    $sheet->setCellValue('J1', 'Test Data');
    $sheet->setCellValue('K1', 'Expected Result');
    $sheet->setCellValue('L1', 'TC Web Status');
    $sheet->setCellValue('M1', 'Severity');
    $sheet->setCellValue('N1', 'Notes');
    $sheet->setCellValue('O1', 'TC Web Status');

    // Membuat ekstensi
    $ekstensi = 'xlsx';

    // Menamakan nama file 
    $namaFile .= '.';
    $namaFile .= $ekstensi;

    // menamakan dan mengupload file tmp
    $tmpFile = uniqid();
    $tmpFile .= '.';
    $tmpFile .= $ekstensi;

    // menulis excel dengan ekstensi xlsx
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    // variabel untuk menyimpan data
    $inputFileName = '../../upload/'. $tmpFile;
    // $inputFileName = 'helloworld.xlsx';
    // menyimpan hasil excel ke dalam folder
    $writer->save($inputFileName);

    // memasukan ke dalam database
    $simpanFile = mysqli_query($conn, "INSERT INTO excel (id_project, nama_excel, tmp_excel, tanggal_upload) values('$id_project', '$namaFile', '$tmpFile', NOW())");

}

// Coding untuk hapus file test script
if(isset($_POST['hapusFile'])){
    // Mengambil nilai post yang ke hidden
    $id_excel = $_POST['id_excel'];
    $tmp_excel = $_POST['tmp_excel'];

    // Ambil direktori excel
    $inputFileName = '../../upload/'. $tmp_excel;

    // Create and Load Spreadsheet
    $inputFileType = IOFactory::identify($inputFileName);
    $reader = IOFactory::createReader($inputFileType);
    $spreadsheet = $reader->load($inputFileName);

    // delete file
    unlink($inputFileName); 

    $hapusFile = mysqli_query($conn, "DELETE FROM excel WHERE id_excel = '$id_excel'");
}

// Coding untuk tambah row test script
if(isset($_POST['tambahRow'])){

}

// Coding untuk mengedit data row excel
if(isset($_POST['editRow'])){
    // Mengambil nilai post yang hidden
    $cellRow = $_POST['cellRow'];
    $tmp_excel = $_POST['tmp'];

    // Mengambil nilai post yang di input
    $testDate = $_POST['testDate'];
    $pic = $_POST['pic'];
    $testCaseID = $_POST['testCaseID'];
    $module = $_POST['module'];
    $feature = $_POST['feature'];
    $testCase = $_POST['testCase'];
    $testType = $_POST['testType'];
    $preCondition = $_POST['preCondition'];
    $testStep = $_POST['testStep'];
    $testData = $_POST['testData'];
    $expectedResult = $_POST['expectedResult'];
    $tcWebStatus = $_POST['tcWebStatus'];
    $severity = $_POST['severity'];
    $notes = $_POST['notes'];
    $tcWebCapture = $_POST['tcWebCapture'];

    // Menambahkan nilai cell row agar sesuai dengan inputan
    $cellRow++;

    // Ambil direktori excel
    $inputFileName = '../../upload/'. $tmp_excel;

    // Create and Load Spreadsheet
    $inputFileType = IOFactory::identify($inputFileName);
    $reader = IOFactory::createReader($inputFileType);
    $spreadsheet = $reader->load($inputFileName);
    $sheetData = $spreadsheet->getActiveSheet(); 

    // Set value
    $sheetData->setCellValue([1, $cellRow], $testDate);
    $sheetData->setCellValue([2, $cellRow], $pic);
    $sheetData->setCellValue([3, $cellRow], $testCaseID);
    $sheetData->setCellValue([4, $cellRow], $module);
    $sheetData->setCellValue([5, $cellRow], $feature);
    $sheetData->setCellValue([6, $cellRow], $testCase);
    $sheetData->setCellValue([7, $cellRow], $testType);
    $sheetData->setCellValue([8, $cellRow], $preCondition);
    $sheetData->setCellValue([9, $cellRow], $testStep);
    $sheetData->setCellValue([10, $cellRow], $testData);
    $sheetData->setCellValue([11, $cellRow], $expectedResult);
    $sheetData->setCellValue([12, $cellRow], $tcWebStatus);
    $sheetData->setCellValue([13, $cellRow], $severity);
    $sheetData->setCellValue([14, $cellRow], $notes);
    $sheetData->setCellValue([15, $cellRow], $tcWebCapture);

    // Write Excel
    $writer = IOFactory::createWriter($spreadsheet, $inputFileType);
    // save into php output
    $writer->save($inputFileName);
    
    echo "<script>
    alert('Data Berhasil Dihapus');
    </script>";
}

//Coding untuk hapus data project
if (isset($_POST['hapus'])) {
    $id_project = $_POST['id_project'];

    // query untuk hapus data project
    $hapus_project = mysqli_query($conn, "DELETE FROM project WHERE id_project = '$id_project'");
    $hapus_akses = mysqli_query($conn, "DELETE FROM akses WHERE id_project = '$id_project'");

    if ($hapus_project && $hapus_akses) {
        echo "
        <script>
            alert('Data Berhasil Dihapus!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Dihapus!');
            document.location.href = 'index.php';
        </script>
        ";
    }
}

