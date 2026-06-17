<?php
session_start();
require 'koneksi.php'; // pastikan file ini sudah diisi data database kamu
 
if (isset($_POST['btn_login'])) {
    $username = trim($_POST['txt_user']);
    $password = $_POST['txt_pass'];
 
    $stmt = mysqli_prepare($koneksi, "SELECT password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword);
    $found = mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
 
    if ($found && password_verify($password, $hashedPassword)) {
        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>
                alert('Username atau Password Salah!');
                window.location.href='login.php';
              </script>";
    }
} else {
    header("Location: login.php");
}