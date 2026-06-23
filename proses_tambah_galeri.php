<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: tambah_galeri.php");
    exit();
}

$keterangan = trim($_POST['keterangan'] ?? '');
$kategori   = $_POST['kategori'] ?? 'sejarah';

if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    header("Location: tambah_galeri.php?error=" . urlencode('Foto wajib diisi'));
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

$stmt = mysqli_prepare($koneksi, "INSERT INTO galeri (gambar, keterangan, kategori) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'sss', $newFileName, $keterangan, $kategori);

if (mysqli_stmt_execute($stmt)) {
    header("Location: admin_galeri.php?msg=" . urlencode('Foto berhasil ditambahkan'));
} else {
    header("Location: tambah_galeri.php?error=" . urlencode('Gagal menyimpan ke database'));
}
mysqli_stmt_close($stmt);