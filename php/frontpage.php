<?php
include_once './functions.php';
include_once './tpl.php';
include_once('../includes/session.php');

define("MAXPOSTPPAGE", "5");

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
        
        default:
            header('Location: ../php/PageNotFound');
            break;
    }
}
else $sort = '';


$maxPage = ceil(count($articles)/5);

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
   $page = 0; 
   $iMax = 5;
} 




for ($i = $page * MAXPOSTPPAGE; $i < $iMax; $i++) { ?>
    
    <article>
            <header>
                <h1><a href="item?id=<?=$articles[$i]['id']?>"><?=$articles[$i]['title']?></a></h1>
            </header>
            <a href="item?id=<?=$articles[$i]['id']?>"><img src=<?=$articles[$i]['imageUrl']?> alt=""></a>
            <footer>
                <span class="author"><?=$articles[$i]['username']?></span>
                <span class="likes"><?=$articles[$i]['upvotes']?></span>
                <span class="dislikes"><?=$articles[$i]['downvotes']?></span>
                <span class="tags">
<?php
$fulltags = explode(',', $articles[$i]['tags']);
foreach ($fulltags as $tag) {
    echo "<a href='tag?id=$tag'>#$tag</a> ";
}
?>              </span>
                <span class="date"><?=time_ago($articles[$i]['published'])?></span>
                <a class="comments" href="item?id=<?=$articles[$i]['id']?>#comments"><?=$articles[$i]['comments']?></a>
            </footer>
        </article>
<?php }?>
</section>


    
<?php    
draw_pagination($page + 1, $maxPage, $sort);
draw_footer();
?>