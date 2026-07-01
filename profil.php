<?php
session_start();
include 'koneksi.php';
$sejarah = mysqli_query($koneksi, "SELECT * FROM galeri WHERE kategori='sejarah' ORDER BY id ASC");
$rasa    = mysqli_query($koneksi, "SELECT * FROM galeri WHERE kategori='rasa' ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<button class="burger-btn" id="burgerBtn" onclick="toggleNav()">
    <span></span><span></span><span></span>
</button>

<h1 class="judul-produk">🐄 Susu Mbok Darmi 🥛</h1>

<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php" class="active">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="pesan.php">Pesan</a>
    <a href="kontak.php">Kontak</a>
    <?php if (isset($_SESSION['login'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>

<section>
    <h2>Manfaat Susu Sapi Segar 🥛</h2>
    <ul class="manfaat-list">
        <li>Menjaga kesehatan tulang</li>
        <li>Menambah energi</li>
        <li>Meningkatkan konsentrasi</li>
        <li>Baik untuk pertumbuhan</li>
        <li>Kaya protein alami</li>
        <li>Menjaga daya tahan tubuh</li>
    </ul>
</section>

<section>
    <h2>📜 Perjalanan Susu Mbok Darmi</h2>
    <div class="timeline">
        <?php if (mysqli_num_rows($sejarah) === 0): ?>
            <p style="text-align:center; color:#aaa;">Belum ada cerita sejarah ditambahkan.</p>
        <?php else: ?>
            <?php $i = 1; while ($row = mysqli_fetch_assoc($sejarah)): ?>
            <div class="timeline-item">
                <div class="timeline-dot"><?= $i++ ?></div>
                <div class="timeline-content">
                    <img src="admin/uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="sejarah">
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
            <p style="text-align:center; color:#aaa;">Belum ada penjelasan rasa ditambahkan.</p>
        <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($rasa)): ?>
            <div style="background:#fff; border:2px solid var(--green-pale); border-radius:20px; padding:14px; text-align:center;">
                <img src="admin/uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="rasa susu" style="height:180px; object-fit:cover; border-radius:12px; width:100%;">
                <p style="margin-top:8px; font-weight:700;"><?= htmlspecialchars($row['keterangan']) ?></p>
            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<section>
    <h2>Tentang Kami 🌿</h2>
    <p>Susu Mbok Darmi adalah usaha susu sapi segar yang berdiri sejak 2010. Kami berkomitmen menghadirkan susu berkualitas tinggi, murni, sehat, dan menyegarkan untuk seluruh keluarga Indonesia.</p>
    <br>
    <p>📍 Tang City Mall, Tangerang, Lt.1, Blok A1</p>
    <p>⏰ Buka setiap hari: 09.00 – 19.00 WIB</p>
</section>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>
<script src="main.js"></script>
</body>
</html>