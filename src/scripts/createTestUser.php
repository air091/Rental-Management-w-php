<?php
  require_once __DIR__ . "/../models/User.php";

  $result = User::createUser([
    "email"=>"test@example.com",
    "password"=>password_hash("1234", PASSWORD_DEFAULT),
    "role"=>"admin"
  ]);
