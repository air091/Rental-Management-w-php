<?php 
  require_once("../configs/database.php");

  function selectUsers(PDO $pdo) {
    try {
      $selectQuery = 'SELECT * FROM "User"';
      $statement = $pdo->prepare($selectQuery);
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Select User Failed: " . $e->getMessage());
    }
  }

  $users = selectUsers($pdo);