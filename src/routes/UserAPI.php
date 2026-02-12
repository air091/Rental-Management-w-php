<?php
  require_once realpath(__DIR__ . "/../controllers/UserController.php");
  require_once realpath(__DIR__ . "/../middlewares/AuthMiddleware.php");

  header("Content-Type: application/json");

  $URI = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
  $method = $_SERVER["REQUEST_METHOD"];

  if ($URI === "/api/users" && $method === "GET") {
    UserController::allUsers();
    exit();
  }

  // 404 routes
http_response_code(404);
echo json_encode([
  "success" => false,
  "message" => "Route not found"
]);