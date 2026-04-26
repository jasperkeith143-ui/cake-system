<?php include("../includes/header.php"); ?>
<?php
require_once("../config/db.php");

if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO cakes (name, price, stock) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['stock']]);

    header("Location: list.php");
}
?>

<h2>Add Cake</h2>

<form method="POST">
    <input name="name" placeholder="Cake Name" required><br>
    <input name="price" placeholder="Price" required><br>
    <input name="stock" placeholder="Stock" required><br>
    <button name="add">Save</button>
</form>
