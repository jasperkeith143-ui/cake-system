<?php include("../includes/header.php"); ?>
<?php
require_once("../config/db.php");

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM cakes WHERE id=?");
$stmt->execute([$id]);

header("Location: list.php");
?>
