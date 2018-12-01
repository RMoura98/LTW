<?php 

function draw_header() { 
/**
 * Draws the header for all pages. 
 */?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>Super LTW News 2018</title>
    <meta charset="UTF-8">
    <title>Super Legit News</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/layout.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link href="../css/comments.css" rel="stylesheet">
    <link href="../css/forms.css" rel="stylesheet">
  </head>
  <body>
    <header>
      <h1><a href="news.php">Super Legit News</a></h1>
      <h2><a href="news.php">Where fake news are born!</a></h2>
      <div id="signup">
        <?php
include '../includes/session.php';
if (isset($_SESSION['username'])) {
    echo '<a href="../html/profile.html">' . $_SESSION['username'] . '</a>';
    echo '<a href="../html/profile.html"><img class="avatar" src="'. $_SESSION['profilePic'] .'" alt="Avatar" ></a>';
    echo '<a href="../php/logout.php"><img class="avatar" src="../res/logout.png" alt="Logout" ></a>';
} else {
    echo '<a href="../html/register.html">Register</a>';
    echo '<a href="../html/login.html">Login</a>';
}?></div>
</header>
      <!-- <?php if (isset($_SESSION['messages'])) {?>
        <section id="messages">
          <?php foreach($_SESSION['messages'] as $message) { ?>
            <div class="<?=$message['type']?>"><?=$message['content']?></div>
          <?php } ?>
        </section>
      <?php unset($_SESSION['messages']); } ?> -->
<?php } ?>

<?php function draw_footer() { 
/**
 * Draws the footer for all pages.
 */
 ?>
        <footer>
            <p>&copy; Fake News, 2017</p>
        </footer>
    </body>
</html>
<?php } ?>