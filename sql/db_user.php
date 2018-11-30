<?php
    include('../php/connection.php');
  /**
   * Verifies if a certain username, password combination
   * exists in the database. Use the sha1 hashing function.
   */
  function checkUserPassword($username, $password) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(array($username));
    $user = $stmt->fetch();
    return $user !== false && password_verify($password, $user['password']);
  }
  /**
   * insere um user na base de dados
   */
  function insertUser($username, $password, $name, $email) {
    global $db;
    $options = ['cost' => 12];
    $stmt = $db->prepare('INSERT INTO users VALUES(?, ?, ? ,?)');
    $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options), $name, $email));
  }

    function getAllUsernames() {
        global $db;
        $stmt = $db->prepare('SELECT * from users');
        $stmt->execute();
        return $stmt->fetchAll();
    }   
?>