<?php
include_once('connection.php');
include_once('../includes/session.php');
include_once('../sql/db_user.php');

if(empty($_POST['username']) || empty($_POST['password'])){
    header('Location: ../php/login.php');
    exit();
}
$username = $_POST['username'];
$password = $_POST['password'];
if (checkUserPassword($username, $password)) {
    $_SESSION['username'] = $username;
    $user = getProfPicFromUsername($username);
    $_SESSION['profilePic'] = $user[0]["profImgUrl"];
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    var_dump($_SESSION);
    if(isset($_SESSION['previousPage'])){
        header('Location: ' . $_SESSION['previousPage']);
        exit();
    }
    else {
        header('Location: '.$_SESSION['previousPage']);
        exit();
    }
        
} 
else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: ../php/login.php'); 
    exit();
}
?>