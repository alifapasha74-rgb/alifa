<?php
// File: projek_umkm/catat_pengunjung.php
// Include file ini di index.php user (beranda)
require_once 'koneksi.php';

$today = date('Y-m-d');
$stmt = mysqli_prepare($koneksi, "INSERT INTO pengunjung (tanggal, jumlah) VALUES (?, 1) ON DUPLICATE KEY UPDATE jumlah = jumlah + 1");
mysqli_stmt_bind_param($stmt, 's', $today);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
?>