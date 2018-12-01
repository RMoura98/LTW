<?php
include_once('connection.php');
include_once('../includes/session.php');
include_once('../sql/db_user.php');

if(empty($_POST['username']) || empty($_POST['password'])){
    header('Location: ../html/login.html');
    exit();
}
$username = $_POST['username'];
$password = $_POST['password'];
if (checkUserPassword($username, $password)) {
    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Logged in successfully!');
    header('Location: news.php');
} else {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Login failed!');
    header('Location: ../html/login.html'); 
}
?>