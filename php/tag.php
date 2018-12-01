<?php 
include_once('./functions.php');
include_once('./tpl.php');
include_once('../includes/session.php');

$tagId = $_GET['id'];

$_SESSION["previousPage"] = '../php/tag.php?id='.$_GET['id'];

draw_header();
draw_aside();

?>

    <section id="news">
    <div id="tag">
        <h1>#<?=$tagId?></h1>
    </div>
    
    <?php 
    $articles = getAllNews();
    foreach($articles as $article) { 
        $fulltags = explode(',', $article['tags']);
        foreach($fulltags as $tag) {
            if (strcasecmp($tagId, $tag) == 0){    ?>
                <article>
                <header>
                    <h1><a href="item.php?id=<?=$article['id']?>"><?=$article['title']?></a></h1>
                </header>
                <a href="item.php?id=<?=$article['id']?>"><img src=<?=$article['imageUrl']?> alt=""></a>
                <footer>
                    <span class="author"><?=$article['username']?></span>
                    <span class="likes"><?=$article['upvotes']?></span> 
                    <span class="dislikes"><?=$article['downvotes']?></span> 
                    <span class="tags">
                    <?php
                    $fulltags = explode(',', $article['tags']);
                    foreach($fulltags as $tag) {
                        echo "<a href='tag.php?id=$tag'>#$tag</a> ";
                    }
                    ?>
                    </span>
                    <span class="date"><?=time_ago($article['published'])?></span>
                    <a class="comments" href="item.php?id=<?=$article['id']?>#comments"><?=$article['comments']?></a>
                </footer>
            </article>
            <?php
            break;
            }
        }
        
       
     } ?>
    </section>
<?php
draw_footer();
?>