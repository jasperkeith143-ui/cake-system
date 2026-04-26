<?php
$host = "localhost";
$port = "5432";
$db   = "cake_system";
$user = "postgres";
$pass = "1234"; // your PostgreSQL password

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    error_log("DB ERROR: " . $e->getMessage());
    echo "<div class='error-box'>⚠️ Database connection failed.</div>";
    exit();
}
?>