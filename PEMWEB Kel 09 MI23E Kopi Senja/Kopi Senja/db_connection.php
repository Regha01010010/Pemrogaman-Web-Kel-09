<?php
// Pengaturan koneksi ke database
$host = "localhost";      // Host database, biasanya localhost
$username = "root";       // Username MySQL (sesuaikan dengan server Anda)
$password = "";           // Password MySQL (sesuaikan dengan server Anda)
$database = "web_cafe";    // Nama database yang sudah dibuat

// Membuat koneksi ke MySQL
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>