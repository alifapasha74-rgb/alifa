<?php
session_start();
require 'koneksi.php';

if (isset($_POST['btn_login'])) {
    $username = trim($_POST['txt_user']);
    $password = $_POST['txt_pass'];

    $stmt = mysqli_prepare($koneksi, "SELECT password, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword, $role);
    $found = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($found && password_verify($password, $hashedPassword) && $role === 'admin') {
        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $role;
        header("Location: produk.php");
        exit();
    } else {
        header("Location: index.php?error=1");
        exit();
    }
} else {
    header("Location: index.php");
}
?>