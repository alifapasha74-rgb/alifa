<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id ASC");
?>
<link rel="stylesheet" href="style.css">
<div style="width:100%; max-width:960px; margin:0 auto; padding:30px;">
    <h1 style="border-radius:16px; margin-bottom:20px;">🖼️ Admin Galeri</h1>

    <nav id="mainNav">
        <a href="adminproduk.php">📦 Produk</a>
        <a href="admin_galeri.php" class="active">🖼️ Galeri</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <?php if (isset($_GET['msg'])): ?>
        <p style="text-align:center; color:green; font-weight:700;"><?= htmlspecialchars($_GET['msg']) ?></p>
    <?php endif; ?>

    <div style="text-align:center; margin-bottom:16px;">
        <a href="tambah_galeri.php">
            <button style="width:auto; padding:12px 24px;">➕ Tambah Foto</button>
        </a>
    </div>

    <section>
        <h2>Daftar Foto</h2>
        <div class="produk-grid">
            <?php while ($row = mysqli_fetch_assoc($data)): ?>
            <div style="background:#fff; border:2px solid var(--green-pale); border-radius:20px; padding:14px; text-align:center;">
                <img src="uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="foto galeri" style="height:180px; object-fit:cover; border-radius:12px;">
                <p style="margin-top:8px; font-weight:800; color:<?= $row['kategori']=='sejarah' ? '#1B5E20':'#FFA000' ?>;">
                    <?= $row['kategori']=='sejarah' ? '📜 Sejarah' : '🥛 Rasa Susu' ?>
                </p>
                <p><?= htmlspecialchars($row['keterangan']) ?></p>
                <div style="display:flex; gap:8px; justify-content:center; margin-top:8px;">
                    <a href="edit_galeri.php?id=<?= $row['id'] ?>">
                        <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#FFD54F,#FFA000); color:#1B5E20;">✏️ Edit</button>
                    </a>
                    <a href="hapus_galeri.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus foto ini?')">
                        <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#ef5350,#c62828);">🗑️ Hapus</button>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
</div>