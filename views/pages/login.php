<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait(1504693)
 * Date: 10/03/2017
 * Time: 16:51
 * Login page view template
 */


if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Login Error!</h5>
          <p>The username and/or password you entered was incorrect.</p>
          </div>';
    unset($_SESSION['error']);
}
?>

<div class="medium-6 medium-centered large-6 large-centered columns">
    <h1 class="pageTitle">Login</h1>
    <form method="post">
        <div class="row column log-in-form">
            <h4 class="text-center">Log in with your username</h4>
            <?php
            //Input validation checks
            if (isset($_POST["btnSubmit"])) {
                if (empty($_POST["txtFirstName"])) {
                    echo ' <label>Username
                            <input type="text" placeholder="username" name="txtUsername" value ="' . $_POST["txtUsername"] . '">
                            </label>';
                } else {
                    echo ' <label>Username
                            <input type="text" placeholder="username" name="txtUsername">
                            </label>';
                }
            } else {
                echo ' <label>Username
                            <input type="text" placeholder="username" name="txtUsername">
                            </label>';
            }
            ?>
            <label>Password
                <input type="password" placeholder="Password" name="txtPassword">
            </label>
            <!--            <input id="show-password" type="checkbox"><label for="show-password">Show password</label>-->
            <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                <input class="button" type="submit" name="btnLogin" value="Login">
            </div>

            <p class="text-center"><a href="#">Forgot your password?</a></p>
        </div>
    </form>
</div>
<div class="row">
    <div class="small-5 small-centered columns">
        <button href="#" class="facebook button split"><span></span>sign in with facebook</button>
    </div>
</div>


