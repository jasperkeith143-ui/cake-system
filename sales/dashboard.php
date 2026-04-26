<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

// 🔐 LOGIN CHECK
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
?>

<style>
/* =======================
   MATCHED UI (cakes page)
========================== */

.main-container {
    margin-left: 260px;  /* moved more to the right */
    padding: 22px;
    width: calc(100% - 280px);
    max-width: 1100px;
    font-family: Arial;
    color: #222;
}

/* HEADER CENTERED LIKE cakes UI */
.page-header {
    text-align: center;
    margin-bottom: 18px;
}

.page-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #402B47;
}

/* STATS BOX MATCH STYLE */
.stats-box {
    background: #fff;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    font-size: 15px;
}

/* TABLE UI (exact same styling as cakes) */
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
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

/* MOBILE FIX */
@media (max-width: 768px) {
    .main-container {
        margin-left: 0;
        width: 100%;
    }
}
</style>

<div class="main-container">

    <!-- CENTERED TITLE LIKE CAKES PAGE -->
    <div class="page-header">
        <h2>📊 Sales Dashboard</h2>
        

    </div>

    <?php
    $totalSales = $conn->query("SELECT COUNT(*) FROM sales")->fetchColumn();
    $totalRevenue = $conn->query("SELECT SUM(total) FROM sales")->fetchColumn();
    ?>

    <!-- STATS BOX SAME UI AS CAKES -->
    <div class="stats-box">
        <p>📦 Total Transactions: <b><?= $totalSales ?></b></p>
        <p>💰 Total Revenue: <b>₱<?= $totalRevenue ?? 0 ?></b></p>
    </div>

    <!-- SALES TABLE (MATCHED UI) -->
    <table>
        <tr>
            <th>Cake Name</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>

        <?php
        $sales = $conn->query("
            SELECT c.name AS cake_name, s.qty, s.total
            FROM sales s
            LEFT JOIN cakes c ON c.id = s.cake_id
            ORDER BY s.id DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($sales as $s) {
        ?>
        <tr>
            <td><?= $s['cake_name'] ?? 'Unknown' ?></td>
            <td><?= $s['qty'] ?></td>
            <td>₱<?= $s['total'] ?></td>
        </tr>
        <?php } ?>
    </table>

</div>