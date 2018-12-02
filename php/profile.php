<?php
include_once './tpl.php';
include_once('../includes/session.php');

draw_header();
draw_aside();
?>

<h1> Profile</h1>
    <img src="<?=$_SESSION['profilePic']?>" alt="Photo">
    <h2>Username: ...</h2>
    <form>
        <label>
            New Username: <input type="text" name="username">
        </label>
        <input type="submit" value="Submit Username">
        <label>
            New Password: <input type="text" name="password">
        </label>
        <input type="submit" value="Submit Password">
    </form>

<?php
draw_footer();
?>