<?php

class AuthDatabase {
  private static string $host = "localhost";
  private static string $username = "root";
  private static string $password = "";
  private static string $dbname = "rental_auth_db";

  public static function connectAuthDB() {
    try {
      $connect = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $connect;
    } catch (PDOException $err) {
      echo "Connection failed: " . $err->getMessage();
      return null;
    }
  }

}