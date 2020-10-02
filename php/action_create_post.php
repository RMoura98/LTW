<?php
include_once('../includes/session.php');
include_once('../sql/db_user.php');
include_once('../php/functions.php');

if(empty($_POST['text'])){
    $_POST['text'] = '';
} 

$filename = getFilePath((string) $_POST['img']);
$fileSize = getFileSize((string) $_POST['imgS']);

$picUrl = upload_img('../uploads/'. $filename, $fileSize);

$fulltags = str_replace(' ', '', $_POST['tags']);
$fulltags = str_replace(';', '#', $fulltags);
$fulltags = str_replace(',', '#', $fulltags);
$fulltags =  explode('#',$fulltags);
$tags = "";
foreach ($fulltags as $tag) {
    if($tag != ''){
        $tags .= $tag;
        if( next( $fulltags ) && next( $fulltags ) != '') {
            $tags .=  ",";
        }
    }
}

try {
    $lastId = insertPost($_POST['title']  , $tags, $_SESSION['username'], $_POST['text'], $picUrl);
    echo 'ok' . $lastId;

    $Pfiles = glob('../uploads/*');
    foreach($Pfiles as $Pfile){ // iterate files
        if(is_file($Pfile))
            unlink($Pfile); // delete file
    }

} catch (PDOException $e) {
    die($e->getMessage());
    echo 'DataBase fail';   
    exit();
} 





?>