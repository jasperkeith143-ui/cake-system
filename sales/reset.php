<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

// 🔐 ADMIN ONLY
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// 💣 DELETE ALL SALES
$stmt = $conn->prepare("DELETE FROM sales");
$stmt->execute();

// 🔁 BACK TO DASHBOARD
header("Location: dashboard.php?reset=success");
exit();
?>