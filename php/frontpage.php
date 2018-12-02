<?php
include_once './functions.php';
include_once './tpl.php';
include_once('../includes/session.php');

$_SESSION["previousPage"] = '../php/frontpage';

draw_header();
draw_aside(TRUE);
?>
    <section id="news">
<?php

$articles = getAllNews();

if(isset($_GET['s'])){
    switch ($_GET['s']) {
        case 'top':
            $articles = getAllNewsSortedBylikes();
            break;
        case 'controversial':
            $articles = getAllNewsSortedByControversial();
            break;
        
        default:
            break;
    }
}

foreach ($articles as $article) { ?>
        <article>
            <header>
                <h1><a href="item?id=<?=$article['id']?>"><?=$article['title']?></a></h1>
            </header>
            <a href="item?id=<?=$article['id']?>"><img src=<?=$article['imageUrl']?> alt=""></a>
            <footer>
                <span class="author"><?=$article['username']?></span>
                <span class="likes"><?=$article['upvotes']?></span>
                <span class="dislikes"><?=$article['downvotes']?></span>
                <span class="tags">
<?php
$fulltags = explode(',', $article['tags']);
foreach ($fulltags as $tag) {
    echo "<a href='tag?id=$tag'>#$tag</a> ";
}
?>              </span>
                <span class="date"><?=time_ago($article['published'])?></span>
                <a class="comments" href="item?id=<?=$article['id']?>#comments"><?=$article['comments']?></a>
            </footer>
        </article>
        <?php }?>
    </section>
    
<?php    
draw_footer();
?>