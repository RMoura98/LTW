<?php
include_once('../sql/db_user.php');

$articles = getAllNews();
$_GET['id'] = rand(1 , count($articles) );
include ('../php/item.php');
?>