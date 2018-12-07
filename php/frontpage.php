<?php
include_once './functions.php';
include_once './tpl.php';
include_once('../includes/session.php');

define("MAXPOSTPPAGE", "4");


$_SESSION["previousPage"] = $_SERVER['REQUEST_URI'];

draw_header();
draw_aside(TRUE);
?>
    <section id="news">
<?php

$articles = getAllNews();
if(isset($_GET['s'])){
    $sort = $_GET['s'];
    if(is_numeric($sort))
        header('Location: ../php/PageNotFound');
    switch ($sort) {
        case 'top':
            $articles = getAllNewsSortedBylikes();
            break;
        case 'controversial':
            $articles = getAllNewsSortedByControversial();
            break;
        case 'comments':
            $articles = getAllNewsSortedByComments();
            break;
        
        default:
            header('Location: ../php/PageNotFound');
            break;
    }
}
else $sort = '';


$maxPage = ceil(count($articles)/MAXPOSTPPAGE);

if(isset($_GET['p'])){
    $page = $_GET['p'];
    if(!is_numeric($page))
        header('Location: ../php/PageNotFound');
    if($page < $maxPage && $page > 0){
        $iMax = ($page * MAXPOSTPPAGE);
        $page -= 1;
    }
    elseif($page == $maxPage){
        $page -= 1;
        $iMax = count($articles);        
    }
    else
        header('Location: ../php/PageNotFound');
}
else{
    $page = 1; 
    if($page == $maxPage){
        $page -= 1;
        $iMax = count($articles);        
    }
    else{
        $page -= 1;
        $iMax = MAXPOSTPPAGE;
    }
    
  
} 

for ($i = $page * MAXPOSTPPAGE; $i < $iMax; $i++) { ?>
    
    <article>
            <header>
                <h1><a href="item?id=<?=$articles[$i]['id']?>"><?=$articles[$i]['title']?></a></h1>
            </header>
            <a href="item?id=<?=$articles[$i]['id']?>"><img src=<?=$articles[$i]['imageUrl']?> alt=""></a>
            <footer>
                <span class="author"><?=$articles[$i]['username']?></span>
                <?php if (isset($_SESSION['username'])) { 
                $opinion = getOpinionUserNews($articles[$i]['id'], $_SESSION['username']);
                ?>
                <div class="newsLikeDiv">
                    <input type="hidden" name="id" value="<?=$articles[$i]['id']?>">
                    <i class="fas fa-thumbs-up" <?php if ($opinion && $opinion[0]['upvote']) echo 'style="color: green;"';?>></i>                   
                    <span class="likes"><?=$articles[$i]['upvotes'] - $articles[$i]['downvotes']?></span>
                    <i class="fas fa-thumbs-down" <?php if ($opinion && $opinion[0]['downvote']) echo 'style="color: red;"';?>></i>
                </div>
                <?php } ?>
                
                <span class="tags">
<?php
$fulltags = explode(',', $articles[$i]['tags']);
foreach ($fulltags as $tag) {
    echo "<a href='tag?id=$tag'>#$tag</a> ";
}
?>              </span>
                <span class="date"><?=time_ago($articles[$i]['published'])?></span>
                <a class="comments" href="item?id=<?=$articles[$i]['id']?>#comments"><?=$articles[$i]['count']?></a>
            </footer>
        </article>
<?php }?>
</section>


    
<?php    
draw_pagination($page + 1, $maxPage, $sort);
draw_footer();
?>