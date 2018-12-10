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

for ($i = $page * MAXPOSTPPAGE; $i < $iMax; $i++) { 
    draw_PostS($articles[$i]['id'], $articles[$i]['title'], $articles[$i]['username'], $articles[$i]['imageUrl'], $articles[$i]['count'], $articles[$i]['published'], $articles[$i]['tags'], $articles[$i]['upvotes'], $articles[$i]['downvotes']);
}?>
</section>

<?php    
draw_pagination($page + 1, $maxPage, $sort);
draw_footer();
?>