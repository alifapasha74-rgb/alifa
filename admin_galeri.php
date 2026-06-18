<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM galeri");
?>
<link rel="stylesheet" href="style.css">
<div style="width:100%; max-width:960px; margin:0 auto; padding:30px;">
    <h1 style="border-radius:16px; margin-bottom:20px;">🖼️ Admin Galeri</h1>

    <nav id="mainNav">
        <a href="admin_produk.php">📦 Produk</a>
        <a href="admin_galeri.php" class="active">🖼️ Galeri</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <div style="text-align:center; margin-bottom:16px;">
        <a href="tambah_galeri.php">
            <button style="width:auto; padding:12px 24px;">➕ Tambah Foto</button>
        </a>
    </div>
    <section>
        <h2>Daftar Foto</h2>
        <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Gambar</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['judul'] ?></td>
                    <td><?= $row['gambar'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td style="white-space:nowrap;">
                        <a href="hapus_galeri.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">
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