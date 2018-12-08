<?php
include_once './tpl.php';
include_once('../includes/session.php');
include_once('../sql/db_user.php');

if (!isset($_GET['user'])){
    header('Location: ../php/error_404');
    exit();
}

$canChange = false;
if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['user'])
    $canChange = true;  

draw_header();
draw_aside();

$userInfo = getUser($_GET['user']);
print_r($userInfo);
?>

<h1> Profile</h1>
    <img src="<?=$userInfo['profImgUrl']?>" alt="Photo">
    <h2>Username: <?=$userInfo['username']?></h2>
    <h2>Email: <?=$userInfo['email']?></h2>

<?php
draw_footer();
?>