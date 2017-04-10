<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait(1504693)
 * Date: 10/03/2017
 * Time: 16:02
 *
 * News pages controller
 */
class news_controller extends controller
{

    // Main News page
    public function index()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $conn = dbConnect();
        $user = new users();
        $newsArticle = new news();
        $adding = false;

        $heading = "";
        $description = "";


        //Security checks - select which news visibility to display
        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if (!$groups->userFullAccess($conn, $_SESSION['userID'])) {
                $newsList = $newsArticle->getAllNonCommitteeNews($conn);
                $heading = "News";
                $description = "All member/public news from Shelterstone";
            } else {
                $adding = true;
                $heading = "News";
                $description = "All news from Shelterstone";
                $newsList = $newsArticle->getAlLNews($conn);
            }
        } else {
            $heading = "News";
            $description = "All public Shelterstone news";
            $newsList = $newsArticle->getAllPublicNews($conn);
        }


        //Display user data in forms
        $this->data['newsArticle'] = $newsArticle;
        $this->data['newsList'] = $newsList;
        $this->data['author'] = $user;
        $this->data['create'] = $adding;
        $this->date['heading'] = $heading;
        $this->date['description'] = $description;

        //Extract data array to display variables on view template
        extract($this->data);

        require_once('./views/news/news.php');
    }

    public function article()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $conn = dbConnect();
        $canEdit = false;

        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if ($groups->newsFullAccess($conn, $_SESSION['userID'])) {
                $canEdit = true;
            }
        }

        $newsID = $_SESSION['params']['newsID'];

        $news = new news();
        $news->setNewsID($newsID);
        $news->getAllDetails($conn);

        $user = new users($news->getUserID());
        $user->getAllDetails($conn);

        //Security and error checks
        if (!$news->doesExist($conn)) {
            $this->redirect("/error");
        }

        $this->data['newsArticle'] = $news;
        $this->data['author'] = $user;
        $this->data['edit'] = $canEdit;
        //Extract data array to display variables on view template
        extract($this->data);
        require_once('./views/news/news_article.php');
    }

    public function announcements()
    {
        require_once('./views/news/announcements.php');
    }

    //Creating and editing

    public function addNews()
    {
        if (isset($_SESSION['userID'])) {
            require_once('./models/news.php');
            require_once('./models/users.php');

            $conn = dbConnect();

            $groups = new users_groups();
            if (!$groups->newsFullAccess($conn, $_SESSION['userID'])) {
                $this->redirect("/error");
            }

            //Perform update
            if (isset($_POST['btnSubmit'])) {
                $conn = dbConnect();

                $news = new News();

                $news->setTitle($_POST['txtTitle']);
                $news->setUserID($_SESSION['userID']);
                $news->setMainBody($_POST['txtBody']);
                $news->setType($_POST['sltType']);
                $news->setVisibility($_POST['sltVisibility']);

                if ($news->create($conn)) {
                    $_SESSION['create'] = true;
                    $this->redirect("/news");
                }
            }

            require_once('./views/news/create_news.php');
        } else { //Show login page otherwise
            $this->redirect("/login");
        }

    }

    public function editNews()
    {
        //Check if user is logged in first
        if (isset($_SESSION['userID'])) {
            require_once('./models/news.php');
            require_once('./models/users.php');

            $conn = dbConnect();

            $newsID = $_SESSION['params']['newsID'];

            $news = new news();
            $news->setNewsID($newsID);
            $news->getAllDetails($conn);


            // Security and error checks
            if (!$news->doesExist($conn)) {
                $this->redirect("/error");
            }

            //Check if logged in user has full access for editing news article
            $groups = new users_groups();
            if (!$groups->newsFullAccess($conn, $_SESSION['userID'])) {
                $this->redirect("/error");
            }


            //Perform news update
            if (isset($_POST['btnUpdate'])) {

                $conn = dbConnect();
                $newsID = $_SESSION['params']['newsID'];
                $news = new news();
                $news->setNewsID($newsID);
                $news->setTitle($_POST['txtTitle']);
                $news->setUserID($_SESSION['userID']);
                $news->setMainBody($_POST['txtBody']);
                $news->setType($_POST['sltType']);
                $news->setVisibility($_POST['sltVisibility']);

                if ($news->update($conn)) {
                    $_SESSION['update'] = true;
                    $this->redirect("/news/" . $newsID);
                }

            }

            //Perform Delete
            if (isset($_POST['btnDelete'])) {
                $conn = dbConnect();
                $newsID = $_SESSION['params']['newsID'];
                $news = new news();
                $news->setNewsID($newsID);

                if ($news->delete($conn)) {
                    $_SESSION['delete'] = true;
                    $this->redirect("/news");

                } else {
                    $_SESSION['error'] = true;
                }
            }


            $user = new users($news->getUserID());
            $user->getAllDetails($conn);

            $this->data['newsArticle'] = $news;
            $this->data['author'] = $user;

            //Extract data array to display variables on view template
            extract($this->data);
            include('./inc/forms.php');
            require_once('./views/news/edit_news.php');

        } else { //Show login page otherwise
            $this->redirect("/login");
        }
    }

    //News by type, visibility and user


    public function newsByType()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $conn = dbConnect();
        $user = new users();
        $newsArticle = new news();
        $adding = false;


        $typeID = $_SESSION['params']['type'];

        //Check if typeID is valid
        if (!in_array($typeID, range(1, 4))) {
            $this->redirect("/error");
        }

        $newsArticle->setType($typeID);
        $heading = "News | " . $newsArticle->displayType();

        //Security checks - select which news visibility to display
        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if (!$groups->userFullAccess($conn, $_SESSION['userID'])) {

                $description = "All member/public " . $newsArticle->displayType() . " news from Shelterstone";
                $newsList = $newsArticle->getAllNewsByType($conn, 2);

            } else {
                $adding = true;
                $description = "All " . $newsArticle->displayType() . " News from Shelterstone";
                $newsList = $newsArticle->getAllNewsByType($conn);
            }
        } else {
            $description = "All public " . $newsArticle->displayType() . " Shelterstone News";
            $newsList = $newsArticle->getAllNewsByType($conn, 3);
        }


        //Display user data in forms
        $this->data['newsArticle'] = $newsArticle;
        $this->data['newsList'] = $newsList;
        $this->data['author'] = $user;
        $this->data['create'] = $adding;
        $this->date['heading'] = $heading;
        $this->date['description'] = $description;

        //Extract data array to display variables on view template
        extract($this->data);

        require_once('./views/news/news.php');
    }


    public function newsByUser()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $conn = dbConnect();
        $newsArticle = new news();
        $adding = false;

        $userID = $_SESSION['params']['userID'];
        $user = new users($userID);
        $user->getAllDetails($conn);

        //Check if typeID is valid
        //Security and error checks
        if (!$user->doesExist($conn)) {
            $this->redirect("/error");
        }

        $newsArticle->setUserID($userID);
        $heading = "News | " . $user->getFullName();

        //Security checks - select which news visibility to display
        if (isset($_SESSION['userID'])) {
            $groups = new users_groups();
            if (!$groups->userFullAccess($conn, $_SESSION['userID'])) {

                $description = "All member/public news from Shelterstone by: " . $user->getFullName() . " ";
                $newsList = $newsArticle->getAllNewsByUser($conn, 2);

            } else {
                $adding = true;
                $description = "All News from Shelterstone by: " . $user->getFullName();
                $newsList = $newsArticle->getAllNewsByUser($conn);
            }
        } else {
            $description = "All public Shelterstone News by: " . $user->getFullName();
            $newsList = $newsArticle->getAllNewsByUser($conn, 3);
        }


        //Display user data in forms
        $this->data['newsArticle'] = $newsArticle;
        $this->data['newsList'] = $newsList;
        $this->data['author'] = $user;
        $this->data['create'] = $adding;
        $this->date['heading'] = $heading;
        $this->date['description'] = $description;

        //Extract data array to display variables on view template
        extract($this->data);

        require_once('./views/news/news.php');
    }

}