<?php
include('connection.php');
include('../includes/session.php');
include('../sql/db_user.php');



if(empty($_POST['username']) || empty($_POST['password'])|| empty($_POST['passwordConfirm'])|| empty($_POST['email'])|| empty($_POST['realName'])){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'register failed!');
    header('Location: ../html/register.html');
}

$username = $_POST['username'];
$password = $_POST['password'];
$users = getAllUsernames();

foreach($users as $user){
    if($user['username'] == $username){
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'That username is already taken!');
        header('Location: ../html/register.html');   
    }
}
       

if($_POST['password'] != $_POST['passwordConfirm']){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Those passwords didn\'t match. Try again.');
    header('Location: ../html/register.html');   
}


// Don't allow certain characters
if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    header('Location: ../html/register.html');   
}

try {
    insertUser($username, $password, $_POST['realName'], $_POST['email']);

    $_SESSION['username'] = $username;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Signed up and logged in!');
    header('Location: news.php');
} catch (PDOException $e) {
    die($e->getMessage());
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
    header('Location: register.php');
}
?>