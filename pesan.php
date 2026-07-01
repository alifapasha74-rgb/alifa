<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php?redirect=pesan.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Pesan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<button class="burger-btn" id="burgerBtn" onclick="toggleNav()">
    <span></span><span></span><span></span>
</button>

<h1 class="judul-produk">🛒 Pesan Susu 🐄</h1>

<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="pesan.php" class="active">Pesan</a>
    <a href="kontak.php">Kontak</a>
    <a href="logout.php">Logout</a>
</nav>

<section>
    <h2>🛒 Keranjang Pesanan</h2>
    <div id="cartContainer"></div>
    <div style="text-align:right;">
        <button class="clear-btn" onclick="clearAll()">🗑️ Hapus Semua</button>
    </div>
</section>

<section>
    <h2>Form Order 📋</h2>
    <label>👤 Nama Lengkap</label>
    <input type="text" id="nama" placeholder="Contoh: Budi Santoso">

    <label>📍 Alamat Pengiriman</label>
    <textarea id="alamat" rows="3" placeholder="Tuliskan alamat lengkap kamu..."></textarea>

    <label>📱 Nomor HP / WhatsApp</label>
    <input type="text" id="hp" placeholder="Contoh: 08123456789">

    <label>💳 Metode Pembayaran</label>
    <select id="bayar">
        <option>COD (Bayar di Tempat)</option>
        <option>Transfer Bank</option>
        <option>E-Wallet (OVO / GoPay / Dana)</option>
    </select>

    <button onclick="submitOrder()" style="font-size:16px; padding:15px;">💬 Kirim Pesanan via WhatsApp</button>
</section>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>
<script src="main.js"></script>
</body>
</html>