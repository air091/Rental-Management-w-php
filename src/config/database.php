<?php
require realpath(__DIR__ . "/../../vendor/autoload.php");

use MongoDB\Client;

class MongoDBConnection {
  private static ?Client $client = null;
  private static ?\MongoDB\Database $database = null;

  private function __construct() {}

  public static function getDB(string $dbName = "rental_db"): \MongoDB\Database {
    if (self::$client === null) {
      try {
        self::$client = new Client("mongodb://localhost:27017");
        self::$database = self::$client->$dbName;
      } catch (Exception $err) {
        die("Database failed: " . $err->getMessage());
      }
    }
    return self::$database;
  }
}