<?php
require_once realpath(__DIR__ . "/../../vendor/autoload.php");
require_once realpath(__DIR__ . "/../models/User.php");

use Firebase\JWT\JWT;

class AuthController
{

  public static function login()
  {
    try {
      $input = json_decode(file_get_contents("php://input"), true);

      $email = isset($input["email"]) ? trim($input["email"]) : "";
      $password = isset($input["password"]) ? trim($input["password"]) : "";

      if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode([
          "success" => false,
          "message" => "All fields are required"
        ]);
        return;
      }

      $user = User::getUserByEmail($email);
      if (!$user || !password_verify($password, $user["password"])) {
        http_response_code(401);
        echo json_encode([
          "success" => false,
          "message" => "Invalid email or password"
        ]);
        return;
      }

      $jwtConfig = require (__DIR__ . "/../configs/jwt.php");
      $payload = [
        "iss" => $jwtConfig["issuer"],
        "iat" => time(),
        "exp" => time() + $jwtConfig["expires"],
        "sub" => $user["user_id"],
        "email" => $user["email"]
      ];

      $token = JWT::encode($payload, $jwtConfig["secret"], "HS256");

      setcookie(
        "token",
        $token,
        [
          "expires" => time() + 60,
          "path" => "/",
          "secure" => false,
          "httponly" => true,
          "samesite" => "Strict"
        ]
      );

      echo json_encode([
        "success" => true,
        "message" => "Login successful",
        "user" => [
          "userId" => $user["user_id"],
          "email" => $user["email"]
        ]
      ]);

    } catch (PDOException $err) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "message" => "Something went wrong Login Cont: " . $err->getMessage()
      ]);
      exit();
    }
  }

  public static function me() {
    echo json_encode([
      "success" => true,
      "user" => $_SERVER["user_auth"]
    ]);
    return;
  }

  public static function register()
  {
    try {
      $input = json_decode(file_get_contents("php://input"), true);

      $email = isset($input["email"]) ? trim($input["email"]) : "";
      $password = isset($input["password"]) ? trim($input["password"]) : "";

      if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode([
          "success" => false,
          "message" => "All fields are required"
        ]);
        return;
      }

      $userExist = User::getUserByEmail($email);
      if (!empty($userExist)) {
        http_response_code(409);
        echo json_encode([
          "success" => false,
          "message" => "Email already in use"
        ]);
        return;
      }
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);
      $user = User::insertUser($email, $passwordHash);
      echo json_encode([
        "success" => true,
        "message" => "Registered Successful",
        "user_id" => $user
      ]);
    } catch (PDOException $err) {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "message" => "Something went wrong Register Cont: " . $err->getMessage()
      ]);
      exit();
    }
  }

}
