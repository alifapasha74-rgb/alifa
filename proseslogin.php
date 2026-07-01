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

    if ($found && password_verify($password, $hashedPassword)) {
        if ($role === 'admin') {
            header("Location: admin/index.php?error=1");
            exit();
        }

        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $role;

        // redirect balik ke halaman asal, default ke index.php
        $redirect = $_POST['redirect'] ?? 'index.php';
        $allowed  = ['index.php', 'produk.php', 'pesan.php', 'profil.php', 'kontak.php'];
        if (!in_array($redirect, $allowed)) {
            $redirect = 'index.php';
        }
        header("Location: " . $redirect);
        exit();

    } else {
        $redirect = $_POST['redirect'] ?? 'index.php';
        header("Location: login.php?error=1&redirect=" . urlencode($redirect));
        exit();
    }
} else {
    header("Location: login.php");
}
?>