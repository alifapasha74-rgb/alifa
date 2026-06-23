<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$id          = $_POST['id'] ?? '';
$keterangan  = trim($_POST['keterangan'] ?? '');
$kategori    = $_POST['kategori'] ?? 'sejarah';
$gambarLama  = $_POST['gambar_lama'] ?? '';
$gambarBaru  = $gambarLama;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fileTmp  = $_FILES['foto']['tmp_name'];
    $fileName = $_FILES['foto']['name'];
    $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($ext, $allowedExt)) {
        $newFileName = uniqid('foto_') . '.' . $ext;
        $targetPath  = 'uploads_galeri/' . $newFileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            $oldPath = 'uploads_galeri/' . $gambarLama;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
            $gambarBaru = $newFileName;
        }
    }
}

$stmt = mysqli_prepare($koneksi, "UPDATE galeri SET gambar = ?, keterangan = ?, kategori = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'sssi', $gambarBaru, $keterangan, $kategori, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: admin_galeri.php?msg=" . urlencode('Foto berhasil diperbarui'));
exit();