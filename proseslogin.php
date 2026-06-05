<?php
session_start();
if (isset($_POST['btn_login'])) {
    $username = $_POST['txt_user'];
    $password = $_POST['txt_pass'];

    if ($username == "admin" && $password == "123") {
        $_SESSION["login"] = true;
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
?>