<?php
include_once './tpl.php';
include_once '../includes/session.php';
include_once './functions.php';

if(!isset($_SESSION['previousPage']))
    $_SESSION['previousPage'] = '../php/frontpage.php';

draw_header();
draw_aside();
?>

<div class="login-page">

    <div class="form">
        <h1>Login</h1>
        <form action="../php/action_login.php" method="POST" id="loginForm">
            <input type="text" placeholder="username" name="username" required/>
            <input type="password" placeholder="password" name="password" required/>
            <input type="hidden" name="previousPage" value="<?=$_SESSION['previousPage']?>"/>
            <button>login</button>
            <p class="message">Not registered? <a href="../php/register.php">Create an account</a></p>
        </form>
        <div id="ajax-form-request-fill">
            <div id="loader">
                <div id="box"></div>
                <div id="hill"></div>
            </div>
        </div>
        <div id="ajax-form-failure-fill">
            <strong>Incorrect username or password</strong><br>
            <button>Retry</button>
        </div>
        <div id="ajax-form-success-fill">
            <div class="checkmark"></div>
        </div>
    </div>
</div>

<?php
draw_footer();
?>