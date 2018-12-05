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

<!-- <section id="createPost">
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
</section> -->

<div class="createPost-page">
    <div class="form">
        <h1>Create a Post</h1>
        <form action="../php/action_create_post.php" enctype="multipart/form-data" method="POST" id="createPageForm">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="text" placeholder="Text (Optional)"></textarea>
            <p>Profile Picture</p>  
            <input name="img" size="35" type="file" placeholder="Profile Picture" required/>
            <input type="text" name="tags" placeholder="Tags (use #)" required>
            <button>Submit</button>
        </form>
        <div id="ajax-form-request-fill">
            <div id="loader">
                <div id="box"></div>
                <div id="hill"></div>
            </div>
        </div>
        <div id="ajax-form-failure-fill">
            <strong id="error">Incorrect username or password</strong><br>
            <button>Retry</button>
        </div>
        <div id="ajax-form-success-fill">
            <div class="checkmark" ></div>
        </div>
    </div>
</div>

<?php
draw_footer();
?>