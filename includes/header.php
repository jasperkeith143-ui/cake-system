
<link rel="stylesheet" href="/cake-system/assets/style.css">


<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="sidebar">

    <h2>Cake System</h2>

  <!-- ADMIN LINKS -->
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="../admin/dashboard.php">🏠 Admin Dashboard</a>
    <a href="../cakes/list.php">🍰 Manage Cakes</a>
    <a href="../sales/dashboard.php">📊 Sales</a>

    <!-- NEW: ANALYTICS -->
    <a href="../analytics/charts.php">📈 Analytics & Charts</a>
<?php endif; ?>

    <!-- EMPLOYEE LINKS -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'employee'): ?>
        <a href="../employee/dashboard.php">🏠 Employee Dashboard</a>
        <a href="../employee/add.php">➕ Add Cake</a>
       
    <?php endif; ?>

    <!-- CUSTOMER LINKS -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'): ?>
        <a href="../customer/dashboard.php">🍰 Shop Cakes</a>
    <?php endif; ?>

</div>