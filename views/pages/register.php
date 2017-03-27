<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 23:31
 *
 * User site registration, sign up + Facebook integration
 */

//Form response checks

if (isset($_SESSION['error'])) {
    echo "Form incomplete, errors are highlighted bellow";
    unset($_SESSION['error']);
}

if (isset($_SESSION['register'])) {
    echo "Member registered successfully, you can login now.";
    unset($_SESSION['register']);
}


?>

<div class="small-6 large-8 large-centered columns">
    <div class="signup-panel">
        <h1 class="pageTitle">Register</h1>
        <p class="welcome"> Sign up for the RGU: Shelterstone club!</p>
        <form method="post">
            <div class="row collapse">
                <div class="small-2  columns">
                    <span class="prefix"><i class="fi-torso"></i></span>
                </div>
                <div class="small-10  columns">
                    <input type="text" placeholder="username" name="txtUsername" maxlength="50">
                </div>
            </div>
            <div class="row collapse">
                <div class="small-2 columns">
                    <span class="prefix">First Name</span>
                </div>
                <div class="small-10 columns">
                    <input type="text" placeholder="First Name" name="txtFirstName" maxlength="60" >
                </div>

            </div>
            <div class="row collapse">
                <div class="small-2 columns">
                    <span class="prefix">Last Name</span>
                </div>
                <div class="small-10 columns">
                    <input type="text" placeholder="Last Name" name="txtLastName"  maxlength="60" >
                </div>

            </div>
            <div class="row collapse">
                <div class="small-2 columns">
                    <span class="prefix"><i class="fi-mail"></i></span>
                </div>
                <div class="small-10  columns">
                    <input type="text" placeholder="email" name="txtEmail"  maxlength="250" >
                </div>
            </div>
            <div class="row collapse">
                <div class="small-2 columns ">
                    <span class="prefix"><i class="fi-lock"></i></span>
                </div>
                <div class="small-10 columns ">
                    <input type="password" placeholder="password" name="txtPassword">
                </div>
            </div>
            <input class="button large-centered" type="submit" name="btnSubmit" value="Register">
        </form>
        <p>Already have an account? <a href="./login">Login here &raquo</a></p>
    </div>
</div>
</div>
