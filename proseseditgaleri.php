<?php
session_start();
require 'koneksi.php';
 
// semua user yang udah login boleh edit foto (gak perlu level admin)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: galeri.php");
    exit();
}
 
$id          = $_POST['id'] ?? '';
$nama_produk = trim($_POST['nama_produk'] ?? '');
$harga       = $_POST['harga'] ?? '';
$deskripsi   = trim($_POST['deskripsi'] ?? '');
 
if ($id === '' || !is_numeric($id) || $nama_produk === '' || $harga === '' || !is_numeric($harga)) {
    header("Location: edit_galeri.php?id=$id&error=" . urlencode('Nama produk dan harga wajib diisi dengan benar'));
    exit();
}
 
$uploadDir  = 'uploads_galeri/';
$gambarBaru = null;
 
// kalau ada foto baru yang diupload, proses ganti file
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fileTmp  = $_FILES['foto']['tmp_name'];
    $fileName = $_FILES['foto']['name'];
    $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
 
    if (!in_array($ext, $allowedExt)) {
        header("Location: edit_galeri.php?id=$id&error=" . urlencode('Format file harus jpg, jpeg, png, gif, atau webp'));
        exit();
    }
 
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
 
    $newFileName = uniqid('foto_') . '.' . $ext;
    if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
        $gambarBaru = $newFileName;
 
        // hapus file foto lama biar gak numpuk
        $stmtOld = mysqli_prepare($koneksi, "SELECT gambar FROM galeri WHERE id = ?");
        mysqli_stmt_bind_param($stmtOld, 'i', $id);
        mysqli_stmt_execute($stmtOld);
        mysqli_stmt_bind_result($stmtOld, $gambarLama);
        mysqli_stmt_fetch($stmtOld);
        mysqli_stmt_close($stmtOld);
 
        if ($gambarLama && file_exists($uploadDir . $gambarLama)) {
            unlink($uploadDir . $gambarLama);
        }
    }
}
 
if ($gambarBaru) {
    $stmt = mysqli_prepare($koneksi, "UPDATE galeri SET nama_produk = ?, harga = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'sissi', $nama_produk, $harga, $deskripsi, $gambarBaru, $id);
} else {
    $stmt = mysqli_prepare($koneksi, "UPDATE galeri SET nama_produk = ?, harga = ?, deskripsi = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'sisi', $nama_produk, $harga, $deskripsi, $id);
}
 
if (mysqli_stmt_execute($stmt)) {
    header("Location: galeri.php?msg=" . urlencode('Foto berhasil diupdate'));
} else {
    header("Location: edit_galeri.php?id=$id&error=" . urlencode('Gagal update data'));
}
mysqli_stmt_close($stmt);
 