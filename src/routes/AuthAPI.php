<?php
require_once realpath(__DIR__ . "/../controllers/AuthController.php");
require_once realpath(__DIR__ . "/../middlewares/AuthMiddleware.php");

$URI = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

header("Content-Type: application/json");

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
