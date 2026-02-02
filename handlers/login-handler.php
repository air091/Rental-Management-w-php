<?php
  session_start();
  require_once("../configs/database.php");

  $error = $_SESSION["error"] ?? "";
  unset($_SESSION["error"]);

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

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

    try {
      $selectQuery = 'SELECT id, password FROM "User" WHERE email = :email';
      $statement = $pdo->prepare($selectQuery);
      $statement->execute([":email" => $email]);

      $user = $statement->fetch(PDO::FETCH_ASSOC);
      if (!$user) {
        $_SESSION["error"] = "Invalid email or password";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
      }
      if (!password_verify($password, $user["password"])) {
        $_SESSION["error"] = "Invalid email or password";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
      }

      header("Location: ../html/client/dashboard.php");
      exit();
    } catch(PDOException $e) {
      error_log($e->getMessage());
      $_SESSION["error"] = "Something went wrong";
      header("Location" . $_SERVER["PHP_SELF"]);
      exit();
    }

  }