<?php

session_start();


unset($_SESSION["login_admin"]);
unset($_SESSION["username_admin"]);
unset($_SESSION["role_admin"]);

header("Location: index.php");
exit();
?>