<?php
include_once('../sql/db_user.php');
include_once('../includes/session.php');

if(empty($_POST['comment'])){
    header('Location: javascript:history.go(-1)');
    exit();
}

insertComment($_SESSION['username'],$_POST['comment'], $_POST['postId']);

header('Location: ./news.php');
exit();
?>