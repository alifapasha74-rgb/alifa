<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<link rel="stylesheet" href="style.css">
<div style="width:100%; max-width:960px; margin:0 auto; padding:30px;">
    <h1 style="border-radius:16px; margin-bottom:20px;">🛒 Admin Produk</h1>
    <nav id="mainNav">
        <a href="index.php">Beranda</a>
        <a href="admin_produk.php" class="active">Admin Produk</a>
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
                <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_produk'] ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= $row['deskripsi'] ?></td>
                    <td><?= $row['gambar'] ?></td>
                    <td style="white-space:nowrap;">
                        <a href="edit_produk.php?id=<?= $row['id'] ?>">
                            <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#FFD54F,#FFA000); color:#1B5E20;">✏️ Edit</button>
                        </a>
                        <a href="hapus_produk.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">
                            <button style="width:auto; padding:8px 16px; background:linear-gradient(135deg,#ef5350,#c62828);">🗑️ Hapus</button>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </section>
</div>