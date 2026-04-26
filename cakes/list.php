<?php include("../includes/header.php"); ?>
<?php
require_once("../config/db.php");
$cakes = $conn->query("SELECT * FROM cakes")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>

/* =========================
   EMPLOYEE-STYLE INVENTORY UI
========================= */

.main-container {
    margin-left: 220px;
    padding: 20px;
    font-family: Arial;
    color: #222;
}

/* HEADER */
.page-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.page-title h2 {
    font-size: 20px;
    margin: 0;
    color: #aca9a9;
}

/* BUTTON */
.dash-btn {
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
    text-decoration: none;
    color: white;
    background: #402B47;
    display: inline-block;
}

/* CARD TABLE WRAPPER */
.table-card {
    background: #fff;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

th {
    background: #402B47;
    color: white;
    padding: 10px;
    text-align: left;
}

td {
    padding: 8px 10px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f7f7f7;
}

/* ACTION BUTTONS */
.action-cell {
    display: flex;
    gap: 6px;
    align-items: center;
}

/* DELETE BUTTON */
.btn-delete {
    background: #e74c3c;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

.btn-edit {
    background: #402B47;
    color: white;
    padding: 6px 10px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

</style>

<div class="main-container">

    <!-- HEADER -->
    <div class="page-title">

        <h2>🍰 Cake Inventory</h2>

        <a href="add.php" class="dash-btn">➕ Add Cake</a>

    </div>

    <!-- TABLE CARD -->
    <div class="table-card">

        <table>

            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Action</th>
            </tr>

            <?php foreach ($cakes as $c) { ?>
            <tr>
                <td><?= $c['name'] ?></td>
                <td><?= $c['price'] ?></td>
                <td><?= $c['stock'] ?></td>

                <td class="action-cell">

                    <a href="edit.php?id=<?= $c['id'] ?>" class="btn-edit">Edit</a>

                    <a href="delete.php?id=<?= $c['id'] ?>" class="btn-delete">Delete</a>

                </td>
            </tr>
            <?php } ?>

        </table>

    </div>

</div>