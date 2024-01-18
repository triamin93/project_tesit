<?php
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

// Coding untuk tambah data adminn
if (isset($_POST['tambah'])) {
    $nama_projek = $_POST['nama_projek'];
    $nama_cr = $_POST['nama_cr'];
    $no_cr = $_POST['no_cr'];
    $customer_pic = $_POST['customer_pic'];
    $tanggal_diterima = $_POST['tanggal_diterima'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $users = $_POST['user'];

    // Query Tambah Projek (Sukses)
    $tambah_projek = mysqli_query($conn, "INSERT INTO project (nama_project, nama_cr, no_cr, customer_pic, tanggal_diterima, tanggal_mulai, tanggal_selesai) values('$nama_projek', '$nama_cr', '$no_cr', '$customer_pic', '$tanggal_diterima', '$tanggal_mulai', '$tanggal_selesai')");

    // mengambil data id_project terbaru
    $project = mysqli_query($conn, "SELECT id_project FROM project ORDER BY id_project DESC");
    $data = mysqli_fetch_array($project);
    $first_id = $data['id_project'];

    // Query Tambah Akses
    foreach ($users as $user) {
        $tambah_akses = mysqli_query($conn, "INSERT INTO akses (id_project, id_user) VALUES ('$first_id', '$user')");
    }

    if ($tambah_projek&&$tambah_akses) {
        echo "
        <script>
            alert('Data Berhasil Ditambahkan!');
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

// Coding untuk edit data admin
// if (isset($_POST['edit'])) {
//     $id_project = $_POST['id_project'];
//     $nama_projek = $_POST['nama_projek'];
//     $nama_cr = $_POST['nama_cr'];
//     $menu = $_POST['menu'];

//     // Query untuk edit data
//     $edit_projek = mysqli_query($conn, "UPDATE project set nama_project = '$nama_projek', nama_cr = '$nama_cr', menu = '$menu' WHERE id_project = '$id_project'");
//     if ($edit_projek) {
//         echo "
//         <script>
//             alert('Data Berhasil Diedit!');
//             document.location.href = 'index.php';
//         </script>
//         ";
//     } else {
//         echo "
//         <script>
//             alert('Data Gagal Diedit!');
//             document.location.href = 'index.php';
//         </script>
//         ";
//     }
// }
