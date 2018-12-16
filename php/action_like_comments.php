<?php
include_once('../includes/session.php');
include_once('../sql/db_user.php');

setOpinionUserComments($_POST['id'], $_SESSION['username'], $_POST['upvotes'], $_POST['downvotes']);
?>