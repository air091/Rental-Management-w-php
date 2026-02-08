<?php
require realpath(__DIR__ . "/../../../vendor/autoload.php");
require realpath(__DIR__ . "/../../config/database.php");

use MongoDB\BSON\UTCDateTime;

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $database = MongoDBConnection::getDB();
  $usersCollection = $database->users;

  // CREDENTIALS
  $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
  $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

  $errors = [];
  if (empty($email)) $errors[] = "Email is required";
  if (empty($password)) $errors[] = "Password is required";

  if (!empty($errors)) {
    echo json_encode(["success" => false, "error" => implode("<br>", $errors)]);
    exit();
  }

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $userData = (array) array("email" => $email, "password" => $passwordHash, "created_at" => new UTCDateTime(), "updated_at" => new UTCDateTime());

  try {
    $insertResult = $usersCollection->insertOne($userData);
    echo json_encode(["success" => true, "userId" => (string)$insertResult->getInsertedId()]);  
  } catch (Exception $err) {
    echo json_encode(["success" => false, "error" => "Error registration: " . $err->getMessage()]);
  }
}
