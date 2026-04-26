<?php

function getTrendingCakes($conn) {

    // 📦 Get total sales per cake
    $salesData = $conn->query("
        SELECT c.name, SUM(s.qty) AS qty
        FROM sales s
        LEFT JOIN cakes c ON c.id = s.cake_id
        GROUP BY c.name
    ")->fetchAll(PDO::FETCH_ASSOC);

    $results = [];
    $maxScore = 0;

    // 🧠 Calculate raw ML score
    foreach ($salesData as $row) {

        $name = $row['name'];
        $qty = (int)$row['qty'];

        $popularityScore = $qty * 1.2;
        $trendBoost = rand(5, 25); // simple ML simulation

        $score = ($popularityScore * 0.7) + ($trendBoost * 0.3);

        if ($score > $maxScore) {
            $maxScore = $score;
        }

        $results[] = [
            "name" => $name,
            "raw_score" => $score
        ];
    }

    // 📊 Convert to percentage (0–100%)
    foreach ($results as &$r) {
        if ($maxScore > 0) {
            $r["score"] = round(($r["raw_score"] / $maxScore) * 100, 2);
        } else {
            $r["score"] = 0;
        }
        unset($r["raw_score"]);
    }

    // 🏆 Sort highest first
    usort($results, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    // 🔥 RETURN ONLY TOP 1
    return array_slice($results, 0, 1);
}
?>