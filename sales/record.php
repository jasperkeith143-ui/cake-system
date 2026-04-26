<?php include("../includes/header.php"); ?>
<?php
require_once("../config/db.php");

$cake_id = $_POST['cake_id'];
$qty = $_POST['quantity'];

$stmt = $conn->prepare("SELECT * FROM cakes WHERE id=?");
$stmt->execute([$cake_id]);
$cake = $stmt->fetch();

$total = $cake['price'] * $qty;

$conn->prepare("INSERT INTO sales (cake_id, quantity, total)
VALUES (?, ?, ?)")->execute([$cake_id, $qty, $total]);

$conn->prepare("UPDATE cakes SET stock = stock - ? WHERE id=?")
     ->execute([$qty, $cake_id]);

header("Location: sale.php");
?>

