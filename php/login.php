<?php
include_once './tpl.php';
include_once '../includes/session.php';

draw_header();
draw_aside();
?>



<section id="login">
    <h1>Login</h1>
    <form action="../php/action_login.php" method="POST">
        <label>
            Username <input type="text" name="username">
        </label>
        <label>
            Password <input type="password" name="password">
        </label>
        <input type="submit" value="Login">
    </form>
</section>

<?php
draw_footer();
?>