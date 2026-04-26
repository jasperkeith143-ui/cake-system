<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

// 🔐 ADMIN ONLY
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
?>

<?php include("../includes/header.php"); ?>

<style>
/* =========================
   UNIFIED SYSTEM UI (ADMIN)
========================= */
.action-cell {
    display: flex;
    gap: 8px;
    align-items: center;
}

/* keeps buttons same size + prevents stretching */
.action-cell .dash-btn {
    padding: 6px 10px;
    font-size: 13px;
    white-space: nowrap;
}
.main-container {
    margin-left: 220px;
    padding: 22px;
    font-family: Arial;
    color: #222;
    max-width: 1100px;
}

/* TOP HEADER BAR */
.top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

/* LOGO AREA */
.logo-area {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    background: #402B47;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}

/* TITLE */
.title {
    font-size: 20px;
    font-weight: 600;
}

/* BUTTONS */
.dashboard-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.dash-btn {
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: white;
    font-size: 14px;
    transition: 0.2s ease;
}

.btn-cakes {
    background: #402B47;
}

.btn-sales {
    background: #262423;
}

.btn-logout {
    background: #e74c3c;
}

.dash-btn:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}

/* STATS */
.stats-box {
    background: #fff;
    padding: 16px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-top: 10px;
}

.stats-box p {
    margin: 8px 0;
    font-size: 16px;
    color: #222;
}

/* CLEAN HR */
hr {
    border: none;
    border-top: 1px solid #eee;
    margin: 15px 0;
}
.title {
    font-size: 22px;
    font-weight: 700;
    color: #656161; /* strong dark color */
    letter-spacing: 0.5px;
}

/* optional glow for visibility */
.logo-area .title {
    text-shadow: 0px 1px 1px rgba(0,0,0,0.1);
}
</style>


<div class="main-container">

    <!-- TOP BAR WITH LOGO -->
<div class="top-bar">

    <div class="logo-area">
        <div class="logo">🍰</div>

        <!-- 👇 FIXED TITLE -->
        <div class="title">ADMIN DASHBOARD</div>
    </div>

</div>

    <!-- ACTION BUTTONS -->
    <div class="dashboard-actions">

        <a href="../cakes/list.php" class="dash-btn btn-cakes">🍰 Manage Cakes</a>

        <a href="../sales/dashboard.php" class="dash-btn btn-sales">📊 Sales Dashboard</a>
         
        <a href="../sales/reset.php" 
         class="dash-btn btn-logout"
         onclick="return confirm('⚠️ Are you sure you want to delete ALL transactions? This cannot be undone!')">
        🧹 Reset Transactions
        </a>

        <a href="../auth/logout.php" class="dash-btn btn-logout">🚪 Logout</a>

    </div>

    <hr>

    <?php
    $cakes = $conn->query("SELECT COUNT(*) FROM cakes")->fetchColumn();
    $revenue = $conn->query("SELECT SUM(total) FROM sales")->fetchColumn();
    ?>

    <!-- STATS -->
    <div class="stats-box">

        <p>🍰 Total Cakes available: <b><?= $cakes ?></b></p>
        <p>💰 Total Revenue: <b>₱<?= $revenue ?? 0 ?></b></p>

    </div>

</div>