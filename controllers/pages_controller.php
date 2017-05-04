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

        require_once('./models/gallery_photos.php');
        require_once('./models/gallery_albums.php');
        require_once('./models/users.php');
        require_once('./models/news.php');


        $conn = dbConnect();
        $user = new users();
        $newsArticle = new news();

        //Security checks - select which news visibility to display
        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if (!$groups->userFullAccess($conn, $_SESSION['userID'])) {
                $newsList = $newsArticle->getAllNonCommitteeNews($conn);
            } else {
                $newsList = $newsArticle->getAlLNews($conn);
            }
        } else {
            $newsList = $newsArticle->getAllPublicNews($conn);
        }


        $albums = new gallery_album("7");
        if ($albums->doesExist($conn)) {
            $photos = new gallery_photos();
            $photos->setAlbumID($albums->getAlbumID());
            $photo_listing = $photos->listPhotoAlbum($conn);
        } else {
            $photos = null;
            $photo_listing = null;
        }


        $this->data['newsArticle'] = $newsArticle;
        $this->data['newsList'] = $newsList;
        $this->data['author'] = $user;
        $this->data['albums'] = $albums;
        $this->data['photos'] = $photos;
        $this->data['photoList'] = $photo_listing;

        //Extract data array to display variables on view template
        extract($this->data);

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

        } else { //Show login page otherwise
            $this->redirect("/login");
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

            //Security and error checks
            if (!$user->doesExist($conn)) {
                $this->redirect("/error");
            }

            $this->data['profile'] = $user;
            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/pages/profile.php');
        } else { //Show error page otherwise
            $this->redirect("/login");
        }
    }


    //Edit other user's profile
    public function profile_edit()
    {
        //Check if user is logged in first
        if (isset($_SESSION['userID'])) {
            $conn = dbConnect();
            $userID = $_SESSION['params']['userID'];
            $user = new users($userID);
            $user->getAllDetails($conn);
            $groups = new users_groups($user->getUserID(), $user->getGroupID());
            $limited_edit = false;

            //Security and error checks
            if (!$user->doesExist($conn)) {
                $this->redirect("/error");
            }

            //No Full access? Show 403 error message
            if (!$groups->userFullAccess($conn, $_SESSION['userID'])) {
                //Not full access and editing someone else's profile - see 403 page
                if ($_SESSION['userID'] !== $userID) {
                    $this->redirect("error");
                    exit;
                } else if ($_SESSION['userID'] == $userID) {
                    $limited_edit = true;
                }
            }


            //Perform user profile update
            if (isset($_POST['btnSubmit'])) {
                $conn = dbConnect();
                $userID = $_SESSION['params']['userID'];

                //Input validation checks
                if ($user->isInputValid($conn, $_POST['txtEmail'], $_POST['txtFirstName'], $_POST['txtLastName'],
                    $_POST['txtBio'], $_POST['txtInterests'], $_POST['txtLink'], $_POST['txtCertifications'])
                ) {

                    //Get data from fields
                    $update = new users($userID);
                    $update->getAllDetails($conn);
                    $update->setEmail($_POST['txtEmail']);
                    $update->setFirstName($_POST['txtFirstName']);
                    $update->setLastName($_POST['txtLastName']);
                    $update->setBio($_POST['txtBio']);
                    $update->setInterests($_POST['txtInterests']);
                    $update->setCertifications($_POST['txtCertifications']);
                    $update->setLink(($_POST['txtLink']));
                    $driver = (isset($_POST['chkDriver']));
                    $update->setDriver($driver);

                    if (!$limited_edit) {
                        //Admin only fields
                        //Profile flag checks
                        $approved = (isset($_POST['chkApproved']));
                        $accredited = (isset($_POST['chkAccredited']));
                        $banned = (isset($_POST['chkBanned']));

                        $update->setApproved($approved);
                        $update->setAccredited($accredited);
                        $update->setBanned($banned);

                        $update->setRole($_POST['txtRole']);
                        $update->setGroupID($_POST['sltGroup']);
                    }

                    //Update user in the database
                    if ($update->updateUser($conn)) {
                        $_SESSION['update'] = true;
                        //Redirect to corresponding profile url
                        if ($limited_edit) {
                            $this->redirect("/profile");
                        } else {
                            $this->redirect("/profile/view/" . $userID);
                        }
                    } else {
                        $_SESSION['error'] = true;
                    }

                } else { //Show error if input validation fails
                    $_SESSION['error'] = true;
                }
            }

            //Display user data in forms
            $this->data['profile'] = $user;
            $this->data['group'] = $groups;
            $this->data['limitedEdit'] = $limited_edit;
            //Extract data array to display variables on view template
            extract($this->data);
            include('./inc/forms.php');
            require_once('./views/pages/profile_edit.php');
        } else { //Show login page otherwise
            $this->redirect("/login");
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
        //If user already logged in - redirect to home screen
        if (isset($_SESSION['userID'])) {
            $this->redirect("/");
        }

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

                    $this->redirect("/");

                } else {
                    $_SESSION['error'] = true;
                }
            }
        }

    }


    public function register()
    {
        //If user already logged in - redirect to home screen
        if (isset($_SESSION['userID'])) {
            $this->redirect("/");
        }

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
