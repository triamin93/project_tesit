<?php
session_start();

// Mengkoneksikan database
$conn = mysqli_connect("localhost", "root", "", "testscript");

// Mengambil data session user dan membuat status logout
$username = $_SESSION["username"];
$status = "Logout";

echo $username;

// Memanggil query user dan id_user
$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_assoc($result);
$id_user = $row["id_user"];

echo $id_user;

?>