<?php
// File: projek_umkm/login-ajax.php
session_start();
require 'koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method tidak valid']);
    exit();
}

$username = trim($_POST['txt_user'] ?? '');
$password = $_POST['txt_pass'] ?? '';

if (!$username || !$password) {
    echo json_encode(['success' => false, 'message' => 'Username dan password wajib diisi']);
    exit();
}

$stmt = mysqli_prepare($koneksi, "SELECT password, role FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $hashedPassword, $role);
$found = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($found && password_verify($password, $hashedPassword) && $role === 'user') {
    $_SESSION['login_user'] = true;
    $_SESSION['login']      = true;
    $_SESSION['username']   = $username;
    $_SESSION['role']       = $role;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Username atau password salah']);
}
exit();
?>