<?php
require_once realpath(__DIR__ . "/../config/database.php");

class User
{
  public static function findUserById($id)
  {
    $database = MongoDBConnection::getDB();
    return $database->users->findOne(["_id" => $id]);
  }

  public static function findUserByEmail($email)
  {
    $database = MongoDBConnection::getDB();
    return $database->users->findOne(["email" => $email]);
  }

  public static function createUser(array $data)
  {
    $database = MongoDBConnection::getDB();
    return $database->users->insertOne($data);
  }

  public static function deleteUser($id)
  {
    $database = MongoDBConnection::getDB();
    return $database->users->deleteOne(["_id" => $id]);
  }
}
