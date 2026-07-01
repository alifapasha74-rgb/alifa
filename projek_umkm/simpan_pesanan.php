<?php
// File: projek_umkm/simpan_pesanan.php
session_start();
require 'koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false]);
    exit();
}

$nama   = trim($_POST['nama'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$hp     = trim($_POST['hp'] ?? '');
$bayar  = trim($_POST['bayar'] ?? '');
$total  = intval($_POST['total'] ?? 0);
$detail = trim($_POST['detail'] ?? '');
$items  = json_decode($_POST['items'] ?? '[]', true);

if (!$nama || !$alamat || !$hp || !$detail) {
    echo json_encode(['success' => false]);
    exit();
}

// Simpan pesanan utama
$stmt = mysqli_prepare($koneksi, "INSERT INTO pesanan (nama, alamat, hp, bayar, total, detail) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'ssssis', $nama, $alamat, $hp, $bayar, $total, $detail);
mysqli_stmt_execute($stmt);
$pesanan_id = mysqli_insert_id($koneksi);
mysqli_stmt_close($stmt);

// Simpan detail per produk
if ($pesanan_id && is_array($items)) {
    foreach ($items as $item) {
        $nama_produk = $item['nama'] ?? '';
        $qty         = intval($item['qty'] ?? 0);
        $harga       = intval($item['harga'] ?? 0);
        $subtotal    = $qty * $harga;

        $stmt2 = mysqli_prepare($koneksi, "INSERT INTO detail_pesanan (pesanan_id, nama_produk, qty, harga, subtotal) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt2, 'isiii', $pesanan_id, $nama_produk, $qty, $harga, $subtotal);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    }
}

echo json_encode(['success' => true]);
exit();
?>