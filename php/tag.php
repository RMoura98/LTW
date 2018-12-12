<?php 
include_once('./functions.php');
include_once('./tpl.php');
include_once('../includes/session.php');

if(!isset($_GET['id'])){
    header('Location: ../php/error_404.php');
    exit();
}


$tagId = $_GET['id'];

$_SESSION["previousPage"] = '../php/tag.php?id='.$_GET['id'];

draw_header();
draw_aside();

?>

    <section id="news">
    <div id="tag">
        <h1 style="margin-left: 25px;">#<?=$tagId?></h1>
    </div>
    
    <?php 
    $articles = getAllNews();
    foreach($articles as $article) { 
        $fulltags = explode(',', $article['tags']);
        foreach($fulltags as $tag) {
            if (strcasecmp($tagId, $tag) == 0){
                draw_PostS($article['id'], $article['title'], $article['username'],
                $article['imageUrl'], $article['count'], $article['published'], 
                $article['tags'], $article['upvotes'], $article['downvotes']);
            break;
            }
        }
        
       
     } ?>
    </section>
<?php
draw_footer();
?>