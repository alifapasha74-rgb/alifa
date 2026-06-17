<?php
session_start();
include 'koneksi.php'; // GANTI dengan nama file koneksi database yang dipakai proseslogin.php kamu
 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}
 
$username  = trim($_POST['txt_user']  ?? '');
$password  = $_POST['txt_pass']       ?? '';
$password2 = $_POST['txt_pass2']      ?? '';
 

if ($username === '' || $password === '' || $password2 === '') {
    header('Location: register.php?error=' . urlencode('Semua field wajib diisi'));
    exit;
}
 
if ($password !== $password2) {
    header('Location: register.php?error=' . urlencode('Password dan konfirmasi tidak sama'));
    exit;
}
 
if (strlen($password) < 6) {
    header('Location: register.php?error=' . urlencode('Password minimal 6 karakter'));
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT id FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
 
if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    header('Location: register.php?error=' . urlencode('Username sudah dipakai, pilih username lain'));
    exit;
}
mysqli_stmt_close($stmt);
 

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
 
$stmt = mysqli_prepare($koneksi, "INSERT INTO users (username, password) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, 'ss', $username, $hashedPassword);
 
if (mysqli_stmt_execute($stmt)) {
    header('Location: login.php?success=' . urlencode('Registrasi berhasil, silakan login'));
} else {
    header('Location: register.php?error=' . urlencode('Gagal mendaftar, coba lagi'));
}
mysqli_stmt_close($stmt);

?>