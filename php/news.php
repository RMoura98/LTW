<?php

include_once('./connection.php'); //era istoooooooo aiiiiii 3 horas!!!

function getAllNews() {
    global $db;
    $stmt = $db->prepare('
    SELECT news.*, users.*, COUNT(comments.id) AS comments
    FROM news JOIN
        users USING (username) LEFT JOIN
        comments ON comments.news_id = news.id
    GROUP BY news.id, users.username
    ORDER BY published DESC
    ');
    $stmt->execute();
    return $stmt->fetchAll();
}
function getNewsById($id) {
  global $db;
  $stmt = $db->prepare('SELECT * FROM news JOIN users USING (username) WHERE id = ?');
  $stmt->execute(array($id));
  return $stmt->fetch();
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

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
      <h1><a href="news.php">Super Legit News</a></h1>
      <h2><a href="news.php">Where fake news are born!</a></h2>
      <div id="signup">
        <?php 
        include('../includes/session.php');
        if (isset($_SESSION['username']) ){
            echo '<a href="../html/profile.html">' . $_SESSION['username'] . '</a>';
            echo '<a href="../html/profile.html"><img class="avatar" src="../res/avatar.png" alt="Avatar" ></a>';
            echo '<a href="../php/logout.php"><img class="avatar" src="../res/logout.png" alt="Logout" ></a>';
        }
        else{
            echo '<a href="../html/register.html">Register</a>';
            echo '<a href="../html/login.html">Login</a>';
        }
        ?>
       
        
      </div>
    </header>
    <aside id="related">
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
    <section id="news">
    <?php 
    $articles = getAllNews();
    foreach($articles as $article) { ?>
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
                    echo "<a href='index.php'>#$tag</a> ";
                }
                ?>
                </span>
                <span class="date"><?=time_elapsed_string('@' . $article['published'])?></span>
                <a class="comments" href="../html/item.html#comments"><?=$article['comments']?></a>
            </footer>
        </article>
    <?php } ?>
    </section>
    <footer>
      <p>&copy; Fake News, 2017</p>
    </footer>
  </body>
</html>
