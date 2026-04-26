<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("../config/db.php");

// optional protection (only logged users)
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

// fetch live cakes from admin CRUD
$cakes = $conn->query("SELECT * FROM cakes ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="main">

    <h1>🍰 Welcome, <?= $_SESSION['user']; ?></h1>
    <p>Explore available cakes</p>

    <div class="dashboard-actions">
        <a href="../auth/logout.php" class="dash-btn btn-sales">🚪 Logout</a>
    </div>

    <hr>

    <h2>Available Cakes</h2>

    <div class="cake-grid">

        <?php foreach ($cakes as $c): ?>

            <div class="card">

                <h3><?= $c['name']; ?></h3>

                <p>💰 Price: ₱<?= $c['price']; ?></p>
                <p>📦 Stock: <?= $c['stock']; ?></p>

                <!-- customer interaction -->
                <form method="POST" action="order.php">
                    <input type="hidden" name="cake_id" value="<?= $c['id']; ?>">

                    <input type="number" name="qty" min="1" max="<?= $c['stock']; ?>" placeholder="Qty" required>

                    <button class="btn btn-create">Order</button>
                </form>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>