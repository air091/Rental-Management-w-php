<?php
require_once realpath(__DIR__ . "/../configs/AuthDatabase.php");

class User
{
  public static function getAllUsers() {
    try {
      $pdo = AuthDatabase::connectAuthDB();
      $statement = $pdo->prepare("SELECT * FROM accounts");
      $statement->execute();
      $users = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $users ?? [];
    } catch (PDOException $err) {
      echo json_encode([
        "success" => false,
        "message" => $err->getMessage()
      ]);
      exit();
    }
  }

  public static function getUserByEmail(string $email)
  {
    try {
      $pdo = AuthDatabase::connectAuthDB();
      $statement = $pdo->prepare("SELECT * FROM accounts WHERE email = :email LIMIT 1");
      $statement->execute(["email" => $email]);
      $user = $statement->fetch(PDO::FETCH_ASSOC);
      return $user ?? null;
    } catch (PDOException $err) {
      echo json_encode([
        "success" => false,
        "message" => $err->getMessage()
      ]);
      exit();
    }
  }

  public static function insertUser(string $email, string $password) {
    try {
      $pdo = AuthDatabase::connectAuthDB();
      $statement = $pdo->prepare("INSERT INTO accounts (email, password) VALUES (:email, :password)");
      $statement->execute(["email" => $email, "password" => $password]);
      return (int)$pdo->lastInsertId();
    } catch (PDOException $err) {
      echo json_encode([
        "success" => false,
        "message" => $err->getMessage()
      ]);
      exit();
    }
  }
}
