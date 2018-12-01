<?php 

    include_once('./functions.php'); 

    $post = getNewsById($_GET['id']);
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
        
      <article>
        <header>
          <h1><a href="item.php?id=<?=$post['id']?>"><?=$post['title']?></a></h1>
        </header>
        <img id="byId" src=<?=$post['imageUrl']?> alt="">
        <p><?=$post['fulltext']?></p>
        <footer>
        <span class="author"><?=$post['username']?></span>
                <span class="likes"><?=$post['upvotes']?></span> 
                <span class="dislikes"><?=$post['downvotes']?></span> 
                <span class="tags">
                <?php
                $fulltags = explode(',', $post['tags']);
                foreach($fulltags as $tag) {
                    echo "<a href='tag.php?id=$tag'>#$tag</a> ";
                }
                ?>
                </span>
                <span class="date"><?=time_ago($post['published'])?></span>
        </footer>
        <section id="comments">
            <?php 
            $comments = getCommentsFromNewsId($post['id']);
            $numberComments = count($comments);

            if($numberComments == 0)
                echo '<h1>No Comments yet, be the first!</h1>'; //podemos melhorar isto
            else if($numberComments == 1)
                echo '<h1>' . $numberComments . ' Comment</h1>';
            else 
                echo '<h1>' . $numberComments . ' Comments</h1>';
            
                
            foreach($comments as $comment) { ?>
                <article class="comment">
                    <span class="user"><?=$comment['username']?></span>
                    <a href="../res/reply.png"><img src="../res/reply.png" alt="reply" width="50" height="50"></a>
                    <span class="likes"><?=$comment['upvotes']?></span> 
                    <span class="dislikes"><?=$comment['downvotes']?></span> 
                    <span class="date"><?=time_ago($comment['published'])?></span>
                    <p><?=$comment['text']?></p>
                    <?php $replys = getReplyFromCommentId($comment['id']);
                    foreach($replys as $reply) { ?>
                        <article class="reply">
                            <span class="user"><?=$reply['username']?></span>
                            <span class="likes"><?=$reply['upvotes']?></span> 
                            <span class="dislikes"><?=$reply['downvotes']?></span> 
                            <span class="date"><?=time_ago($reply['published'])?></span>
                            <p><?=$reply['text']?></p>
                        </article>
                    <?php } ?>
                </article>
            <?php } ?>
            
            <?php

            include('../includes/session.php');
            if (isset($_SESSION['username']) ){ ?>
                <form action="comment.php" method="POST">
                    <h2>Add your voice...</h2>
                    <label>Comment
                    <textarea name="comment"></textarea>            
                    </label>
                    <input type='hidden' name='postId' value='<?= $_GET['id']?>'/> 
                    <input type="submit" value="Comment">
                </form>
            <?php
            }
            else{
                 echo '<form action="../html/login.html">
                    <h2>You need to be logged in to comment!</h2>
                    <input type="submit" value="loggin">
                </form>';
            }?>
        </section>
        
      </article>
    </section>
    <footer>
      <p>&copy; Fake News, 2017</p>
    </footer>
  </body>
</html>