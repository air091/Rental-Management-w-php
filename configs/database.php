<?php
  $host = "localhost";
  $username = "postgres";
  $password = "root";
  $database = "rental_db_auth";
  $port = "5432";

  $dataSourceName = "pgsql:host=$host;port=$port;dbname=$database";

  try {
    $pdo = new PDO($dataSourceName, $username, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
  } catch(PDOException $e) {
    die("Database connection failed: ". $e->getMessage());
  }