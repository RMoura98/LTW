<?php 
/**
 * Draws the header for all pages. 
 */
function draw_header() { 
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Super LTW News 2018</title>
    <!-- <link rel="icon" href="../assets/favicon.ico"> -->
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
      <h1><a href="frontpage">Super Legit News</a></h1>
      <h2><a href="frontpage">Where fake news are born!</a></h2>
      <div id="signup">
        <?php
        include_once('../includes/session.php');

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
      <!-- <?php if (isset($_SESSION['messages'])) {?>
        <section id="messages">
          <?php foreach($_SESSION['messages'] as $message) { ?>
            <div class="<?=$message['type']?>"><?=$message['content']?></div>
          <?php } ?>
        </section>
      <?php unset($_SESSION['messages']); } ?> -->
<?php } ?>

<?php 

/**
 * Draws the aside for all pages.
 */
function draw_aside($isFrontPage = FALSE) {  ?>
    <aside id="related">
        <?php if($isFrontPage) { ?>
            <a href="../php/createPost">
                <button class="buttonCreate" style="vertical-align:middle">
                    <span>Create Post <i class="fas fa-pencil-alt" style="margin-left: 10px; font-size: large;"></i></span>
                </button>
            </a>
            <div class="dropdown">
                <button class="dropbtn">Sort <i class="fas fa-sort-amount-down"></i></button>
                <div class="dropdown-content">
                    <a href="../php/frontpage">New</a>
                    <a href="../php/frontpage?s=top">Top</a>
                    <a href="../php/frontpage?s=controversial">Controversial</a>
                    <a href="../php/frontpage?s=comments">Most Commented</a>
                    <a href="../php/random">Random</a>
                </div>
            </div>
        <?php } $topDayPost = getTopPostDay();?>
        <article>
            <h1><a href="../php/item?id=<?=$topDayPost['id']?>"> <i class="fab fa-hotjar"></i> <?=$topDayPost['title']?></a></h1>
        </article>
    </aside>
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






