<?php
session_start();
// semua user yang udah login boleh tambah foto (gak perlu level admin)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Foto Galeri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap">
    <div class="login-box">
        <form action="proses_tambah_galeri.php" method="POST" enctype="multipart/form-data">
            <h2>Tambah Foto Galeri 📸</h2>
 
            <?php if ($error): ?>
                <p style="color:red; font-size:14px;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
 
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" required>
 
            <label>Harga (Rp):</label>
            <input type="number" name="harga" min="0" required>
 
            <label>Deskripsi:</label>
            <input type="text" name="deskripsi">
 
            <label>Pilih Foto:</label>
            <input type="file" name="foto" accept="image/*" required>
 
            <button type="submit">Simpan</button>
 
            <p style="margin-top:15px; text-align:center; font-size:14px;">
                <a href="galeri.php">← Kembali ke Galeri</a>
            </p>
        </form>
    </div>
</div>
</body>
</html>
 