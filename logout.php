<?php
session_start();
session_destroy();
header("Location: login.php");
exit();
?>

<nav id="mainNav">
    <a href="index.php">Beranda</a>
    <a href="profil.php">Profil</a>
    <a href="produk.php">Produk</a>
    <a href="pesan.php">Pesan</a>
    <a href="kontak.php">Kontak</a>
     <a href="logout.php" class="active">logout</a>
</nav>