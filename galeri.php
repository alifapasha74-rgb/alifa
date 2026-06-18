<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
require 'koneksi.php';
 
$isAdmin = isset($_SESSION['level']) && $_SESSION['level'] === 'admin';
$result  = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Galeri</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .galeri-item {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
            padding-bottom: 14px;
        }
        .galeri-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .galeri-item h4 {
            margin: 10px 0 4px;
        }
        .galeri-item p {
            font-size: 14px;
            color: #555;
            padding: 0 12px;
        }
        .btn-hapus {
            background: #c0392b;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
 
<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="galeri.php" class="active">Galeri</a>
    <a href="pesan.php">Pesan</a>
    <a href="kontak.php">Kontak</a>
    <a href="logout.php">logout</a>
</nav>
 
<section>
    <h2>Galeri Produk Susu Mbok Darmi 📸</h2>
 
    <?php if (isset($_GET['msg'])): ?>
        <p style="color:green; text-align:center;"><?= htmlspecialchars($_GET['msg']) ?></p>
    <?php endif; ?>
 
    <?php if ($isAdmin): ?>
        <div style="text-align:center; margin-bottom:10px;">
            <a href="admin/tambah_galeri.php">
                <button style="width:auto; padding:12px 28px;">+ Tambah Foto</button>
            </a>
        </div>
    <?php endif; ?>
 
    <div class="galeri-grid">
        <?php if (mysqli_num_rows($result) === 0): ?>
            <p style="text-align:center; grid-column: 1/-1;">Belum ada foto di galeri.</p>
        <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="galeri-item">
                    <img src="uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['nama_produk']) ?>">
                    <h4><?= htmlspecialchars($row['nama_produk']) ?></h4>
                    <p style="font-weight:bold; color:#2e7d32;">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <p><?= htmlspecialchars($row['deskripsi']) ?></p>
 
                    <div style="display:flex; gap:8px; justify-content:center; margin-top:8px;">
                        <?php if ($isAdmin): ?>
                            <a href="admin/edit_galeri.php?id=<?= (int)$row['id'] ?>">
                                <button type="button" style="background:#2980b9; padding:8px 18px;">Edit</button>
                            </a>
                        <?php endif; ?>
                        <form action="hapus_galeri.php" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>
 
<p class="center little-text">&copy; 2026 Susu Mbok Darmi</p>
</body>
</html>