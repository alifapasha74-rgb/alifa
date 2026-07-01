<?php
session_start();
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
    <?php if (isset($_SESSION['login'])): ?>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
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
                    <?php if (isset($_SESSION['login'])): ?>
                        <button onclick="pesanProduk('<?= $namaJs ?>',<?= (int)$row['harga'] ?>,'<?= $gambarJs ?>')">🛒 Tambah ke Keranjang</button>
                    <?php else: ?>
                        <button style="background:linear-gradient(135deg,#78909C,#455A64);" onclick="tampilkanPopupLogin()">🔒 Login untuk Pesan</button>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
</section>

<!-- POPUP TAMBAH KERANJANG -->
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

<!-- POPUP LOGIN -->
<div id="popupLogin" class="modal">
    <div class="modal-content">
        <div style="font-size:48px; margin-bottom:10px;">🔒</div>
        <h2 style="font-size:20px; margin-bottom:8px;">Login dulu, yuk</h2>
        <p style="margin-bottom:14px; font-size:14px;">Login diperlukan untuk memesan produk.</p>

        <div id="loginError" style="color:#c62828; font-size:13px; margin-bottom:8px; display:none;"></div>

        <input type="text" id="popupUser" placeholder="Username" style="width:100%; margin-bottom:8px; padding:10px; border-radius:8px; border:1px solid #ccc;">
        <input type="password" id="popupPass" placeholder="Password" style="width:100%; margin-bottom:12px; padding:10px; border-radius:8px; border:1px solid #ccc;">

        <button onclick="submitPopupLogin()" style="width:100%;">Masuk</button>

        <p style="margin-top:12px; font-size:13px; text-align:center;">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>
        <div style="margin-top:10px;">
            <button onclick="tutupPopupLogin()" style="background:linear-gradient(135deg,#ef5350,#c62828); font-size:13px; padding:9px 18px; width:auto;">Tutup</button>
        </div>
    </div>
</div>

<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>

<script>
const isLoggedIn = <?= isset($_SESSION['login']) ? 'true' : 'false' ?>;
</script>
<script src="main.js"></script>
<script>
function tampilkanPopupLogin() {
    document.getElementById('popupLogin').style.display = 'flex';
}
function tutupPopupLogin() {
    document.getElementById('popupLogin').style.display = 'none';
    document.getElementById('loginError').style.display = 'none';
}

function submitPopupLogin() {
    const username = document.getElementById('popupUser').value.trim();
    const password = document.getElementById('popupPass').value;
    const errorBox = document.getElementById('loginError');

    if (!username || !password) {
        errorBox.textContent = "Username dan password harus diisi.";
        errorBox.style.display = 'block';
        return;
    }

    fetch('login-ajax.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'txt_user=' + encodeURIComponent(username) + '&txt_pass=' + encodeURIComponent(password)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            errorBox.textContent = data.message;
            errorBox.style.display = 'block';
        }
    })
    .catch(() => {
        errorBox.textContent = "Terjadi kesalahan, coba lagi.";
        errorBox.style.display = 'block';
    });
}
</script>
</body>
</html>