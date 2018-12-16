<?php
include_once('../includes/session.php');
include_once('../sql/db_user.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Don't allow certain characters
    if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
        echo 'Username can only contain letters and numbers!';
    }
    else if (checkUserPassword($username, $password)) {
        $_SESSION['username'] = $username;
        $user = getProfPicFromUsername($username);
        $_SESSION['profilePic'] = $user[0]["profImgUrl"];
        echo 'ok';
    } 
    else {
        echo 'fail2'; 
    }



?>