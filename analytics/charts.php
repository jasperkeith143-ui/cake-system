<?php
session_start();
require_once("../config/db.php");
require_once("../ml/trend_engine.php");

$trendingCakes = getTrendingCakes($conn);

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

/* =========================
   DATA
========================= */
$monthly = $conn->query("
    SELECT 
        TO_CHAR(created_at, 'Mon') AS month,
        EXTRACT(MONTH FROM created_at) AS month_num,
        SUM(total) AS total
    FROM sales
    GROUP BY month, month_num
    ORDER BY month_num
")->fetchAll(PDO::FETCH_ASSOC);

$topCakes = $conn->query("
    SELECT c.name, SUM(s.qty) AS qty
    FROM sales s
    LEFT JOIN cakes c ON c.id = s.cake_id
    GROUP BY c.name
    ORDER BY qty DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

$allCakes = $conn->query("
    SELECT c.name, SUM(s.qty) AS qty
    FROM sales s
    LEFT JOIN cakes c ON c.id = s.cake_id
    GROUP BY c.name
")->fetchAll(PDO::FETCH_ASSOC);

$cakeLabels = array_column($allCakes, 'name');
$cakeData = array_column($allCakes, 'qty');

include("../includes/header.php");
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* =========================
   GLOBAL
========================= */
body {
    margin: 0;
    background: #1e1b23;
    font-family: Arial, sans-serif;
}

/* SIDEBAR */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 240px;
    height: 100vh;
    z-index: 1000;
}

/* HEADER */
.header {
    position: fixed;
    top: 0;
    left: 240px;
    right: 0;
    height: 70px;
    z-index: 900;
}

/* =========================
   CENTERED COMPACT DASHBOARD
========================= */
.main-container {
    margin-left: 240px;
    margin-top: 80px;

    /* 🔥 KEY FIX: no full stretch */
    width: 1200px;

    /* 🔥 move slightly left instead of perfect center */
    margin-right: auto;
    margin-left: 285px;

    padding: 16px;

    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;

    align-content: start;
}
/* TITLE */
.title {
    grid-column: 1 / -1;
    text-align: center;
    font-size: 20px;
    font-weight: 700;
    color: #ffffff;
}

/* =========================
   SMALL CLEAN CARDS
========================= */
.chart-card {
    background: linear-gradient(145deg, #2a2630, #232028);
    padding: 12px;
    border-radius: 12px;

    box-shadow: 0 6px 14px rgba(0,0,0,0.35);
    border: 1px solid rgba(255,255,255,0.05);

    min-height: 230px;
    max-height: 250px;

    display: flex;
    flex-direction: column;
}

/* TITLE INSIDE CARD */
.chart-card h3 {
    font-size: 12px;
    margin-bottom: 6px;
    color: #f1f1f1;
}

/* CHART SIZE (COMPACT) */
canvas {
    width: 100% !important;
    height: 160px !important;
}

/* TEXT */
.chart-card p {
    color: #cfcfcf;
    font-size: 13px;
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width: 1200px) {
    .main-container {
        width: 100%;
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .main-container {
        grid-template-columns: 1fr;
    }
}

</style>

<div class="main-container">

    <div class="title">📊 Advanced Analytics Dashboard</div>

    <!-- LINE -->
    <div class="chart-card">
        <h3>📈 Monthly Sales</h3>
        <canvas id="lineChart"></canvas>
    </div>

    <!-- BAR -->
    <div class="chart-card">
        <h3>🔥 Top Cakes</h3>
        <canvas id="barChart"></canvas>
    </div>

    <!-- PIE -->
    <div class="chart-card">
        <h3>🍰 Distribution</h3>
        <canvas id="pieChart"></canvas>
    </div>

    <!-- AI TREND -->
    <div class="chart-card">
        <h3>🔥 Trending Cake</h3>

        <?php if (!empty($trendingCakes)): ?>
            <p>🏆 <b><?= htmlspecialchars($trendingCakes[0]['name']) ?></b></p>
            <p>Score: <?= $trendingCakes[0]['score'] ?>%</p>
        <?php else: ?>
            <p>No data</p>
        <?php endif; ?>

    </div>

</div>

<script>
Chart.defaults.color = "#eaeaea";

/* LINE */
new Chart(document.getElementById("lineChart"), {
    type: "line",
    data: {
        labels: <?= json_encode(array_column($monthly, 'month')) ?>,
        datasets: [{
            label: "Sales",
            data: <?= json_encode(array_column($monthly, 'total')) ?>,
            borderColor: "#C3A6CB",
            backgroundColor: "rgba(195,166,203,0.15)",
            fill: true,
            tension: 0.4
        }]
    }
});

/* BAR */
new Chart(document.getElementById("barChart"), {
    type: "bar",
    data: {
        labels: <?= json_encode(array_column($topCakes, 'name')) ?>,
        datasets: [{
            label: "Qty",
            data: <?= json_encode(array_column($topCakes, 'qty')) ?>,
            backgroundColor: "#6A4C93"
        }]
    }
});

/* PIE */
new Chart(document.getElementById("pieChart"), {
    type: "pie",
    data: {
        labels: <?= json_encode($cakeLabels) ?>,
        datasets: [{
            data: <?= json_encode($cakeData) ?>,
            backgroundColor: [
                "#402B47","#6A4C93","#9B6FAF",
                "#C3A6CB","#E0C3E8"
            ]
        }]
    }
});
</script>