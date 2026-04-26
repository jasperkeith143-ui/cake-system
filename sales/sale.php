<?php include("../includes/header.php"); ?>
<?php
require_once("../config/db.php");
$cakes = $conn->query("SELECT * FROM cakes")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Record Sale</h2>

<form method="POST" action="record.php">
    <select name="cake_id">
        <?php foreach ($cakes as $c) { ?>
            <option value="<?= $c['id'] ?>">
                <?= $c['name'] ?> - ₱<?= $c['price'] ?>
            </option>
        <?php } ?>
    </select>

    <input type="number" name="quantity" required>
    <button>Sell</button>
</form>
