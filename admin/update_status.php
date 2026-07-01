<?php
session_start();
if (!isset($_SESSION['login_admin']) && !isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}
include __DIR__ . '/koneksi.php';

$id     = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? 'baru';

if ($id > 0) {
    $stmt = mysqli_prepare($koneksi, "UPDATE pesanan SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: dashboard.php");
exit();
?>