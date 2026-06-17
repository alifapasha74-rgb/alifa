<?php
session_start();
$error   = $_GET['error']   ?? '';
$success = $_GET['success'] ?? '';
?>
<link rel="stylesheet" href="style.css">
<div class="login-wrap">
    <div class="login-box">
        <form action="prosesregister.php" method="POST">
            <h2>Daftar Admin Susu Mbok Darmi 🥛</h2>
 
            <?php if ($error): ?>
                <p style="color:red; font-size:14px;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
 
            <?php if ($success): ?>
                <p style="color:green; font-size:14px;"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>
 
            <label>Username:</label>
            <input type="text" name="txt_user" required>
 
            <label>Password:</label>
            <input type="password" name="txt_pass" required minlength="6">
            <small style="color:red; display:block; text-align:left;">*Password minimal 6 karakter</small>
 
            <label>Ulangi Password:</label>
            <input type="password" name="txt_pass2" required>
 
            <button type="submit" name="btn_register">Daftar</button>
 
            <p style="margin-top:15px; text-align:center; font-size:14px;">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </p>
        </form>
    </div>
</div>