<?php
include_once './functions.php';
include_once './tpl.php';
include_once('../includes/session.php');

if(!isset($_GET['q'])){
    header('Location: ../php/error_404.php');
    exit();
}


draw_header();
draw_aside();
?>
    <section id="news">
<?php

$articles = getAllNewsLike($_GET['q']);

if(!$articles) {?>
    <h1 style="padding-left: 25px;">Sorry, there were no results for "<?= $_GET['q'] ?>"</h1>
<?php } 
else {?>

    <h1 style="padding-left: 25px;">Search results for: "<?= $_GET['q'] ?>"</h1>
    <?php  
    for ($i = 0; $i < count($articles); $i++) {
        draw_PostS($articles[$i]['id'], $articles[$i]['title'], $articles[$i]['username'], $articles[$i]['imageUrl'], $articles[$i]['count'], $articles[$i]['published'], $articles[$i]['tags'], $articles[$i]['upvotes'], $articles[$i]['downvotes']);
    }
}
?>
</section>

<?php
draw_footer();
?>