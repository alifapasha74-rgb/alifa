<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$id = $_GET['id'] ?? '';
$stmt = mysqli_prepare($koneksi, "SELECT * FROM galeri WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: admin_galeri.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css">
<div class="login-wrap" style="background:#F1F8E9;">
<div class="login-box" style="max-width:500px;">
    <h2>✏️ Edit Foto</h2>

    <img src="uploads_galeri/<?= htmlspecialchars($data['gambar']) ?>" style="width:100%; border-radius:12px; margin-bottom:14px;">

    <form action="proses_edit_galeri.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar']) ?>">

        <label>Kategori</label>
        <select name="kategori">
            <option value="sejarah" <?= $data['kategori']=='sejarah' ? 'selected':'' ?>>📜 Sejarah Perjalanan</option>
            <option value="rasa" <?= $data['kategori']=='rasa' ? 'selected':'' ?>>🥛 Penjelasan Rasa Susu</option>
        </select>

        <label>Keterangan Foto</label>
        <input type="text" name="keterangan" value="<?= htmlspecialchars($data['keterangan']) ?>">

        <label>Ganti Foto (opsional)</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit">💾 Update</button>
    </form>
    <a href="admin_galeri.php">
        <button style="background:grey; margin-top:10px;">← Kembali</button>
    </a>
</div>
</div>