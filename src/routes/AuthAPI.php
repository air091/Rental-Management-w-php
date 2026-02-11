<?php
require_once realpath(__DIR__ . "/../controllers/AuthController.php");
require_once realpath(__DIR__ . "/../middlewares/AuthMiddleware.php");

// cors
$allowedOrigin = "http://localhost:5173";
header("Access-Control-Allow-Origin: $allowedOrigin");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header("Content-Type: application/json");

$URI = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// prelight option
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
  http_response_code(200);
  exit();
}

if ($URI === "/" && $method === "GET") {
  http_response_code(200);
  echo json_encode([
    "success" => true,
    "message" => "youre in a homepage"
  ]);
  return;
}

if ($URI === "/api/auth/login" && $method === "POST") {
  AuthController::login();
  return;
}

if ($URI === "/api/auth/register" && $method === "POST") {
  AuthController::register();
  return;
}

if ($URI === "/api/auth/me" && $method === "GET") {
  AuthMiddleware::verify();
  AuthController::me();
  return;
}

// 404 routes
http_response_code(404);
echo json_encode([
  "success" => false,
  "message" => "Route not found"
]);