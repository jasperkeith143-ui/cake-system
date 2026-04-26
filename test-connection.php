<?php

$host = "db.uswrwyptcjgrkilytvfh.supabase.co";
$port = "5432";
$db   = "postgres";
$user = "postgres";
$pass = "j4oel27tsp7lur7L";

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db;sslmode=require",
        $user,
        $pass
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Connected successfully to Supabase!";

} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}

?>