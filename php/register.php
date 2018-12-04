<?php
include_once './tpl.php';
include_once('../includes/session.php');

if(!isset($_SESSION['previousPage']))
    $_SESSION['previousPage'] = '../php/frontpage';

draw_header();
draw_aside();
?>

<!-- <section id="register">
        <h1>Register</h1>
            <form action="../php/action_register.php" enctype="multipart/form-data" method="POST">
            <label>
                Username <input type="text" name="username">
            </label>
            <label>
                Real Name <input type="text" name="realName">
            </label>
            <label>
                Choose Image : <input name="img" size="35" type="file" />
            </label>
            <label>
                E-mail <input type="email" name="email">
            </label>
            <label>
                Password <input type="password" name="password">
            </label>
            <label>
                Confirm Password <input type="password" name="passwordConfirm">
            </label>
            <input type="submit" value="Register">
        </form>
    </section> -->

<div class="register-page">
    <div class="form">
        <h1>Register</h1>
        <form action="../php/action_register.php" enctype="multipart/form-data" method="POST" id="registerForm">
            <input type="text" name="username" placeholder="username" required>
            <input type="text" name="realName" placeholder="Real Name" required>
            <input name="img" size="35" type="file" placeholder="Profile Picture" required/>
            <p>Profile Picture</p>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" placeholder="password" name="password" required/>
            <input type="password" name="passwordConfirm" placeholder="Confirm Password" required>
            <button>Register</button>
            <p class="message">Already have an Account? <a href="../php/login">Log In</a></p>
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