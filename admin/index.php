<?php
session_start();
if (isset($_SESSION['login_admin'])) {
    header("Location: produk.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Susu Mbok Darmi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap" style="background: linear-gradient(135deg, #fff3e0, #ffe0b2);">
    <div class="login-box">
        <div class="emoji">🔐</div>
        <h2>Login Admin</h2>
        <p>Khusus Pengelola Susu Mbok Darmi</p>

        <?php if (isset($_GET['error'])): ?>
        <div class="error-msg">❌ Username atau password salah</div>
        <?php endif; ?>

        <form action="proses_login_admin.php" method="POST">
            <label>👤 Username</label>
            <input type="text" name="txt_user" required>
            <label>🔒 Password</label>
            <input type="password" name="txt_pass" required>
            <button type="submit" name="btn_login">🚀 Masuk sebagai Admin</button>
        </form>
    </div>
</div>
</body>
</html>