<?php

class DashboardController
{
  public static function index()
  {
    $user = $_SERVER["auth_user"]; // since $_SERVER is global. It is not require to import it.

    echo json_encode([
      "success" => true,
      "message" => "Authenticated",
      "userId" => $user->sub,
      "role" => $user->role
    ]);
  }
}
