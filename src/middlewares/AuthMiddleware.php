<?php
// import autoload for use of dependencies
require_once __DIR__ . "/../../vendor/autoload.php";

// dependencies
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// declare class
class AuthMiddleware
{
  // function for verifying JWT
  public static function verify()
  {
    // get header
    $headers = getallheaders();

    //check if have authorization header
    if (!isset($headers["Authorization"])) {
      // assign http response status
      http_response_code(401); // 401 => Unauthorized
      echo json_encode([
        "success" => false,
        "error" => "Missing authorization header",
      ]);
      exit();
    }

    // extract token
    $authHeader = $headers["Authorization"];

    // separate Bearer (token) and token is important
    $parts = explode(" ", $authHeader); // explode function will make string into an array

    // check if authorization format is correct, contains bearer
    // parts should have 2 length. First arr = "Bearer" Second arr = "token"
    if (count($parts) !== 2 || $parts[0] !== "Bearer") {
      // assign http response status
      http_response_code(401);
      // return json
      echo json_encode([
        "success" => false,
        "error" => "Invalid authorization format",
      ]);
      exit();
    }

    // get token from $parts[1]
    $token = $parts[1];

    // import jwt.php to get jwt properties for decoding token
    $config = require __DIR__ . "/../config/jwt.php";

    try {
      // decode token
      $decoded = JWT::decode($token, new Key($config["secret"], "HS256"));

      // attach user information to request
      $_SERVER["auth_user"] = $decoded;
    } catch (Exception $e) {
      http_response_code(401);
      echo json_encode([
        "success" => false,
        "error" => "Invalid or expired token",
        "errorMsg" => $e->getMessage(),
      ]);
      exit();
    }
  }

  public static function requireRole(string $role)
  {
    self::verify();

    if (($_SERVER["auth_server"]->role ?? null) !== $role) {
      http_response_code(403);
      echo json_encode([
        "success" => false,
        "error" => "Forbidden",
      ]);
      exit();
    }
  }
}
