<?php
session_start();
require 'koneksi.php';
 
// semua user yang udah login boleh edit foto (gak perlu level admin)
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
 
$id = $_GET['id'] ?? '';
if ($id === '' || !is_numeric($id)) {
    header("Location: galeri.php");
    exit();
}
 
$stmt = mysqli_prepare($koneksi, "SELECT * FROM galeri WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
 
if (!$data) {
    header("Location: galeri.php");
    exit();
}
 
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto Galeri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap">
    <div class="login-box">
        <form action="proses_edit_galeri.php" method="POST" enctype="multipart/form-data">
            <h2>Edit Foto Galeri ✏️</h2>
 
            <?php if ($error): ?>
                <p style="color:red; font-size:14px;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
 
            <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">
 
            <label>Foto saat ini:</label>
            <img src="uploads_galeri/<?= htmlspecialchars($data['gambar']) ?>" style="width:120px; border-radius:8px; display:block; margin-bottom:10px;">
 
            <label>Nama Produk:</label>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
 
            <label>Harga (Rp):</label>
            <input type="number" name="harga" min="0" value="<?= (int)$data['harga'] ?>" required>
 
            <label>Deskripsi:</label>
            <input type="text" name="deskripsi" value="<?= htmlspecialchars($data['deskripsi']) ?>">
 
            <label>Ganti Foto (kosongkan kalau gak mau ganti):</label>
            <input type="file" name="foto" accept="image/*">
 
            <button type="submit">Simpan Perubahan</button>
 
            <p style="margin-top:15px; text-align:center; font-size:14px;">
                <a href="galeri.php">← Kembali ke Galeri</a>
            </p>
        </form>
    </div>
</div>
</body>
</html>