<?php
session_start();
   if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi 2 — Beranda</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<button class="burger-btn" id="burgerBtn" onclick="toggleNav()">
    <span></span><span></span><span></span>
</button>

<div class="hero-milk">
    <div class="milk-drops">
        <div class="drop"></div><div class="drop"></div><div class="drop"></div>
        <div class="drop"></div><div class="drop"></div><div class="drop"></div>
        <div class="drop"></div><div class="drop"></div><div class="drop"></div>
        <div class="drop"></div>
    </div>
    <div class="splash-blob left"></div>
    <div class="splash-blob right"></div>
    <div class="milk-glass-wrap">
        <span class="milk-glass-emoji">🥛</span>
    </div>
    <h1>🐄 Susu Mbok Darmi</h1>
    <p class="tagline">Segar • Murni • Menyehatkan</p>
    <svg class="milk-wave" viewBox="0 0 1200 56" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,28 C200,56 400,0 600,28 C800,56 1000,0 1200,28 L1200,56 L0,56 Z" fill="#F1F8E9"/>
    </svg>
</div>

<nav id="mainNav">
    <a href="index.php" class="active">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="pesan.php">Pesan</a>
    <a href="kontak.php">Kontak</a>
</nav>

<section>
    <h2>Selamat Datang di Susu Mbok Darmi 🌿</h2>
    <img src="susumbokdarmi.jpg" alt="Logo" class="logo">
    <p>Susu sapi segar, murni, dan menyehatkan langsung dari ladang menuju ke meja makan kamu!</p>
    <br>
    <div class="carousel">
        <img id="slide" src="belanja.jpg" alt="Foto">
        <div class="carousel-control">
            <button onclick="prevSlide()">❮</button>
            <div class="dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
            <button onclick="nextSlide()">❯</button>
        </div>
    </div>
    <br>
    <div style="text-align:center;">
        <a href="produk.php">
            <button style="width:auto; padding:14px 36px; font-size:16px;">🛒 Lihat Produk Kami</button>
        </a>
    </div>
</section>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>

<script src="main.js">

</script>
</body>
</html>