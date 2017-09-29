<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait(1504693)
 * Date: 10/03/2017
 * Time: 16:51
 * Login page view template
 */

?>

<div class="medium-6 medium-centered large-6 large-centered columns">
    <h1 class="pageTitle">Login</h1>
    <form method="post">
        <div class="row column log-in-form">
            <h4 class="text-center">Log in with your username</h4>
            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="alert-box alert radius centre">The username and/or password you entered was incorrect.</p>';
                unset($_SESSION['error']);

                echo formStart();
                echo textInputEmptyError(true, "Username", "txtUsername", "errUsername", "", 8);
                echo passwordInputEmptyError(true, "Password", "txtPassword", "errPassword", "", 50);
                echo formEndWithButton("Login");
            } else {
                echo formStart();
                echo textInputBlank(true, "Username", "txtUsername", 8);
                echo passwordInputBlank(true, "Password", "txtPassword", 50);
                echo formEndWithButton("Login");
            }
            ?>
            </div>
            <p class="text-center"><a href="#">Forgot your password?</a></p>
        </div>
    </form>
</div>
<div class="row">
    <div class="small-5 small-centered columns">
<!--        --><?php
//        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
//        ?>
<!--        <button href="#" class="facebook button split"><span></span>sign in with facebook</button>-->
    </div>
</div>


