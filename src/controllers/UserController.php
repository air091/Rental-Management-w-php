<?php
  require_once realpath(__DIR__ . "/../models/User.php");

  class UserController {
    public static function allUsers() {
      try {
        $users = User::getAllUsers();
        echo json_encode([
          "success" => true,
          "message" => $users
        ]);
      } catch (Exception $err) {
        echo json_encode([
          "success" => false,
          "message" => $err->getMessage()
        ]);
        exit();
      }
    }
  }