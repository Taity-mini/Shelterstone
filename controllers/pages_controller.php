<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 15:53
 * Page Controller class
 * Used for various pages across the site
 */
class pages_controller extends controller
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
        if (isset($_SESSION['userID'])) {

            $conn = dbConnect();

            $user = new users($_SESSION['userID']);
            $user->getAllDetails($conn);
            $this->data['profile'] = $user;
            //Extract data array to display variables on view template
            extract($this->data);
            require_once('./views/pages/profile.php');

        } else { //Show error page otherwise
            $this->error();
        }
    }


    //View other user's profile
    public function viewProfile()
    {
        if (isset($_SESSION['userID'])) {

            $conn = dbConnect();
            $userID = $_SESSION['params']['userID'];
            $user = new users($userID);
            $user->getAllDetails($conn);
            $this->data['profile'] = $user;
            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/pages/profile.php');
        } else { //Show error page otherwise
            $this->error();
        }
    }

    //Edit other user's profile
    public function profile_edit()
    {
        //Check if user is logged in first
        if (isset($_SESSION['userID'])) {
            include('./inc/forms.php');

            //Perform user profile update
            if (isset($_POST['btnSubmit'])) {
                $conn = dbConnect();
                $userID = $_SESSION['params']['userID'];
                //if (isset($_POST['txtUsername']) && (isset($_POST['txtWebsite'])) && (isset($_POST['txtEmail'])) && (isset($_POST['txtFirstName']))&& (isset($_POST['txtLastName']))) {
                //Get data from fields
                $update = new users($userID);
                $update->getAllDetails($conn);
                $update->setEmail($_POST['txtEmail']);
                $update->setFirstName($_POST['txtFirstName']);
                $update->setLastName($_POST['txtLastName']);
                $update->setBio($_POST['txtBio']);
                $update->setInterests($_POST['txtInterests']);
                $update->setRole($_POST['txtRole']);
                $update->setCertifications($_POST['txtCertifications']);
                $update->setLink(($_POST['txtLink']));
                $update->setGroupID($_POST['sltGroup']);

                //Profile flag checks
                $approved   = (isset($_POST['chkApproved']));
                $accredited = (isset($_POST['chkAccredited']));
                $driver     = (isset($_POST['chkDriver']));
                $banned     = (isset($_POST['chkBanned']));

                $update->setApproved($approved);
                $update->setAccredited($accredited);
                $update->setDriver($driver);
                $update->setBanned($banned);




                //Update user in the database
                if ($update->updateUser($conn)) {
                    var_dump($update);
                    $_SESSION['update'] = true;
                    echo "Working";
                    //header('Location: '.$_SESSION["domain"].'/profile/view/' .  $userID);
                } else {
                    $_SESSION['error'] = true;
                }
            }

            //Display user data in forms
            $conn = dbConnect();
            $userID = $_SESSION['params']['userID'];

            $user = new users($userID);
            $user->getAllDetails($conn);
            $this->data['profile'] = $user;

            $groups = new users_groups($user->getUserID(), $user->getGroupID());

            $this->data['group'] = $groups;
            //Extract data array to display variables on view template
            extract($this->data);
            require_once('./views/pages/profile_edit.php');
        } else { //Show error page otherwise
            $this->error();
        }
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
                    $_SESSION['userID'] = $user->getUserID();


                    echo '<script> location.replace("../"); </script>';

                } else {
                    $_SESSION['error'] = true;
                }
            }
        }

    }


    public function register()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./views/pages/register.php');

        //Registration logic
        $conn = dbConnect();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

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
        } else {
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
