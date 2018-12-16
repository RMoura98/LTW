<?php
include_once('../includes/session.php');
include_once('../sql/db_user.php');

    $username = $_POST['username'];
    $password = $_POST['password'];


    $ready = true;
    
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
    
?>