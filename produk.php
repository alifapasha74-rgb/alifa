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
        <li>
            <img src="coklat.jpg" alt="Susu Coklat">
            <b>Susu Coklat</b>
            <p>Rp 15.000</p>
            <button onclick="pesanProduk('Susu Coklat',15000,'coklat.jpg')">🛒 Tambah ke Keranjang</button>
        </li>
        <li>
            <img src="strawbery.jpg" alt="Susu Strawberry">
            <b>Susu Strawberry</b>
            <p>Rp 15.000</p>
            <button onclick="pesanProduk('Susu Strawberry',15000,'strawbery.jpg')">🛒 Tambah ke Keranjang</button>
        </li>
        <li>
            <img src="vanilla.jpg" alt="Susu Vanilla">
            <b>Susu Vanilla</b>
            <p>Rp 15.000</p>
            <button onclick="pesanProduk('Susu Vanilla',15000,'vanilla.jpg')">🛒 Tambah ke Keranjang</button>
        </li>
        <li>
            <img src="almond.jpg" alt="Susu Almond">
            <b>Susu Almond</b>
            <p>Rp 15.000</p>
            <button onclick="pesanProduk('Susu Almond',15000,'almond.jpg')">🛒 Tambah ke Keranjang</button>
        </li>
        <li>
            <img src="mangga.jpg" alt="Susu Mangga Topping Oreo">
            <b>Susu Mangga Topping Oreo</b>
            <p>Rp 20.000</p>
            <button onclick="pesanProduk('Susu Mangga Topping Oreo',20000,'mangga.jpg')">🛒 Tambah ke Keranjang</button>
        </li>
        <li>
            <img src="kurma.jpg" alt="Susu Kurma Promo">
            <b>Susu Kurma Promo 🔥</b>
            <p>Rp 12.000</p>
            <button onclick="pesanProduk('Susu Kurma Promo',12000,'kurma.jpg')">🛒 Tambah ke Keranjang</button>
        </li>
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

<script src="main.js">

</script>
</body>
</html>