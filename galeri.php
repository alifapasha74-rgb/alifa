<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$sejarah = mysqli_query($koneksi, "SELECT * FROM galeri WHERE kategori='sejarah' ORDER BY id ASC");
$rasa    = mysqli_query($koneksi, "SELECT * FROM galeri WHERE kategori='rasa' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Galeri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<button class="burger-btn" id="burgerBtn" onclick="toggleNav()">
    <span></span><span></span><span></span>
</button>

<h1 class="judul-produk">🖼️ Cerita & Galeri Kami 🐄</h1>

<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="pesan.php">Pesan</a>
    <a href="kontak.php">Kontak</a>
    <a href="galeri.php" class="active">galeri</a>
    <a href="logout.php">logout</a>
</nav>

<section>
    <h2>📜 Perjalanan Susu Mbok Darmi</h2>
    <div class="timeline">
        <?php if (mysqli_num_rows($sejarah) === 0): ?>
            <p style="text-align:center;">Belum ada cerita sejarah ditambahkan.</p>
        <?php else: ?>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($sejarah)): ?>
            <div class="timeline-item">
                <div class="timeline-dot"><?= $i++ ?></div>
                <div class="timeline-content">
                    <img src="uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="sejarah">
                    <p><?= htmlspecialchars($row['keterangan']) ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<section>
    <h2>🥛 Kenali Rasa Susu Kami</h2>
    <div class="produk-grid">
        <?php if (mysqli_num_rows($rasa) === 0): ?>
            <p style="text-align:center;">Belum ada penjelasan rasa ditambahkan.</p>
        <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($rasa)): ?>
            <div style="background:#fff; border:2px solid var(--green-pale); border-radius:20px; padding:14px; text-align:center;">
                <img src="uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="rasa susu" style="height:180px; object-fit:cover; border-radius:12px;">
                <p style="margin-top:8px;"><?= htmlspecialchars($row['keterangan']) ?></p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>

<script src="main.js"></script>
</body>
</html>