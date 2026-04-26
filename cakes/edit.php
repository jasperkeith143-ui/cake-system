<?php include("../includes/header.php"); ?>
<?php
require_once("../config/db.php");

$id = $_GET['id'];

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE cakes SET name=?, price=?, stock=? WHERE id=?");
    $stmt->execute([$_POST['name'], $_POST['price'], $_POST['stock'], $id]);

    header("Location: list.php");
}

$data = $conn->prepare("SELECT * FROM cakes WHERE id=?");
$data->execute([$id]);
$c = $data->fetch();
?>

<h2>Edit Cake</h2>

<form method="POST">
    <input name="name" value="<?= $c['name'] ?>"><br>
    <input name="price" value="<?= $c['price'] ?>"><br>
    <input name="stock" value="<?= $c['stock'] ?>"><br>
    <button name="update">Update</button>
</form>
