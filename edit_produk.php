<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$id   = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id=$id"));

if (isset($_POST['update'])) {
    $nama      = $_POST['nama_produk'];
    $harga     = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar    = $_POST['gambar'];

    mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama', harga='$harga', deskripsi='$deskripsi', gambar='$gambar' WHERE id=$id");
    header("Location: adminproduk.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css">
<div class="login-wrap" style="background:#F1F8E9;">
<div class="login-box" style="max-width:500px;">
    <h2>✏️ Edit Produk</h2>
    <form method="POST">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="<?= $data['nama_produk'] ?>" required>
        <label>Harga</label>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
        <label>Deskripsi</label>
        <input type="text" name="deskripsi" value="<?= $data['deskripsi'] ?>">
        <label>Nama File Gambar</label>
        <input type="text" name="gambar" value="<?= $data['gambar'] ?>">
        <button type="submit" name="update">💾 Update</button>
    </form>
    <a href="adminproduk.php">
        <button style="background:grey; margin-top:10px;">← Kembali</button>
    </a>
</div>
</div>