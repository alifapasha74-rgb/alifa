<?php
session_start();
require 'koneksi.php';
 
// semua user yang udah login boleh tambah foto (gak perlu level admin)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_galeri.php");
    exit();
}
 
$nama_produk = trim($_POST['nama_produk'] ?? '');
$harga       = $_POST['harga'] ?? '';
$deskripsi   = trim($_POST['deskripsi'] ?? '');
 
if ($nama_produk === '' || $harga === '' || !is_numeric($harga) || !isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    header("Location: tambah_galeri.php?error=" . urlencode('Nama produk, harga, dan foto wajib diisi'));
    exit();
}
 
$fileTmp  = $_FILES['foto']['tmp_name'];
$fileName = $_FILES['foto']['name'];
$ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
 
$allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
if (!in_array($ext, $allowedExt)) {
    header("Location: tambah_galeri.php?error=" . urlencode('Format file harus jpg, jpeg, png, gif, atau webp'));
    exit();
}
 
$uploadDir = 'uploads_galeri/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
 
$newFileName = uniqid('foto_') . '.' . $ext;
$targetPath  = $uploadDir . $newFileName;
 
if (!move_uploaded_file($fileTmp, $targetPath)) {
    header("Location: tambah_galeri.php?error=" . urlencode('Gagal upload foto, coba lagi'));
    exit();
}
 
$stmt = mysqli_prepare($koneksi, "INSERT INTO galeri (nama_produk, harga, gambar, deskripsi) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'siss', $nama_produk, $harga, $newFileName, $deskripsi);
 
if (mysqli_stmt_execute($stmt)) {
    header("Location: galeri.php?msg=" . urlencode('Foto berhasil ditambahkan'));
} else {
    header("Location: tambah_galeri.php?error=" . urlencode('Gagal menyimpan ke database'));
}
mysqli_stmt_close($stmt);