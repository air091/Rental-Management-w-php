<?php
// get autoload for dependency.
// This will automatically use what dependency you have
require_once realpath(__DIR__ . "/../../vendor/autoload.php");

// this will use the function of that dependency
use MongoDB\Client;

// create a class
class MongoDBConnection
{
  // create property of a class
  private static $client;
  // this function will connect the database
  public static function getDB()
  {
    // check if the client is already connected to the database server
    // if not then connect to it
    // self is to use the static property, functions, methods
    if (!self::$client) {
      self::$client = new Client("mongodb://127.0.0.1:27017");
    }
    // returns the database
    return self::$client->selectDatabase("rental_db");
  }
}
