<?php
$host = "localhost";
$database = "rental_db_auth";
$user = "postgres";
$password = "root";
$port = "5432";

try {
  $pdo = new PDO(
    "pgsql:host=$host;port=$port;dbname=$database",
    $user,
    $password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
  );
  echo "Database connected";
} catch (PDOException $e) {
  die("Database Connection Failed " . $e->getMessage());
}
