<?php
session_start();

// 🧹 CLEAR ALL SESSION DATA
$_SESSION = [];

// 🧨 DESTROY SESSION
session_destroy();

// 🧭 REDIRECT TO LOGIN
header("Location: login.php");
exit();
?>