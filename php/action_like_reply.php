<?php
include_once('../sql/db_user.php');
include_once('../includes/session.php');

setOpinionUserReplys($_POST['id'], $_SESSION['username'], $_POST['upvotes'], $_POST['downvotes']);
?>