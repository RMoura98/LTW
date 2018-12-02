<?php
include_once('connection.php');
include_once('../includes/session.php');
include_once('../sql/db_user.php');

if(empty($_POST['title']) || empty($_POST['text']) || empty($_FILES['img']) || empty($_POST['tags']) ){
    header('Location: ../php/createPost');
    exit();
} 

$picUrl = upload_img($_FILES['img']);

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
    header('Location: ' . '../php/item?id=' . $lastId);
    exit();

} catch (PDOException $e) {
    die($e->getMessage());
    $_SESSION['messages'][] = array('type' => 'error', 'content' => 'Failed to signup!');
    header('Location: createPost');   
    exit();
} 
?>