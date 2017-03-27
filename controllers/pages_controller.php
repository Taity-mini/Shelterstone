<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 15:53
 * Page Controller class
 * Used for various pages across the site
 */
class pages_controller
{

    //Standard pages
    public function home()
    {
        require_once('./views/pages/home.php');
    }

    public function search()
    {
        require_once('./views/pages/search.php');
    }

    //PROFILE PAGES

    //Profile for current user
    public function profile()
    {
        require_once('./views/pages/profile.php');
    }


    //View other user's profile
    public function viewProfile()
    {
        require_once('./views/pages/profile.php');
    }

    //Edit other user's profile
    public function profile_edit()
    {
        require_once('./views/pages/profile_edit.php');
    }

    //ABOUT US PAGES

    //Club
    public function club()
    {
        require_once('./views/pages/club.php');
    }

    public function committee()
    {
        require_once('./views/pages/committee.php');
    }

    public function joinUs()
    {
        require_once('./views/pages/join_us.php');
    }

    public function history()
    {
        require_once('./views/pages/history.php');
    }


    //Login and registration
    public function login()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./views/pages/login.php');

        $conn = dbConnect();

        if (isset($_POST['btnLogin'])) {

            if (empty($_POST['txtUsername']) || empty($_POST['txtPassword'])) {
                $_SESSION['error'] = true;
            } else {
                $user = new users();
                $user->setUsername($_POST['txtUsername']);
                $user->getUserIDFromUsername($conn);

                if ($user->Login($user->getUserID(), $_POST['txtPassword'], $conn)) {
                    $_SESSION['username'] = htmlentities($_POST['txtUsername']);
                    $_SESSION['userID'] =  $user->getUserID();



                    echo '<script> location.replace("../"); </script>';

                } else {
                    $_SESSION['error'] = true;
                }
            }
        }

    }

    public function logout()
    {
        unset($_SESSION);
        session_destroy();
        echo '<script> location.replace("../"); </script>';
    }

    public function register()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./views/pages/register.php');

        //Registration logic

        $conn = dbConnect();
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

        if (isset($_POST['btnSubmit'])) {

            $user = new users();

//            if (isset($_POST['txtUsername']) && (isset($_POST['txtPassword'])) && (isset($_POST['txtFirstName'])) && (isset($_POST['txtLastName']))) {

                //Get username from field
                $user->setUsername($_POST['txtUsername']);
//                if (!$user->doesUserNameExist($conn)) {
                    echo "Username passed!";

                    $user->setEmail($_POST['txtEmail']);
                    $user->setFirstName($_POST['txtFirstName']);
                    $user->setLastName($_POST['txtLastName']);

                    echo "fields matched";
                    //Create user in the database

                    if ($user->create($conn, $_POST['txtPassword'])) {
                            $_SESSION['register'] = true;
                             unset($_SESSION['error']);
                             echo "User registered";
                        }
                    }
                    else{
                        $_SESSION['error'] = true;
                    }
//                } else {
//                    $_SESSION['error'] = true;
//                }
//            } //Errors? Then display correct message
//            else {
//                $_SESSION['error'] = true;
//            }
    }


    //Error pages
    public function error()
    {
        require_once('views/pages/error.php');
    }

    public function notFound()
    {
        require_once('views/pages/404.php');
    }
}
