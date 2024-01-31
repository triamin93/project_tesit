<?php
// Memanggil phpspreedsheet
require 'vendor/autoload.php';

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

//Coding untuk hapus data project
if (isset($_POST['hapus'])) {
    $id_project = $_POST['id_project'];

    // query untuk hapus data project
    $hapus_project = mysqli_query($conn, "DELETE FROM project WHERE id_project = '$id_project'");
    $hapus_akses = mysqli_query($conn, "DELETE FROM akses WHERE id_project = '$id_project'");

    if ($hapus_project&&$hapus_akses) {
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

// Coding untuk upload file
if(isset($_POST['upload'])){
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

    $ekstensiGambar = explode('.', $namaFile);

    // menamakan dan mengupload file
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensi;
    move_uploaded_file($tmpName, 'upload/' . $namaFileBaru);

    
}