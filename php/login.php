<?php
include_once './tpl.php';
include_once '../includes/session.php';

draw_header();
draw_aside();
?>



<!-- <section id="login">
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
</section> -->

<div class="login-page">
    <div class="form">
        <h1>Login</h1>
        <form action="../php/action_login.php" method="POST">
            <input type="text" placeholder="username" name="username"/>
            <input type="password" placeholder="password" name="password"/>
            <button>login</button>
            <p class="message">Not registered? <a href="../php/register">Create an account</a></p>
        </form>
    </div>
</div>

<?php
draw_footer();
?>