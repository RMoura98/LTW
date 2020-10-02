<?php
include_once('../sql/db_user.php');
include_once('../includes/session.php');
include_once '../php/functions.php';



if (isset($_POST['realName'])){
    changeRealName($_SESSION['username'], $_POST['realName']);
}
else if (isset($_POST['email'])){
    changeEmail($_SESSION['username'], $_POST['email']);
}
else if (isset($_POST['oldPassword'])){
    changePassword($_SESSION['username'], $_POST['newPassword'], $_POST['oldPassword']); 
}
else if(isset($_FILES['img'])){
    $filename = $_FILES['img']['name'];
    $fileSize = filesize('../uploads/'. $filename);
    $profilePicUrl = upload_img('../uploads/'. $filename, $fileSize);

    $Pfiles = glob('../uploads/*'); // get all file names
    foreach($Pfiles as $Pfile){ // iterate files
        if(is_file($Pfile))
            unlink($Pfile); // delete file
    }
    $_SESSION['profilePic'] = $profilePicUrl;
    changeImg($_SESSION['username'], $profilePicUrl);

}

header('Location: ../php/profile.php');
exit();
?>