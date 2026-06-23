<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? '';

if ($id === '' || !is_numeric($id)) {
    header("Location: admin_galeri.php");
    exit();
}

$stmt = mysqli_prepare($koneksi, "SELECT gambar FROM galeri WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $gambar);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($found) {
    $filePath = 'uploads_galeri/' . $gambar;
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    $stmt = mysqli_prepare($koneksi, "DELETE FROM galeri WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: admin_galeri.php?msg=" . urlencode('Foto berhasil dihapus'));
exit();