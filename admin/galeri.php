<?php
session_start();
if (!isset($_SESSION['login_admin']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
include __DIR__ . '/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Galeri - Susu Mbok Darmi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div style="width:100%; max-width:960px; margin:0 auto; padding:30px;">
    <h1 style="margin-bottom:20px;">🖼️ Admin Galeri</h1>
    <nav id="mainNav">
        <a href="produk.php">📦 Produk</a>
        <a href="galeri.php" class="active">🖼️ Galeri</a>
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
            <?php if ($data && mysqli_num_rows($data) > 0):
                while ($row = mysqli_fetch_assoc($data)): ?>
            <div style="background:#fff; border:2px solid var(--green-pale); border-radius:20px; padding:14px; text-align:center;">
                <img src="uploads_galeri/<?= htmlspecialchars($row['gambar']) ?>" alt="foto" style="height:180px; object-fit:cover; border-radius:12px;">
                <p style="margin-top:8px; font-weight:800;">
                    <?= $row['kategori']=='sejarah' ? '📜 Sejarah' : '🥛 Rasa Susu' ?>
                </p>
                <p><?= htmlspecialchars($row['keterangan']) ?></p>
                <div style="display:flex; gap:8px; justify-content:center; margin-top:8px;">
                    <a href="edit_galeri.php?id=<?= $row['id'] ?>">
                        <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#FFD54F,#FFA000); color:#1B5E20;">✏️ Edit</button>
                    </a>
                    <a href="hapus_galeri.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">
                        <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#ef5350,#c62828);">🗑️ Hapus</button>
                    </a>
                </div>
            </div>
            <?php endwhile; else: ?>
                <p style="text-align:center;">Belum ada foto</p>
            <?php endif; ?>
        </div>
    </section>
</div>
</body>
</html>