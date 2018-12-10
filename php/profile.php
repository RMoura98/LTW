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
?>


<div class="containerbox">
    <h1>Profile</h1><div class="media"> 
    <?php if($canChange) {?>        
    <div class="hiddenBox" id="realnameChange" style="display:none;">
        <form action="../php/action_reply.php" style="padding-right: 0px;" method="POST">
            <label>Reply to <a src="../php/profile?user="></a>
            <textarea name="reply" style="width: 430px; margin-right:10px;" required></textarea>
            </label>
            <input type='hidden' name='commId' /> 
            <input type="submit" style="margin-left: 30px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-right: 10px; padding-top: 10px;"></i>
    </div>
    <div class="hiddenBox" id="picChange" style="display:none;">
        <form action="../php/action_reply.php" style="padding-right: 0px;" method="POST">
            <label>Reply to <a src="../php/profile?user="></a>
            <textarea name="reply" style="width: 430px; margin-right:10px;" required></textarea>
            </label>
            <input type='hidden' name='commId' /> 
            <input type="submit" style="margin-left: 30px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-right: 10px; padding-top: 10px;"></i>
    </div>
    <div class="hiddenBox" id="emailChange" style="display:none;">
        <form action="../php/action_reply.php" style="padding-right: 0px;" method="POST">
            <label>Reply to <a src="../php/profile?user="></a>
            <textarea name="reply" style="width: 430px; margin-right:10px;" required></textarea>
            </label>
            <input type='hidden' name='commId' /> 
            <input type="submit" style="margin-left: 30px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-right: 10px; padding-top: 10px;"></i>
    </div>
    <div class="hiddenBox" id="passwordChange" style="display:none;">
        <form action="../php/action_reply.php" style="padding-right: 0px;" method="POST">
            <label>Reply to <a src="../php/profile?user="></a>
            <textarea name="reply" style="width: 430px; margin-right:10px;" required></textarea>
            </label>
            <input type='hidden' name='commId' /> 
            <input type="submit" style="margin-left: 30px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-right: 10px; padding-top: 10px;"></i>
    </div>
    <?php } ?>
        <div id="pic" class="d-flex">
            <img src="<?= $userInfo['profImgUrl'] ?>" alt="">
            <?php if($canChange) {?><button class="btnChange" type="button" style="position: absolute; top: 65%; left: 3%;"><i class="fas fa-cog"></i></button>
                <div id="picChange" style="display: none;"></div><?php } ?>
        </div>
        <div class="media-body">
            <div class="personal_text">
                <div id="name" style="display: flex;"><h3><i class="fas fa-user" style="color:red;"></i> <?= $userInfo['name'] ?></h3><?php if($canChange) {?><button class="btnChange" type="button"><i class="fas fa-cog"></i></button><?php } ?></div>
                <h3><i class="fas fa-user-tag" style="color:red;"></i><?= $userInfo['username'] ?></h3>
                <div id="email" style="display: flex;"><h3><i class="fas fa-envelope" style="color:red;"></i> <?= $userInfo['email'] ?></h3><?php if($canChange) {?><button class="btnChange" type="button"><i class="fas fa-cog"></i></button><?php } ?></div>
                <?php if($canChange) {?>
                <div id="password" style="display: flex;"><h3><i class="fas fa-key" style="color:red;"></i> ***********</h3>
                <button class="btnChange" type="button"><i class="fas fa-cog"></i></button></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php
draw_footer();
?>