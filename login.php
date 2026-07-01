<?php session_start(); ?>
<link rel="stylesheet" href="style.css">
<div class="login-wrap">
    <div class="login-box">
        <form action="proseslogin.php" method="POST">

            <?php if (isset($_GET['error'])): ?>
            <div class="error-msg">❌ Username atau Password Salah!</div>
            <?php endif; ?>

            <h2>Login Susu Mbok Darmi 🥛</h2>

            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect'] ?? 'index.php') ?>">

            <label>Username:</label>
            <input type="text" name="txt_user" required>

            <label>Password:</label>
            <input type="password" name="txt_pass" required>

            <button type="submit" name="btn_login">Masuk</button>

            <p style="margin-top:15px; text-align:center; font-size:14px;">
                Belum punya akun? <a href="register.php">Daftar di sini</a>
            </p>
        </form>
    </div>
</div>