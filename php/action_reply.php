<?php
include_once('../sql/db_user.php');
include_once('../includes/session.php');


insertReply($_SESSION['username'],$_POST['reply'], $_POST['commId']);

header('Location: '. $_SESSION['previousPage']. '#comments');

exit();
?>