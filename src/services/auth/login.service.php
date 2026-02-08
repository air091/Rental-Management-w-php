<?php
ini_set("display_errors", 0);
error_reporting(0);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require realpath(__DIR__ . "/../../config/database.php");
require realpath(__DIR__ . "/../../../vendor/autoload.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode([
    "success" => false,
    "error" => "Invalid request"
  ]);
  exit();
}

$database = MongoDBConnection::getDB();
$userCollection = $database->users;

$config = require realpath(__DIR__ . "/../../config/jwt.php");

$email = trim($_POST["email"]) ?? "";
$password = trim($_POST["password"]) ?? "";

$errors = [];
if (empty($email)) $errors[] = "Email is required";
if (empty($password)) $errors[] = "Password is required";
if (!empty($errors)) {
  echo json_encode([
    "success" => false,
    "error" => implode(", ", $errors)
  ]);
  exit();
}

try {
  $user = $userCollection->findOne(["email" => $email]);
  if (empty($user) || !password_verify($password, $user["password"])) {
    echo json_encode([
      "success" => false,
      "error" => "Invalid email or password"
    ]);
    exit();
  }

  $payload = [
    "iss" => $config["issuer"],
    "iat" => time(),
    "exp" => time() + $config["expire"],
    "sub" => (string) $user["_id"],
    "email" => $user["email"]
  ];

  $token = JWT::encode($payload, $config["secret"], "HS256");
  echo json_encode([
    "success" => true,
    "token" => $token,
  ]);
  exit();
} catch (Exception $err) {
  echo json_encode([
    "success" => false,
    "error" => "Login error: " . $err->getMessage()
  ]);
}
