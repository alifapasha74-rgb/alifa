<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
require 'koneksi.php';

$result = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<button class="burger-btn" id="burgerBtn" onclick="toggleNav()">
    <span></span><span></span><span></span>
</button>

<h1 class="judul-produk">🥛 Produk Kami 🐄</h1>

<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php" class="active">Produk</a>
    <a href="pesan.php">
        <span class="cart-badge-wrap">Pesan <span id="cartBadge"></span></span>
    </a>
    <a href="kontak.php">Kontak</a>
    <a href="logout.php">logout</a>
</nav>

<section>
    <h2>Daftar Produk 🛒</h2>
    <ul class="produk-grid">
        <?php if (mysqli_num_rows($result) === 0): ?>
            <li style="list-style:none; text-align:center;">Belum ada produk. Admin belum menambahkan produk.</li>
        <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    $namaJs   = htmlspecialchars($row['nama_produk'], ENT_QUOTES);
                    $gambarJs = htmlspecialchars($row['gambar'], ENT_QUOTES);
                ?>
                <li>
                    <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                    <b><?= htmlspecialchars($row['nama_produk']) ?></b>
                    <p>Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <button onclick="pesanProduk('<?= $namaJs ?>',<?= (int)$row['harga'] ?>,'<?= $gambarJs ?>')">🛒 Tambah ke Keranjang</button>
                </li>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
</section>

<div id="popup" class="modal">
    <div class="modal-content">
        <div style="font-size:48px; margin-bottom:10px;">🐄</div>
        <h2 style="font-size:20px; margin-bottom:8px;">Ditambahkan ke Keranjang!</h2>
        <p id="popupText"></p>
        <div class="popup-btn">
            <button onclick="tutupPopup()">✅ Lanjut Belanja</button>
            <button onclick="lihatKeranjang()" style="background:linear-gradient(135deg,#43A047,#1B5E20);">🛒 Lihat Keranjang</button>
        </div>
        <div style="margin-top:10px;">
            <button onclick="batalPesanan()" style="background:linear-gradient(135deg,#ef5350,#c62828);font-size:13px;padding:9px 18px;width:auto;">❌ Batal</button>
        </div>
    </div>
</div>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>

<script src="main.js"></script>
</body>
</html>