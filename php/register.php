<?php
include_once './tpl.php';
include_once('../includes/session.php');

draw_header();
draw_aside();
?>

<section id="register">
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
    </section>

<?php
draw_footer();
?>