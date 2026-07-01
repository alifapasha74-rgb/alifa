<?php
session_start();

if (!isset($_SESSION['login_admin']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

include __DIR__ . '/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Produk - Susu Mbok Darmi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div style="width:100%; max-width:960px; margin:0 auto; padding:30px;">
    <h1 style="margin-bottom:20px;">🛒 Admin Produk</h1>

    <nav id="mainNav">
        <a href="dashboard.php">📊 Dashboard</a>
        <a href="produk.php" class="active">📦 Produk</a>
        <a href="galeri.php">🖼️ Galeri</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <div style="text-align:center; margin-bottom:16px;">
        <a href="tambah_produk.php">
            <button style="width:auto; padding:12px 24px;">➕ Tambah Produk</button>
        </a>
    </div>

    <section>
        <h2>Daftar Produk</h2>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($data && mysqli_num_rows($data) > 0):
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($row['gambar']) ?></td>
                        <td style="white-space:nowrap;">
                            <a href="edit_produk.php?id=<?= $row['id'] ?>">
                                <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#FFD54F,#FFA000); color:#1B5E20;">✏️ Edit</button>
                            </a>
                            <a href="hapus_produk.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">
                                <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#ef5350,#c62828);">🗑️ Hapus</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Belum ada produk</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>