<?php
include_once('connection.php');
include_once('../includes/session.php');
include_once('../sql/db_user.php');
include_once('functions.php');



/* if(empty($_POST['username']) || empty($_POST['password'])|| empty($_POST['passwordConfirm'])|| empty($_POST['email'])|| empty($_POST['realName'])){
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
}  */

/* para ajax */

/* if(empty($_POST['username']) || empty($_POST['password'])|| empty($_POST['passwordConfirm'])|| empty($_POST['email'])|| empty($_POST['realName'])){
    echo 'empty';
}
else{ */
    $username = $_POST['username'];
    $password = $_POST['password'];

    /* $users = getAllUsernames(); */

    $ready = true;
    
    /* foreach($users as $user){
        if($user['username'] == $username){
            echo 'That username is already taken!';
            $ready = false;
            break;
        }
    } */
    if ( !preg_match ("/^[a-zA-Z0-9]+$/", $username)) {
        /* Username can only contain letters and numbers! */
        echo 'Username can only contain letters and numbers!';
        $ready = false;
    }
    else if(getUser($username)){
        echo 'That username is already taken!';
        $ready = false;
    }
    else if(strlen($_POST['password']) < 6){
        /* Those passwords didn't match. Try again. */
        echo 'Password must be at least 6 characters long.';
        $ready = false;
    }
    else if($_POST['password'] != $_POST['passwordConfirm']){
        /* Those passwords didn't match. Try again. */
        echo 'Those passwords didn\'t match. Try again.';
        $ready = false;
    }    

    

    $filename = getFilePath((string) $_POST['img']);
    $fileSize = getFileSize((string) $_POST['imgS']);

    if($ready){
        try {

            $profilePicUrl = upload_img('../uploads/'. $filename, $fileSize);

            $Pfiles = glob('../uploads/*'); // get all file names
            foreach($Pfiles as $Pfile){ // iterate files
                if(is_file($Pfile))
                    unlink($Pfile); // delete file
            }

            /* unlink('../uploads/'. $filename); */
            insertUser($username, $password, $_POST['realName'], $_POST['email'], $profilePicUrl);

            $_SESSION['username'] = $username;
            $_SESSION['profilePic'] = $profilePicUrl;

            echo 'ok';    
        } 
        catch (PDOException $e) {
            echo '404';
        }  
    }
    
    
/* } */
?>