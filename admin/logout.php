<?php
session_start();

// Mengkoneksikan database
$conn = mysqli_connect("localhost", "root", "", "testscript");

// Mengambil data session user dan membuat status logout
$username = $_SESSION["username"];

// Memanggil query user dan id_user
$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_assoc($result);
$id_user = $row["id_user"];

// Membuat status logout
$status = "Logout";

// Query untuk menyimpan 
$audit_logout = mysqli_query($conn, "INSERT audit_login (id_user, status) values('$id_user', '$status')");

// Menghapus Seluruh Session
$_SESSION = [];
session_unset();
session_destroy();

// Mengarahkan ke halaman login
header("location: ../index.php");
exit;
