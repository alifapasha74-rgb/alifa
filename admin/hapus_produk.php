<?php
session_start();
if (!isset($_SESSION['login_admin']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
include __DIR__ . '/koneksi.php';

$id = $_GET['id'] ?? '';
if ($id !== '' && is_numeric($id)) {
    mysqli_query($koneksi, "DELETE FROM produk WHERE id=$id");
}
header("Location: produk.php");
exit();