<?php
session_start();
require_once("../configs/database.php");

$error = $_SESSION["error"] ?? "";
unset($_SESSION["error"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $firstname = trim($_POST["firstname"] ?? "");
  $lastname = trim($_POST["lastname"] ?? "");
  $contactNum = trim($_POST["contactNum"] ?? "");
  $email = trim($_POST["email"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if (empty($firstname)) {
    $_SESSION["error"] = "Firstname is required";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  }

  if (empty($email) && empty($password)) {
    $_SESSION["error"] = "All fields are required";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  }

  if (empty($email)) {
    $_SESSION["error"] = "Email is required";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  }

  if (empty($password)) {
    $_SESSION["error"] = "Password is required";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  }

  if (strlen($password) < 4) {
    $_SESSION["error"] = "Password must have 4 characters long";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  } 

  
  $insertQueryToProfile = 'INSERT INTO "Profile" (firstname, lastname, contactNum)
                          VALUES (:firstname, :lastname, :contactNum)';
  $insertQueryToUser = 'INSERT INTO "User" (email, password)
                        VALUES (:email, :password)';
  try {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $pdo->beginTransaction();

    $statementForProfile = $pdo->prepare($insertQueryToProfile);
    $statement = $pdo->prepare($insertQueryToUser);

    $statementForProfile->execute([":firstname" => $firstname, ":lastname" => $lastname, ":contactNum" => $contactNum]);
    $statement->execute([":email" => $email, ":password" => $hashedPassword]);

    $pdo->commit();
    header("Location: ../html/client/dashboard.php");
    exit();
  } catch (PDOException $e) {
    $pdo->rollBack();
    error_log($e->getMessage());
    $_SESSION["error"] = "Something went wrong";
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
  }
}
