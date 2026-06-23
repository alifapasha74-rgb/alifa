<link rel="stylesheet" href="style.css">
<div class="login-wrap">
    <div class="login-box">
        <form action="proseslogin.php" method="POST">
            <h2>Login Susu Mbok Darmi 🥛</h2>
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