<?php
include_once './functions.php';

$articles = getAllNews();
$_GET['id'] = rand(1 , count($articles) );
include ('../php/item.php');
?>