<?php
include_once './tpl.php';
include_once('../includes/session.php');
include_once('../sql/db_user.php');

if (!isset($_GET['user'])){
    if(isset($_SESSION['username'])){
        header('Location: ../php/profile?user='.$_SESSION['username']);
        exit();
    }
    header('Location: ../php/error_404');
    exit();
}

$canChange = false;
if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['user'])
    $canChange = true;  

draw_header();
draw_aside();

$userInfo = getUser($_GET['user']);
/* print_r($userInfo); */
?>


<div class="containerbox">
    <h1>Profile</h1><div class="media">                
        <div class="d-flex">
            <img src="<?= $userInfo['profImgUrl'] ?>" alt="">
        </div>
        <div class="media-body">
            <div class="personal_text">
                <h3><i class="fas fa-user" style="color:red;"></i> <?= $userInfo['name'] ?></h3>
                <h3><i class="fas fa-user-tag" style="color:red;"></i><?= $userInfo['username'] ?></h3>
                <h3><i class="fas fa-envelope" style="color:red;"></i> <?= $userInfo['email'] ?></h3>
                <?php if($canChange) {?>
                <h3><i class="fas fa-key" style="color:red;"></i> ***********</h3>
                <button type="button">Change</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
draw_footer();
?>