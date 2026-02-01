<?php
session_start();
require_once "../config/database.php";

$success = $_SESSION["success"] ?? "";
$error = $_SESSION["error"] ?? "";

unset($_SESSION["success"], $_SESSION["error"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST["email"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if (!$email || !$password) {
    $_SESSION["error"] = "All fields are required";
    header("location: " . $_SERVER["PHP_SELF"]);
    exit();
  }

  $sqlQuery = 'SELECT * FROM "User" WHERE email = :email';
  $statement = $pdo->prepare($sqlQuery);
  $statement->execute(["email" => $email]);

  $user = $statement->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user["password"])) {
    $_SESSION["success"] = "Logging in...";
  } else {
    $_SESSION["error"] = "Invalid email or password";
  }

  header("Location: " . $_SERVER["PHP_SELF"]);
  exit();
}
