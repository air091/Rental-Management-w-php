<?php
require_once (__DIR__ . "/../../vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware
{
  public static function verify()
  {
    try {
      $token = $_COOKIE["token"] ?? null;

      if (empty($token)) {
        http_response_code(401);
        echo json_encode([
          "success" => false,
          "message" => "No token"
        ]);
        exit();
      }

      $jwtConfig = require (__DIR__ . "/../configs/jwt.php");
      $payload = JWT::decode($token, new Key($jwtConfig["secret"], "HS256"));
      $_SERVER["user_auth"] = $payload;
    } catch (Exception $err) {
      http_response_code(401);
      echo json_encode([
        "success" => false,
        "message" => "Invalid or expired token",
        "error" => $err->getMessage()
      ]);
      exit();
    }
  }
}
