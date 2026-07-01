<?php
session_start();
if (!isset($_SESSION['login_admin']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
include __DIR__ . '/koneksi.php';

$today = date('Y-m-d');

// Penjualan hari ini
$r = mysqli_query($koneksi, "SELECT COALESCE(SUM(total),0) as total, COUNT(*) as jumlah FROM pesanan WHERE DATE(created_at) = '$today'");
$penjualan = mysqli_fetch_assoc($r);

// Penjualan semua waktu
$r2 = mysqli_query($koneksi, "SELECT COALESCE(SUM(total),0) as total, COUNT(*) as jumlah FROM pesanan");
$penjualan_all = mysqli_fetch_assoc($r2);

// Pengunjung hari ini
$r3 = mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah),0) as jumlah FROM pengunjung WHERE tanggal = '$today'");
$pengunjung = mysqli_fetch_assoc($r3);

// Pengunjung total
$r4 = mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah),0) as jumlah FROM pengunjung");
$pengunjung_all = mysqli_fetch_assoc($r4);

// Produk terlaris
$terlaris = mysqli_query($koneksi, "
    SELECT nama_produk, SUM(qty) as total_qty, SUM(subtotal) as total_uang
    FROM detail_pesanan
    GROUP BY nama_produk
    ORDER BY total_qty DESC
    LIMIT 5
");

// Grafik penjualan 7 hari
$grafik_jual = mysqli_query($koneksi, "
    SELECT DATE(created_at) as tgl, SUM(total) as total
    FROM pesanan
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    GROUP BY DATE(created_at)
    ORDER BY tgl ASC
");
$grafik_jual_data = [];
while ($g = mysqli_fetch_assoc($grafik_jual)) $grafik_jual_data[] = $g;

// Grafik pengunjung 7 hari
$grafik_pengunjung = mysqli_query($koneksi, "
    SELECT tanggal as tgl, jumlah
    FROM pengunjung
    WHERE tanggal >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ORDER BY tgl ASC
");
$grafik_pengunjung_data = [];
while ($g = mysqli_fetch_assoc($grafik_pengunjung)) $grafik_pengunjung_data[] = $g;

// Pesanan terbaru
$pesanan_baru = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Susu Mbok Darmi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #f5f5f5; font-family: sans-serif; }
        .dash-wrap { max-width: 960px; margin: 0 auto; padding: 24px; }
        .dash-header { background: linear-gradient(135deg, #2E7D32, #43A047); color: white; padding: 24px; border-radius: 16px; margin-bottom: 24px; }
        .dash-header h1 { margin: 0; font-size: 24px; }
        .dash-header p { margin: 4px 0 0; opacity: 0.85; }
        .stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .stat-card .icon { font-size: 32px; margin-bottom: 8px; }
        .stat-card .label { font-size: 13px; color: #888; }
        .stat-card .value { font-size: 22px; font-weight: 800; color: #2E7D32; }
        .stat-card .sub { font-size: 12px; color: #aaa; margin-top: 4px; }
        .section-card { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 24px; }
        .section-card h2 { margin: 0 0 16px; font-size: 16px; color: #2E7D32; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #2E7D32; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge.baru { background: #FFF9C4; color: #F57F17; }
        .badge.diproses { background: #E3F2FD; color: #1565C0; }
        .badge.selesai { background: #E8F5E9; color: #2E7D32; }
        .bar-wrap { display: flex; align-items: flex-end; gap: 8px; height: 130px; margin-top: 8px; }
        .bar-item { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .bar { width: 100%; border-radius: 6px 6px 0 0; min-height: 4px; }
        .bar-green { background: #2E7D32; }
        .bar-blue { background: #1565C0; }
        .bar-label { font-size: 10px; color: #888; }
        .bar-val { font-size: 10px; font-weight: 700; }
        .terlaris-item { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .terlaris-rank { width: 28px; height: 28px; background: #2E7D32; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; }
        .terlaris-name { flex: 1; margin-left: 12px; font-weight: 600; }
        .terlaris-qty { color: #2E7D32; font-weight: 800; font-size: 13px; }
        .update-btn { padding: 4px 10px; background: #2E7D32; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 12px; }
        .grafik-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        @media(max-width:600px) { .grafik-row { grid-template-columns: 1fr; } .stats { grid-template-columns: 1fr 1fr; } }
    </style>
</head>
<body>
<div class="dash-wrap">

    <div class="dash-header">
        <h1>📊 Dashboard Admin</h1>
        <p>Susu Mbok Darmi — <?= date('d F Y') ?></p>
    </div>

    <nav id="mainNav">
        <a href="dashboard.php" class="active">📊 Dashboard</a>
        <a href="produk.php">📦 Produk</a>
        <a href="galeri.php">🖼️ Galeri</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <!-- STATISTIK -->
    <div class="stats">
        <div class="stat-card">
            <div class="icon">💰</div>
            <div class="label">Penjualan Hari Ini</div>
            <div class="value">Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></div>
            <div class="sub"><?= $penjualan['jumlah'] ?> transaksi</div>
        </div>
        <div class="stat-card">
            <div class="icon">👥</div>
            <div class="label">Pengunjung Hari Ini</div>
            <div class="value"><?= number_format($pengunjung['jumlah'], 0, ',', '.') ?></div>
            <div class="sub">Total: <?= number_format($pengunjung_all['jumlah'], 0, ',', '.') ?></div>
        </div>
        <div class="stat-card">
            <div class="icon">🛒</div>
            <div class="label">Total Pembeli</div>
            <div class="value"><?= $penjualan_all['jumlah'] ?> orang</div>
            <div class="sub">Sejak awal</div>
        </div>
        <div class="stat-card">
            <div class="icon">📈</div>
            <div class="label">Total Penjualan</div>
            <div class="value">Rp <?= number_format($penjualan_all['total'], 0, ',', '.') ?></div>
            <div class="sub">Semua waktu</div>
        </div>
    </div>

    <!-- GRAFIK -->
    <div class="grafik-row">
        <!-- Grafik Penjualan -->
        <div class="section-card">
            <h2>💰 Penjualan 7 Hari</h2>
            <?php $max = 1; foreach ($grafik_jual_data as $g) if ($g['total'] > $max) $max = $g['total']; ?>
            <div class="bar-wrap">
                <?php if (empty($grafik_jual_data)): ?>
                    <p style="color:#aaa; font-size:12px; margin:auto;">Belum ada data</p>
                <?php else: foreach ($grafik_jual_data as $g):
                    $pct = max(4, round(($g['total'] / $max) * 110)); ?>
                <div class="bar-item">
                    <div class="bar-val" style="color:#2E7D32;"><?= number_format($g['total']/1000, 0) ?>k</div>
                    <div class="bar bar-green" style="height:<?= $pct ?>px;"></div>
                    <div class="bar-label"><?= date('d/m', strtotime($g['tgl'])) ?></div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <!-- Grafik Pengunjung -->
        <div class="section-card">
            <h2>👥 Pengunjung 7 Hari</h2>
            <?php $max2 = 1; foreach ($grafik_pengunjung_data as $g) if ($g['jumlah'] > $max2) $max2 = $g['jumlah']; ?>
            <div class="bar-wrap">
                <?php if (empty($grafik_pengunjung_data)): ?>
                    <p style="color:#aaa; font-size:12px; margin:auto;">Belum ada data</p>
                <?php else: foreach ($grafik_pengunjung_data as $g):
                    $pct2 = max(4, round(($g['jumlah'] / $max2) * 110)); ?>
                <div class="bar-item">
                    <div class="bar-val" style="color:#1565C0;"><?= $g['jumlah'] ?></div>
                    <div class="bar bar-blue" style="height:<?= $pct2 ?>px;"></div>
                    <div class="bar-label"><?= date('d/m', strtotime($g['tgl'])) ?></div>
                </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>

    <!-- PRODUK TERLARIS -->
    <div class="section-card">
        <h2>🏆 Produk Terlaris</h2>
        <?php if (mysqli_num_rows($terlaris) > 0):
            $rank = 1;
            while ($t = mysqli_fetch_assoc($terlaris)):
            $medals = ['🥇','🥈','🥉','4️⃣','5️⃣'];
        ?>
        <div class="terlaris-item">
            <div class="terlaris-rank"><?= $medals[$rank-1] ?? $rank ?></div>
            <div class="terlaris-name"><?= htmlspecialchars($t['nama_produk']) ?></div>
            <div class="terlaris-qty"><?= $t['total_qty'] ?>x terjual</div>
            <div style="color:#888; font-size:12px; margin-left:12px;">Rp <?= number_format($t['total_uang'], 0, ',', '.') ?></div>
        </div>
        <?php $rank++; endwhile;
        else: ?>
            <p style="text-align:center; color:#aaa;">Belum ada data penjualan</p>
        <?php endif; ?>
    </div>

    <!-- PESANAN TERBARU -->
    <div class="section-card">
        <h2>🧾 Pesanan Terbaru</h2>
        <?php if (mysqli_num_rows($pesanan_baru) > 0): ?>
        <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>HP</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($p = mysqli_fetch_assoc($pesanan_baru)): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td><?= htmlspecialchars($p['hp']) ?></td>
                    <td>Rp <?= number_format($p['total'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($p['bayar']) ?></td>
                    <td><span class="badge <?= $p['status'] ?>"><?= $p['status'] ?></span></td>
                    <td><?= date('d/m H:i', strtotime($p['created_at'])) ?></td>
                    <td>
                        <form method="POST" action="update_status.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <select name="status" style="font-size:11px; padding:3px;">
                                <option value="baru" <?= $p['status']=='baru'?'selected':'' ?>>baru</option>
                                <option value="diproses" <?= $p['status']=='diproses'?'selected':'' ?>>diproses</option>
                                <option value="selesai" <?= $p['status']=='selesai'?'selected':'' ?>>selesai</option>
                            </select>
                            <button type="submit" class="update-btn">✔</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
        <?php else: ?>
            <p style="text-align:center; color:#aaa;">Belum ada pesanan masuk</p>
        <?php endif; ?>
    </div>

</div>
</body>
</html>