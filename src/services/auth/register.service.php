<?php
require realpath(__DIR__ . "/../../../vendor/autoload.php");
require realpath(__DIR__ . "/../../config/database.php");

use MongoDB\BSON\UTCDateTime;

session_start();

// STATUS
$error = $_SESSION["error"] ?? "";
unset($_SESSION["error"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $database = MongoDBConnection::getDB();
  $usersCollection = $database->users;


  // CREDENTIALS
  $email = (string) $_REQUEST["email"] ?? "";
  $password = (string) $_REQUEST["password"] ?? "";

  if (empty($email) || empty($password)) {
    $_SESSION["error"] = "All fields are required";
    header("Location: /rental-management/src/views/auth/register.view.php");
    exit();
  }

  $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  $userData = (array) array("email" => $email, "password" => $passwordHash, "created_at" => new UTCDateTime(), "updated_at" => new UTCDateTime());

  try {
    $insertResult = $usersCollection->insertOne($userData);
    echo ("User registered successful (" . $insertResult->getInsertedId() . ")");
  } catch (Exception $err) {
    die("Error registration: " . $err->getMessage());
  }
}
