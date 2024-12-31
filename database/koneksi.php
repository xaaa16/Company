<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "agency";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa koneksi
if (mysqli_connect_errno()) {
    die("Connection failed! " . mysqli_connect_error());
}

// Jika koneksi berhasil
echo "Connection successful!";
?>
