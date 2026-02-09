<?php
require_once realpath(__DIR__ . "/../models/User.php");
require_once realpath(__DIR__ . "/../../vendor/autoload.php");

use Firebase\JWT\JWT;

class AuthController
{
  public static function login()
  {
    $input = json_decode(file_get_contents("php://input"), true); // to get data
    // create credentials
    $email = isset($input["email"]) ? trim($input["email"]) : "";
    $password = isset($input["password"]) ? trim($input["password"]) : "";
    // validates if there are credentials
    if (empty($email) || empty($password)) {
      echo json_encode([
        "success" => false,
        "error" => "All fields are required",
      ]);
      return;
    }

    try {
      $user = User::findUserByEmail($email);
      if (!$user || !password_verify($password, $user["password"])) {
        echo json_encode([
          "success" => false,
          "error" => "Invalid email or password",
        ]);
        return;
      }

      $config = require __DIR__ . "/../config/jwt.php";
      $payload = [
        "iss" => $config["issuer"],
        "iat" => time(),
        "exp" => time() + $config["expire"],
        "sub" => (string) $user["_id"],
        "role" => $user["role"] ?? "user",
      ];

      $token = JWT::encode($payload, $config["secret"], "HS256");
      echo json_encode([
        "success" => true,
        "token" => $token,
      ]);
    } catch (Exception $e) {
      die("Login failed: " . $e->getMessage());
    }
  }

  public static function register()
  {
    $input = json_decode(file_get_contents("php://input"), true);

    $email = isset($input["email"]) ? trim($input["email"]) : "";
    $password = isset($input["password"]) ? trim($input["password"]) : "";

    // validate
    if (empty($email) || empty($password)) {
      echo json_encode([
        "success" => false,
        "error" => "All fields are required",
      ]);
      return;
    }

    try {
      // check if user exist
      $existingUser = User::findUserByEmail($email);
      if (isset($existingUser)) {
        echo json_encode([
          "success" => false,
          "error" => "Email is already registered",
        ]);
        return;
      }

      // hash password
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      // insert to database
      $user = User::createUser([
        "email" => $email,
        "password" => $passwordHash,
        "role" => "user",
      ]);

      // get inserted user by id after user created
      $userId = (string) $user->getInsertedId();

      // declare jwt.php to get jwt properties for generating token
      $config = require __DIR__ . "/../config/jwt.php";

      // add payload for token
      $payload = [
        "iss" => $config["issuer"],
        "iat" => time(),
        "exp" => time() + $config["expire"],
        "sub" => $userId,
        "role" => "user",
      ];

      // create token (payload, secret, algorithm)
      $token = JWT::encode($payload, $config["secret"], "HS256");
      // returning it
      echo json_encode([
        "success" => true,
        "token" => $token,
      ]);
    } catch (Exception $e) {
      die("Register failed: " . $e->getMessage());
    }
  }
}
