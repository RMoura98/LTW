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
      <h1><a href="frontpage">Super Legit News</a></h1>
      <h2><a href="frontpage">Where fake news are born!</a></h2>
      <div id="signup">
        <?php
        include_once('../includes/session.php');
        
if (isset($_SESSION['username'])) {
    echo '<a href="../php/profile">' . $_SESSION['username'] . '</a>';
    echo '<a href="../php/profile"><img class="avatar" src="'. $_SESSION['profilePic'] .'" alt="Avatar" ></a>';
    echo '<a href="../php/action_logout"><img class="avatar" src="../res/logout.png" alt="Logout" ></a>';
} else {
    echo '<a href="../php/register">Register</a>';
    echo '<a href="../php/login">Login</a>';
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

<?php 

/**
 * Draws the aside for all pages.
 */
function draw_aside($isFrontPage = FALSE) {  ?>
    <aside id="related">
        <?php if($isFrontPage) { ?>
            <a href="createPost"><button class="button" style="vertical-align:middle"><span>Create Post </span></button></a>
        <?php } ?>
        <article>
            <h1><a href="#">Duis arcu purus</a></h1>
            <p>Etiam mattis convallis orci eu malesuada. Donec odio ex, facilisis ac blandit vel, placerat ut lorem. Ut id sodales purus. Sed ut ex sit amet nisi ultricies malesuada. Phasellus magna diam, molestie nec quam a, suscipit finibus dui. Phasellus a.</p>
        </article>
        <article>
            <h1><a href="#">Sed efficitur interdum</a></h1>
            <p>Integer massa enim, porttitor vitae iaculis id, consequat a tellus. Aliquam sed nibh fringilla, pulvinar neque eu, varius erat. Nam id ornare nunc. Pellentesque varius ipsum vitae lacus ultricies, a dapibus turpis tristique. Sed vehicula tincidunt justo, vitae varius arcu.</p>
        </article>
        <article>
            <h1><a href="#">Vestibulum congue blandit</a></h1>
            <p>Proin lectus felis, fringilla nec magna ut, vestibulum volutpat elit. Suspendisse in quam sed tellus fringilla luctus quis non sem. Aenean varius molestie justo, nec tincidunt massa congue vel. Sed tincidunt interdum laoreet. Vivamus vel odio bibendum, tempus metus vel.</p>
        </article>
    </aside>
<?php } ?>

<?php 
/**
 * Draws the footer for all pages.
 */
function draw_footer() {  ?>
            <footer>
                <p>&copy; Fake News, 2017</p>
            </footer>
        </body>
    </html>
<?php } ?>





