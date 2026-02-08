<?php
require realpath(__DIR__ . "/../../config/database.php");
require realpath(__DIR__ . "/../../../vendor/autoload.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["success" => false, 
                    "error" => "Invalid request"]);
  exit();
}

$database = MongoDBConnection::getDB();
$userCollection = $database->users;

$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

$errors = [];
if (empty($email)) $errors[] = "Email is required";
if (empty($password)) $errors[] = "Password is required";
if (!empty($errors)) {
  echo json_encode(["success" => false, 
                    "error" => implode("<br>", $errors)]);
  exit();
}

try {
  $user = $userCollection->findOne(["email" => $email]);
  if (empty($user) || !password_verify($password, $user["password"])) {
    echo json_encode(["success" => false, 
                      "error" => "Invalid email or password"]);
    exit();
  }

  echo json_encode(["success" => true, 
                    "message" => "User logged in successfully","userId" => $user["_id"]]);
} catch (Exception $err) {
  echo json_encode(["success" => false, 
                    "error" => "Login error: " . $err->getMessage()]);
}
