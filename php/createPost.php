<?php
include_once './tpl.php';
include_once '../includes/session.php';

if (!isset($_SESSION['username']) ){ 
    $_SESSION['previousPage'] = '../php/createPost';
    header('Location: ../php/login');
    exit();
}

draw_header();
draw_aside();
?>

<section id="login">
    <h1>Create Post</h1>
    <form action="../php/action_create_post.php" enctype="multipart/form-data" method="POST">
        <label>
            Title : <input type="text" name="title">
        </label>
        <label>
            Text : <textarea name="text"></textarea>            
        </label>
        <label>
            Choose Image : <input name="img" size="35" type="file" />
        </label>
        <label>
            Tags (use #) : <input type="text" name="tags">
        </label>
        <input type="submit" value="Submit">
    </form>
</section>

<?php
draw_footer();
?>