<?php
if (isset($_POST['btn_login'])) {

    $username = $_POST['txt_user'];
    $password = $_POST['txt_pass'];

    // LOGIKA KONDISIONAL STATIS
    // Kita tentukan username default: admin, password: 123

    if ($username == "admin" && $password == "123") {
        echo "<h2>Login Berhasil! Selamat datang Admin UMKM.</h2>";
        echo "<a href='index.php'>Ke Halaman Utama</a>";
    } else {
        echo "<script>
                alert('Username atau Password Salah!');
                window.location.href='login.php';
              </script>";
    }

} else {
    header("Location: login.php");
}
?>