<?php

$host = "db.uswrwyptcjgrkilytvfh.supabase.co";
$port = "5432";
$db   = "postgres";
$user = "postgres";
$pass = "j4oel27tsp7lur7L";

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$db",
        $user,
        $pass
    );

    echo "✅ Connected successfully";

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}

?>