<?php
include_once('../php/functions.php');
include_once('../includes/session.php');

setOpinionUserNews($_POST['newsid'], $_SESSION['username'], $_POST['upvotes'], $_POST['downvotes']);
?>