<?php
session_start();
if (!isset($_SESSION['login_admin']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
include __DIR__ . '/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama      = $_POST['nama_produk'];
    $harga     = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar    = $_POST['gambar'];

    mysqli_query($koneksi, "INSERT INTO produk (nama_produk, harga, deskripsi, gambar) VALUES ('$nama', '$harga', '$deskripsi', '$gambar')");
    header("Location: produk.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk - Susu Mbok Darmi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap" style="background:#F1F8E9;">
<div class="login-box" style="max-width:500px;">
    <h2>➕ Tambah Produk</h2>
    <form method="POST">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" required>
        <label>Harga</label>
        <input type="number" name="harga" required>
        <label>Deskripsi</label>
        <input type="text" name="deskripsi">
        <label>Nama File Gambar</label>
        <input type="text" name="gambar" placeholder="contoh: coklat.jpg">
        <button type="submit" name="simpan">💾 Simpan</button>
    </form>
    <a href="produk.php">
        <button style="background:grey; margin-top:10px;">← Kembali</button>
    </a>
</div>
</div>
</body>
</html>