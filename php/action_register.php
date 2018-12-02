<?php
include_once('connection.php');
include_once('../includes/session.php');
include_once('../sql/db_user.php');
include_once('functions.php');



if(empty($_POST['username']) || empty($_POST['password'])|| empty($_POST['passwordConfirm'])|| empty($_POST['email'])|| empty($_POST['realName'])){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'register failed!');
    header('Location: ../php/register.php');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$users = getAllUsernames();

foreach($users as $user){
    if($user['username'] == $username){
        $_SESSION['messages'][] = array('type' => 'error', 'content' => 'That username is already taken!');
        header('Location: ../php/register.php');   
        exit();
    }
}
       

if($_POST['password'] != $_POST['passwordConfirm']){
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Those passwords didn\'t match. Try again.');
    header('Location: ../php/register.php');   
    exit();
}


// Don't allow certain characters
if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Username can only contain letters and numbers!');
    header('Location: ../php/register.php');   
    exit();
}

$profilePicUrl = upload_img($_FILES['img']);
echo $profilePicUrl;
try {
    insertUser($username, $password, $_POST['realName'], $_POST['email'], $profilePicUrl);

    $_SESSION['username'] = $username;
    $_SESSION['profilePic'] = $profilePicUrl;
    $_SESSION['messages'][] = array('type' => 'success', 'content' => 'Signed up and logged in!');
    
    if(isset($_SESSION['previousPage'])){
        header('Location: '. $_SESSION['previousPage']);
        exit();
    }
    else {
        header('Location: frontpage');
        exit();
    }
} catch (PDOException $e) {
    die($e->getMessage());
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
    header('Location: ../php/register.php');   
    exit();
} 

?>