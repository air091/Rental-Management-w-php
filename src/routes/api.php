<?php
require_once __DIR__ . "/../controllers/AuthController.php";

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

header("Content-Type: application/json");

if ($uri === "/" && $method === "GET") {
  echo json_encode([
    "success" => true,
    "message" => "API success",
  ]);
  return;
}

if ($uri === "/api/login" && $method === "POST") {
  AuthController::login();
  return;
}

if ($uri === "/api/register" && $method === "POST") {
  AuthController::register();
  return;
}

http_response_code(404);
echo json_encode([
  "success" => false,
  "error" => "Route not found",
]);
