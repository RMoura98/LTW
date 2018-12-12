<?php
include_once './functions.php';
include_once './tpl.php';
include_once '../includes/session.php';

if (!isset($_SESSION['username']) ){ 
    $_SESSION['previousPage'] = '../php/createPost.php';
    header('Location: ../php/login.php');
    exit();
}

draw_header();
draw_aside();
?>

<div class="createPost-page">
    <div class="form">
        <h1>Create a Post</h1>
        <form action="../php/action_create_post.php" enctype="multipart/form-data" method="POST" id="createPageForm">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="text" placeholder="Text (Optional)"></textarea>
            <div id="askPic" style="display: -webkit-box; ">
                <p style="    margin-right: 15px;">Picture <i class="fas fa-image"></i></p>  
                <input name="img" size="35" style="width: 275px;" type="file" placeholder="Profile Picture" required/>
            </div>
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