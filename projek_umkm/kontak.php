<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Kontak</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<button class="burger-btn" id="burgerBtn" onclick="toggleNav()">
    <span></span><span></span><span></span>
</button>

<h1 class="judul-produk">📞 Kontak Kami 🐄</h1>

<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="pesan.php">Pesan</a>
    <a href="kontak.php" class="active">Kontak</a>
    <?php if (isset($_SESSION['login'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>

<section>
    <h2>Hubungi Kami 💬</h2>
    <div class="kontak-list">
        <div class="kontak-item">
            <span class="icon">📱</span>
            <span>WhatsApp: <b style="display:inline;">0812-8248-1503</b></span>
        </div>
        <div class="kontak-item">
            <span class="icon">📍</span>
            <span>Tang City Mall, Tangerang, Lt.1, Blok A1</span>
        </div>
        <div class="kontak-item">
            <span class="icon">⏰</span>
            <span>Senin – Minggu: 09.00 – 19.00 WIB</span>
        </div>
        <div class="kontak-item">
            <span class="icon">🚗</span>
            <span>Gratis ongkir area Tangerang (min. order 2 botol)</span>
        </div>
    </div>
    <br>
    <a href="https://maps.app.goo.gl/zmbsjXV1nhqBnjzr8" target="_blank">
        <button style="font-size:15px; padding:14px;">🗺️ Lihat di Google Maps</button>
    </a>
    <a href="https://wa.me/6281282481503" target="_blank">
        <button style="font-size:15px; padding:14px; background:linear-gradient(135deg,#25D366,#128C7E);">💬 Chat WhatsApp Sekarang</button>
    </a>
</section>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>
<script src="main.js"></script>
</body>
</html>