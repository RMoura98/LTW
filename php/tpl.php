<?php 
include_once('../includes/session.php');

/**
 * Draws the header for all pages. 
 */
function draw_header() { 
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>LTW News</title>
    <link rel="icon" href="../favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link href="../css/comments.css" rel="stylesheet">
    <link href="../css/forms.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="../js/main.js" defer=""></script>
    
  </head>
  <body>
    <header>
        <div style="margin-left: 12px;">
            <a style="position: absolute;" href="frontpage.php"><i style="font-size: -webkit-xxx-large;padding-bottom: 15px;padding-right: 166px;" class="fas fa-newspaper"></i></a>
            <h1 style="padding-left: 70px;"><a href="frontpage.php"> LTW News</a></h1>
            <h2><a style="position: absolute; padding: 0px 12px 0px 12px; margin-top: 10px;" href="frontpage.php">Where fake news are born!</a></h2>
        </div>
        
            <?php
            if (isset($_SESSION['username'])) { ?>
                <div id="userInfo">
                    <a href="../php/profile.php?user=<?=$_SESSION['username']?>"> <?=$_SESSION['username']?> </a>
                    <a href="../php/profile.php?user=<?=$_SESSION['username']?>"><img class="avatar" style=" margin-left: 10px; " src=" <?=$_SESSION['profilePic']?> " alt="Avatar" ></a>
                    <a href="../php/action_logout.php"><i class="fas fa-sign-out-alt"></i></a>
            <?php } else { ?>
                <div id="signup">
                    <a href="../php/register.php"><i class="fas fa-user-plus"></i></a>
                    <a href="../php/login.php"> <i class="fas fa-sign-in-alt"></i></a>
            <?php }?>
        </div>
</header>
<?php } ?>

<?php 

/**
 * Draws the aside for all pages.
 */
function draw_aside($isFrontPage = FALSE) { 
    $topDayPost = getTopPostDay();
    $topWeekPost = getTopPostWeek();
    $topMonthPost = getTopPostMonth();?>
    <aside id="related">
        <form id="searchBar" action="../php/search.php">
            <input type="search" name="q" placeholder="Search">            
        </form>
        <?php if($isFrontPage) { ?>
            <a href="../php/createPost.php">
                <button class="buttonCreate" style="vertical-align:middle">
                    <span>Create Post <i class="fas fa-pencil-alt" style="margin-left: 10px; font-size: large;"></i></span>
                </button>
            </a><?php } ?>
            <div style="display: flex; justify-items: center; flex-wrap: wrap-reverse; align-items: center;">
                <?php if($isFrontPage) { ?>
                <div class="dropdown" style="display: block; width: 100%;">
                    <button class="dropbtn" style="display: block;width: 100%;">Sort By <i class="fas fa-sort-amount-down"style="margin-left: 10px; "></i></button>
                    <div class="dropdown-content">
                        <a href="../php/frontpage.php">New</a>
                        <a href="../php/frontpage.php?s=top">Top</a>
                        <a href="../php/frontpage.php?s=controversial">Controversial</a>
                        <a href="../php/frontpage.php?s=comments">Most Commented</a>
                    </div>
                </div>
                <?php } ?>    
                <a href="../php/random.php" style="width: 100%;">
                    <button class="dropbtn" style="width: 100%;margin-bottom: 10px;margin-left: 0px;" >
                        <span>Random <i class="fas fa-random" style="margin-left: 10px; "></i></span>
                    </button>
                </a>
            </div>
        <article>
            <h2><i class="fab fa-hotjar"></i> TOP POST <i class="fab fa-hotjar"></i></h2>
            <?php if($topDayPost) { ?>
            <h1><a href="../php/item.php?id=<?=$topDayPost['id']?>"> DAY:  <?=htmlspecialchars($topDayPost['title'])?></a></h1>
            <?php } if($topWeekPost) {?>
            <h1><a href="../php/item.php?id=<?=$topWeekPost['id']?>"> WEEK:  <?=htmlspecialchars($topWeekPost['title'])?></a></h1>
            <?php } if($topMonthPost) {?>
            <h1><a href="../php/item.php?id=<?=$topMonthPost['id']?>"> MONTH:  <?=htmlspecialchars($topMonthPost['title'])?></a></h1> <?php } ?>
        </article>
    </aside>
<?php } ?>

<?php 
/**
 * Draws the Post (short).
 */
function draw_PostS($id, $title, $username, $imageUrl, $count, $published, $tags, $upvotes, $downvotes) {  
    if($imageUrl)
        $img = $imageUrl; 
    else
        $img = 'https://s.imgur.com/images/logo-1200-630.jpg';
    ?>
    
    <article>
            <header>
                <h1><a href="item.php?id=<?=$id?>"><?=htmlspecialchars($title)?></a></h1>
            </header>
            <a style="height: 600px; display: block;" href="item.php?id=<?=$id?>"><img src="<?=$img?>" alt=""></a>
            <footer>
                <span class="author"> <a href="../php/profile.php?user=<?= $username?>"> <?= $username?>  </a></span>
                <?php if (isset($_SESSION['username'])) { 
                $opinion = getOpinionUserNews($id, $_SESSION['username']);
                ?>
                <div class="newsLikeDiv">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <i class="fas fa-thumbs-up" <?php if ($opinion && $opinion[0]['upvote']) echo 'style="color: green;"';?>></i>                   
                    <span class="likes"><?=$upvotes - $downvotes?></span>
                    <i class="fas fa-thumbs-down" <?php if ($opinion && $opinion[0]['downvote']) echo 'style="color: red;"';?>></i>
                </div>
                <?php } ?>
                <span class="tags">
                    <?php
                    $fulltags = explode(',', $tags);
                    foreach ($fulltags as $tagt) {
                        $tag = htmlspecialchars($tagt);
                        echo "<a href='tag.php?id=$tag'>#$tag</a> ";
                    }
                    ?>              
                </span>
                <span class="date"><?=time_ago($published)?></span>
                <a class="comments" href="../php/item.php?id=<?=$id?>#comments"><?=$count?></a>
            </footer>
        </article>
<?php } ?>

  
<?php 
/**
 * Draws the footer for all pages.
 */
function draw_pagination($page, $maxPage, $sort) {  ?>
<div class="pagination">
<?php 
for ($i=1; $i < $maxPage + 1; $i++) { 
    $c = '';
    $s = '../php/frontpage.php?p=' . $i;
    if($sort != '') 
        $s .= '&s=' . $sort;
    if($page == $i)
        $c = 'class="active" ';
    echo '<a '.$c.'href="' . $s . '">' . $i . '</a>';
    } ?>
</div>
<?php } ?>

<?php 
/**
 * Draws the footer for all pages.
 */
function draw_footer() {  ?>
            <footer class="_footer">
                <p>Copyright &copy; </p>
                <a href="https://sigarra.up.pt/feup/pt/web_base.gera_pagina?P_pagina=1182" target="_black">FEUP</a>
                <p> | 2018</p>
            </footer>
        </body>
    </html>
<?php } ?>






