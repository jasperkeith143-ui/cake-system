<?php

$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$db   = getenv("DB_NAME");
$user = getenv("DB_USER");
$pass = getenv("DB_PASSWORD");

if (!$host || !$port || !$db || !$user || !$pass) {
    die("⚠️ Missing database environment variables.");
}

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db;sslmode=require",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    die("⚠️ Database connection failed: " . $e->getMessage());
}

?>