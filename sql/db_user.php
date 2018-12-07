<?php
    include('../php/functions.php');
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
  function insertUser($username, $password, $name, $email, $profilePicUrl) {
    global $db;
    $options = ['cost' => 12];
    $stmt = $db->prepare('INSERT INTO users VALUES(?, ?, ?, ?, ?)');
    $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT, $options), $name, $email, $profilePicUrl));
  }

  function insertComment($username, $text, $postId) {
    global $db;
    $now = time();
    $stmt = $db->prepare('INSERT INTO comments VALUES(NULL,?, ?, ? ,?,0,0)');
    $stmt->execute(array($postId,$username, $now, $text));

    $stmt = $db->prepare('update news set count = count + 1 where id = ?'); //rever isso
    $stmt->execute(array($postId));

  }
  
  function insertPost($title, $tags, $username, $text, $picUrl) {
    global $db;
    $now = time();
    $stmt = $db->prepare('INSERT INTO news VALUES (NULL, ?, ?, ?, ?, ?, "", ?,0,0,0)');
    $stmt->execute(array($title,$now,$tags, $username, $picUrl, $text));
    $stmt2 = $db->prepare('SELECT last_insert_rowid()');
    $stmt2->execute();
    return $stmt2->fetch()['last_insert_rowid()'];

    var_dump($stmt->idlastrowid);
  }

    function getAllUsernames() {
        global $db;
        $stmt = $db->prepare('SELECT * from users');
        $stmt->execute();
        return $stmt->fetchAll();
    }   

    function getUser($username) {
        global $db;
        $stmt = $db->prepare('SELECT * from users WHERE  users.username = ?');
        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }   

    function getProfPicFromUsername($username) {
        global $db;
        $stmt = $db->prepare('SELECT profImgUrl from users where username = ?');
        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }   


?>