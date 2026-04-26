<?php
session_start();
require_once("../config/db.php");

// 🔐 Employee only
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit();
}

// 🍰 Get cakes
$cakes = $conn->query("SELECT * FROM cakes")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../includes/header.php"); ?>

<style>
/* KEEPING YOUR EXISTING EMPLOYEE UI */

.main {
    margin-left: 220px;
    padding: 22px;
    font-family: Arial;
}

h1 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
}

/* BUTTONS */
.btn {
    padding: 8px 12px;
    background: #402B47;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
}

.btn:hover {
    opacity: 0.9;
}

.btn-logout {
    background: #e74c3c;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

th {
    background: #402B47;
    color: white;
    padding: 10px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

tr:hover {
    background: #f9f9f9;
}

</style>

<div class="main">

    <h1>🍰 Employee Dashboard</h1>

    <!-- BUTTONS -->
    <a href="../auth/logout.php" class="btn btn-logout">🚪 Logout</a>

    <br><br>

    <!-- CAKE LIST TABLE -->
    <table>

        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
        </tr>

        <?php foreach ($cakes as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['price']) ?></td>
            <td><?= htmlspecialchars($c['stock']) ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>