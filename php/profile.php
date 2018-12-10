<?php
include_once './tpl.php';
include_once('../includes/session.php');
include_once('../sql/db_user.php');
include_once('../php/functions.php');

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
        <form action="../php/action_change_profile" style="padding-right: 0px;" method="POST">
            <label>New Name:
                <input type="text" name="realName" placeholder="Real Name" required>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    <div class="hiddenBox" id="picChange" style="display:none;">
        <form action="../php/action_change_profile" enctype="multipart/form-data"  style="padding-right: 0px;" method="POST">
            <label>New Picture <i class="fas fa-image"></i>
                <input name="img" size="35" style="width: 280px;" type="file" placeholder="Profile Picture" required/>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    <div class="hiddenBox" id="emailChange" style="display:none;">
        <form action="../php/action_change_profile" style="padding-right: 0px;" method="POST">
            <label>New Email
                <input type="email" name="email" placeholder="Email" required>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    <div class="hiddenBox" id="passwordChange" style="display:none;">
        <form action="../php/action_change_profile" style="padding-right: 0px;" method="POST">
            <label>Reply to <a src="../php/profile?user="></a>
                <input type="password" name="oldPassword" placeholder="Old Password" required>
                <input type="password" name="newPassword" placeholder="New Password" required>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    
    <?php } ?>
        <div id="pic" class="d-flex">
            <img src="<?= $userInfo['profImgUrl'] ?>" alt="">
            <?php if($canChange) {?><button class="btnChange" type="button" style="padding: 0px;position: absolute; top: 65%; left: 3%;"><i class="fas fa-cog"></i></button><?php } ?>
        </div>
        <div class="media-body">
            <div class="personal_text">
                <div id="name" style="display: flex;">
                    <h3><i class="fas fa-user" style="color:red;"></i> <?= $userInfo['name'] ?></h3>
                    <?php if($canChange) {?>
                    <button class="btnChange" style="padding: 0px;" type="button"><i class="fas fa-cog"></i></button><?php } ?>
                </div>
                <h3><i class="fas fa-user-tag" style="color:red;"></i><?= $userInfo['username'] ?></h3>
                <div id="email" style="display: flex;">
                    <h3><i class="fas fa-envelope" style="color:red;"></i> <?= $userInfo['email'] ?></h3>
                    <?php if($canChange) {?>
                        <button class="btnChange" style="padding: 0px;" type="button"><i class="fas fa-cog"></i></button><?php } ?>
                </div>
                <?php if($canChange) {?>
                <div id="password" style="display: flex;"><h3><i class="fas fa-key" style="color:red;"></i> ***********</h3>
                    <button class="btnChange" style="padding: 0px;" type="button"><i class="fas fa-cog"></i></button></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<h1>Posts upvoted</h1>
<section id="news">

<?php
$articles = getPostsLikedByUser($_SESSION['username']);
for ($i = 0; $i < count($articles); $i++) 
    draw_PostS($articles[$i]['id'], $articles[$i]['title'], $articles[$i]['username'], $articles[$i]['imageUrl'], $articles[$i]['count'], $articles[$i]['published'], $articles[$i]['tags'], $articles[$i]['upvotes'], $articles[$i]['downvotes']);
?>
</section>
<?php
draw_footer();
?>