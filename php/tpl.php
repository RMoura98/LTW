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
        <div>
            <a style="position: absolute;" href="frontpage"><i style="font-size: -webkit-xxx-large;padding-bottom: 15px;padding-right: 166px;" class="fas fa-newspaper"></i></a>
            <h1 style="padding-left: 70px;"><a href="frontpage"> LTW News</a></h1>
            <h2><a style="position: absolute; padding: 0px 12px 0px 12px; margin-top: 10px;" href="frontpage">Where fake news are born!</a></h2>
        </div>
        <div id="signup">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="../php/profile?user=' . $_SESSION['username'] . '">' . $_SESSION['username'] . '</a>';
                echo '<a href="../php/profile?user=' . $_SESSION['username'] . '"><img class="avatar" style=" margin-left: 10px; " src="'. $_SESSION['profilePic'] .'" alt="Avatar" ></a>';
                echo '<a href="../php/action_logout"><i class="fas fa-sign-out-alt"></i></a>';
            } else { ?>
                <a href="../php/register"><i class="fas fa-user-plus"></i></a>
                <a href="../php/login"> <i class="fas fa-sign-in-alt"></i></a>
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
        <?php if($isFrontPage) { ?>
            <a href="../php/createPost">
                <button class="buttonCreate" style="vertical-align:middle">
                    <span>Create Post <i class="fas fa-pencil-alt" style="margin-left: 10px; font-size: large;"></i></span>
                </button>
            </a><?php } ?>
            <div>
                <?php if($isFrontPage) { ?>
                <div class="dropdown">
                    <button class="dropbtn">Sort <i class="fas fa-sort-amount-down"style="margin-left: 10px; "></i></button>
                    <div class="dropdown-content">
                        <a href="../php/frontpage">New</a>
                        <a href="../php/frontpage?s=top">Top</a>
                        <a href="../php/frontpage?s=controversial">Controversial</a>
                        <a href="../php/frontpage?s=comments">Most Commented</a>
                    </div>
                </div>
                <?php } ?>    
                <a href="../php/random">
                    <button class="dropbtn" style="max-width: 50%; margin-left: 77px;" >
                        <span>Random <i class="fas fa-random" style="margin-left: 10px; "></i></span>
                    </button>
                </a>
            </div>
        <article>
            <h2><i class="fab fa-hotjar"></i> TOP POST <i class="fab fa-hotjar"></i></h2>
            <?php if($topDayPost) { ?>
            <h1><a href="../php/item?id=<?=$topDayPost['id']?>"> DAY:  <?=$topDayPost['title']?></a></h1>
            <?php } if($topWeekPost) {?>
            <h1><a href="../php/item?id=<?=$topWeekPost['id']?>"> WEEK:  <?=$topWeekPost['title']?></a></h1>
            <?php } if($topMonthPost) {?>
            <h1><a href="../php/item?id=<?=$topMonthPost['id']?>"> MONTH:  <?=$topMonthPost['title']?></a></h1> <?php } ?>
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
                <h1><a href="item?id=<?=$id?>"><?=$title?></a></h1>
            </header>
            <a style="height: 600px; display: block;" href="item?id=<?=$id?>"><img src="<?=$img?>" alt=""></a>
            <footer>
                <span class="author"> <a href="../php/profile?user=<?= $username?>"> <?= $username?>  </a></span>
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
                    foreach ($fulltags as $tag) {
                        echo "<a href='tag?id=$tag'>#$tag</a> ";
                    }
                    ?>              
                </span>
                <span class="date"><?=time_ago($published)?></span>
                <a class="comments" href="../php/item?id=<?=$id?>#comments"><?=$count?></a>
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
    $s = '../php/frontpage?p=' . $i;
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
                <a href="fe.up.pt">FEUP</a>
                <p> | 2018</p>
            </footer>
        </body>
    </html>
<?php } ?>






