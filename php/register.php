<?php
include_once './tpl.php';
include_once('../includes/session.php');
include_once './functions.php';

if(!isset($_SESSION['previousPage']))
    $_SESSION['previousPage'] = '../php/frontpage.php';

draw_header();
draw_aside();
?>

<div class="register-page">
    <div class="form">
        <h1>Register</h1>
        <form action="../php/action_register.php" enctype="multipart/form-data" method="POST" id="registerForm">
            <input type="text" name="username" placeholder="username" required>
            <input type="text" name="realName" placeholder="Real Name" required>
            <input name="img" size="35" style="width: 280px;" type="file" placeholder="Profile Picture" required/>
            <p>Picture <i class="fas fa-image"></i> </p>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" placeholder="password" name="password" required/>
            <input type="password" name="passwordConfirm" placeholder="Confirm Password" required>
            <button>Register</button>
            <p class="message">Already have an Account? <a href="../php/login.php">Log In</a></p>
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