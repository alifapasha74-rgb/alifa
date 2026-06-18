<?php
session_start();
require 'koneksi.php';
 
// semua user yang udah login boleh hapus foto (gak perlu level admin)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
 
$id = $_POST['id'] ?? '';
 
if ($id === '' || !is_numeric($id)) {
    header("Location: galeri.php");
    exit();
}
 
// ambil nama file foto dulu biar bisa dihapus dari folder juga
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
 
header("Location: galeri.php?msg=" . urlencode('Foto berhasil dihapus'));
exit();
 