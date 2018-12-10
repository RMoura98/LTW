<?php 

include_once('./functions.php'); 
include_once('./tpl.php');
include_once('../includes/session.php');

$post = getNewsById($_GET['id']);

if(!$post){
    header('Location: ../php/error_404');
}

$_SESSION['previousPage'] = '../php/item?id='.$_GET['id'];

if($post['imageUrl'])
    $postImgUrl = $post['imageUrl']; 
else
    $postImgUrl = 'https://s.imgur.com/images/logo-1200-630.jpg';

draw_header();
draw_aside();
?>

    <section id="news">
      <article>
        <header>
          <h1><a href="item?id=<?=$post['id']?>"><?=$post['title']?></a></h1>
        </header>
        <img id="byId" src="<?= $postImgUrl ?>" alt="">
        <p><?=$post['fulltext']?></p>
        <footer>
        <span class="author"> <a href="../php/profile?user=<?= $post['username']?>"> <?= $post['username']?>  </a></span>
                <?php if (isset($_SESSION['username'])) { 
                $opinion = getOpinionUserNews($post['id'], $_SESSION['username']);
                ?>
                <div class="newsLikeDiv">
                    <input type="hidden" name="id" value="<?=$post['id']?>">
                    <i class="fas fa-thumbs-up" <?php if ($opinion && $opinion[0]['upvote']) echo 'style="color: green;"';?>></i>                   
                    <span class="likes"><?=$post['upvotes'] - $post['downvotes']?></span>
                    <i class="fas fa-thumbs-down" <?php if ($opinion && $opinion[0]['downvote']) echo 'style="color: red;"';?>></i>
                </div>
                <?php } ?>
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
            <?php if (isset($_SESSION['username'])) { ?>
            <div class="hiddenBox" style="display:none;">
                <form action="../php/action_reply.php" style="padding-right: 0px;" method="POST">
                    <label>Reply to <a src="../php/profile?user="></a>
                    <textarea name="reply" style="width: 430px; margin-right:10px;" required></textarea>
                    </label>
                    <input type='hidden' name='commId' /> 
                    <input type="submit" style="margin-left: 30px;" value="Comment">
                </form>
                <i class="fas fa-times" style="padding-right: 10px; padding-top: 10px;"></i>
            </div>
            <?php }
            $comments = getCommentsFromNewsId($post['id']);
            $numberComments = $post['count'];

            if($numberComments == 0)
                echo '<h1>No Comments yet, be the first!</h1>'; //podemos melhorar isto
            else if($numberComments == 1)
                echo '<h1>' . $numberComments . ' Comment</h1>';
            else 
                echo '<h1>' . $numberComments . ' Comments</h1>';
            
                
            foreach($comments as $comment) { ?>
                <article class="comment">
                    <div class="part">
                        <span class="user"><?=$comment['username']?></span>
                        <?php if (isset($_SESSION['username'])) { 
                        $opinion1 = getOpinionUserComments($comment['id'], $_SESSION['username']);
                        ?>
                        <div class="commLikeDiv">
                            <input type="hidden" name="id" value="<?=$comment['id']?>">
                            <i class="fas fa-thumbs-up" <?php if ($opinion1 && $opinion1[0]['upvote']) echo 'style="color: green;"';?>></i>                   
                            <span class="likes"><?=$comment['upvotes'] - $comment['downvotes']?></span>
                            <i class="fas fa-thumbs-down" <?php if ($opinion1 && $opinion1[0]['downvote']) echo 'style="color: red;"';?>></i>
                        </div>
                        <input type="hidden" name="id" value="<?=$comment['id']?>">
                        <i class="fas fa-reply"></i>
                        <?php } ?>
                        <span class="date"><?=time_ago($comment['published'])?></span>
                    </div>
                    <p><?=$comment['text']?></p>
                    <?php $replys = getReplyFromCommentId($comment['id']);
                    foreach($replys as $reply) { ?>
                        <article class="reply">
                            <div class="part">
                                <span class="user"><?=$reply['username']?></span>
                                <?php if (isset($_SESSION['username'])) { 
                                $opinion2 = getOpinionUserReplys($reply['id'], $_SESSION['username']);
                                ?>
                                <div class="replyLikeDiv">
                                    <input type="hidden" name="id" value="<?=$reply['id']?>">
                                    <i class="fas fa-thumbs-up" <?php if ($opinion2 && $opinion2[0]['upvote']) echo 'style="color: green;"';?>></i>                   
                                    <span class="likes"><?=$reply['upvotes'] - $reply['downvotes']?></span>
                                    <i class="fas fa-thumbs-down" <?php if ($opinion2 && $opinion2[0]['downvote']) echo 'style="color: red;"';?>></i>
                                </div>
                                <!-- <i class="fas fa-reply"></i> -->
                                <?php } ?>
                                <span class="date"><?=time_ago($reply['published'])?></span>
                            </div>
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
                    <textarea name="comment" required></textarea>
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