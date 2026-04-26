<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cake_id = $_POST['cake_id'];
    $qty = (int) $_POST['qty'];

    // 1. GET CAKE DATA
    $stmt = $conn->prepare("SELECT price, stock FROM cakes WHERE id = ?");
    $stmt->execute([$cake_id]);
    $cake = $stmt->fetch();

    if (!$cake) {
        die("Cake not found");
    }

    // 2. STOCK CHECK
    if ($cake['stock'] < $qty) {
        die("Not enough stock available");
    }

    // 3. COMPUTE TOTAL
    $total = $cake['price'] * $qty;

    // 4. AUTO INSERT SALE (THIS IS THE CORE UPGRADE)
    $insert = $conn->prepare("
        INSERT INTO sales (cake_id, qty, total)
        VALUES (?, ?, ?)
    ");
    $insert->execute([$cake_id, $qty, $total]);

    // 5. UPDATE STOCK AUTOMATICALLY
    $update = $conn->prepare("
        UPDATE cakes 
        SET stock = stock - ? 
        WHERE id = ?
    ");
    $update->execute([$qty, $cake_id]);

    // 6. REDIRECT BACK
    header("Location: dashboard.php");
    exit();
}
?>