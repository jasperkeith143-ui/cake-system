<?php
session_start();
require_once("../config/db.php");

if ($_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("
        INSERT INTO cakes (name, price, stock)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$name, $price, $stock]);

    header("Location: dashboard.php");
    exit();
}
?>
<link rel="stylesheet" href="../assets/form-ui.css">

<style>
/* BACK BUTTON STYLE MATCHING EMPLOYEE UI */
.back-btn {
    display: inline-block;
    padding: 8px 12px;
    background: #402B47;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    margin-left: 20px;
    margin-top: 20px;
}

.back-btn:hover {
    opacity: 0.9;
}
</style>

<!-- BACK BUTTON -->
<a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

<div class="form-container">

    <div class="form-card">

        <h2>➕ Add Cake</h2>

        <form method="POST">

            <input name="name" placeholder="Cake Name" required>
            <input name="price" placeholder="Price" required>
            <input name="stock" placeholder="Stock" required>

            <button name="add">Save Cake</button>

        </form>

    </div>

</div>