<?php
include_once './tpl.php';
include_once('../includes/session.php');
include_once('../sql/db_user.php');
include_once('../php/functions.php');


if (!isset($_GET['user'])){
    if(isset($_SESSION['username'])){
        header('Location: ../php/profile.php?user='.$_SESSION['username']);
        exit();
    }
    header('Location: ../php/error_404.php');
    exit();
}

if(!isset($_GET['show'])){
    $articles = getPostsLikedByUser($_SESSION['username']);
    $idCall = 'news_id';
}
else {
    if($_GET['show'] == 'created'){
        $articles = getPostsCreatedByUser($_SESSION['username']);
        $idCall = 'id';
    }
    else{
        header('Location: ../php/error_404.php');
        exit();
    }
}

$canChange = false;
if(isset($_SESSION['username']) && $_SESSION['username'] == $_GET['user'])
    $canChange = true; 

$userInfo = getUser($_GET['user']);
if(!$userInfo){
    header('Location: ../php/error_404.php');
    exit();
}

draw_header();
draw_aside();

?>

<div class="containerbox">
    <h1>Profile</h1><div class="media"> 
    <?php if($canChange) {?>        
    <div class="hiddenBox" id="realnameChange" style="display:none;">
        <form action="../php/action_change_profile.php" style="padding-right: 0px;" method="POST">
            <label>New Name:
                <input type="text" name="realName" placeholder="Real Name" required>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    <div class="hiddenBox" id="picChange" style="display:none;">
        <form action="../php/action_change_profile.php" enctype="multipart/form-data"  style="padding-right: 0px;" method="POST">
            <label>New Picture <i class="fas fa-image"></i>
                <input name="img" size="35" style="width: 280px;" type="file" placeholder="Profile Picture" required/>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    <div class="hiddenBox" id="emailChange" style="display:none;">
        <form action="../php/action_change_profile.php" style="padding-right: 0px;" method="POST">
            <label >New Email
                <input type="email" name="email" placeholder="Email" required>
            </label>
            <input type="submit" style="margin-left: 30px;margin-top: 20px;margin-bottom: 20px;" value="submit">
        </form>
        <i class="fas fa-times" style="padding-top: 10px; padding-bottom: 10px; padding-left: 10px;"></i>
    </div>
    <div class="hiddenBox" id="passwordChange" style="display:none;">
        <form action="../php/action_change_profile.php" style="padding-right: 0px;" method="POST">
            <label style="margin-left: 10px;">Change Password <a src="../php/profile.php?user="></a>
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
                    <h3><i class="fas fa-user" style="color:red;"></i> <?= htmlspecialchars($userInfo['name']) ?></h3>
                    <?php if($canChange) {?>
                    <button class="btnChange" style="padding: 0px;" type="button"><i class="fas fa-cog"></i></button><?php } ?>
                </div>
                <h3><i class="fas fa-user-tag" style="color:red;"></i><?= $userInfo['username']?></h3>
                <div id="email" style="display: flex;">
                    <h3><i class="fas fa-envelope" style="color:red;"></i> <?= htmlspecialchars($userInfo['email']) ?></h3>
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

<?php
if($canChange){?>
    <div id="profilePostShow" style="display:flex;">
        <?php if ($idCall == 'id'){?>
        <h1 style="margin-left:25px;">Posts Created</h1>
        <button type="button" onclick="window.location.href='../php/profile.php?user=<?=$_SESSION['username']?>#profilePostShow'"style="padding: 0px; margin-top: 25px;" value="submit">Posts Upvoted</button>

        <?php } 
        else {?>
        <h1 style="margin-left:25px;">Posts Upvoted</h1>
        <button type="button" onclick="window.location.href='../php/profile.php?user=<?=$_SESSION['username']?>&show=created#profilePostShow'" style="padding: 0px; margin-top: 25px;" value="submit">Posts Created</button>
    <?php } ?>
    </div>
    <section id="news">
    <?php 
    for ($i = 0; $i < count($articles); $i++) 
        draw_PostS($articles[$i][$idCall], $articles[$i]['title'], $articles[$i]['username'],
                    $articles[$i]['imageUrl'], $articles[$i]['count'], $articles[$i]['published'], 
                    $articles[$i]['tags'], $articles[$i]['upvotes'], $articles[$i]['downvotes']);
    if (count($articles) == 0){?>
        <h1 style="margin-left: 25px;">Nothing to see</h1>
    <?php }    ?>
    </section>
<?php 
}

draw_footer();
?>