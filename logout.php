<?php

session_start();


unset($_SESSION["login_user"]);
unset($_SESSION["username_user"]);
unset($_SESSION["role_user"]);

header("Location: login.php");
exit();
?>