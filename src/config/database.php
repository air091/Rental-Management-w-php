<?php
require_once realpath(__DIR__ . "/../../vendor/autoload.php");

use MongoDB\Client;

class MongoDBConnection {
  private static $client;

  public static function getDB() {
    if (!self::$client) self::$client = new Client("mongodb://127.0.0.1:27017");
    return self::$client->selectDatabase("rental_db");
  }
}