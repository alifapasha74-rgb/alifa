<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css">
<div class="login-wrap" style="background:#F1F8E9;">
<div class="login-box" style="max-width:500px;">
    <h2>➕ Tambah Foto Galeri</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="error-msg">❌ <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="proses_tambah_galeri.php" method="POST" enctype="multipart/form-data">
        <label>Kategori</label>
        <select name="kategori" required>
            <option value="sejarah">📜 Sejarah Perjalanan</option>
            <option value="rasa">🥛 Penjelasan Rasa Susu</option>
        </select>

        <label>Keterangan Foto</label>
        <input type="text" name="keterangan" placeholder="contoh: Mulai usaha dari rumah tahun 2020" required>

        <label>Pilih Foto</label>
        <input type="file" name="foto" accept="image/*" required>

        <button type="submit">💾 Simpan</button>
    </form>
    <a href="admin_galeri.php">
        <button style="background:grey; margin-top:10px;">← Kembali</button>
    </a>
</div>
</div>