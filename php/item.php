<?php 

include_once('./functions.php'); 
include_once('./tpl.php');
include_once('../includes/session.php');

$post = getNewsById($_GET['id']);

if(!$post){
    header('Location: ../php/error_404');
}

$_SESSION['previousPage'] = '../php/item?id='.$_GET['id'];

draw_header();
draw_aside();
?>

    <section id="news">
        
      <article>
        <header>
          <h1><a href="item?id=<?=$post['id']?>"><?=$post['title']?></a></h1>
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
                    echo "<a href='tag?id=$tag'>#$tag</a> ";
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
                <form action="action_comment.php" method="POST">
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
                 echo '<form action="../php/login.php">
                    <h2>You need to be logged in to comment!</h2>
                    <input type="submit" value="loggin">
                </form>';
            }?>
        </section>
        
      </article>
    </section>

<?php
draw_footer();
?> 