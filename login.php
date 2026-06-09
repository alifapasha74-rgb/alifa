<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Susu Mbok Darmi — Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-wrap">
    <div class="login-box">
        <div class="emoji">🥛</div>
        <h2>Login Admin Susu Mbok Darmi</h2>
        <p>Masukkan username dan password kamu 🐄</p>

        <?php if(isset($_GET['error'])): ?>
        <div class="error-msg">❌ Username atau Password Salah!</div>
        <?php endif; ?>

        <form action="proseslogin.php" method="POST">
            <label>👤 Username</label>
            <input type="text" name="txt_user" placeholder="Masukkan username" required>

            <label>🔒 Password</label>
            <input type="password" name="txt_pass" placeholder="Masukkan password" required>

            <button type="submit" name="btn_login">🚀 Masuk</button>
        </form>
    </div>
</div>
</body>
</html>