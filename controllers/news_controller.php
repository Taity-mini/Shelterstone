<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait(1504693)
 * Date: 10/03/2017
 * Time: 16:02
 *
 * News pages controller
 */

class news_controller
{
    public function index()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $news = new news();

        require_once ('./views/news/news.php');
    }

    public function article()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $news = new news();

        require_once ('./views/news/news_article.php');
    }


    //Creating and editing

    public function addNews()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $news = new news();

        require_once ('./views/news/create_news.php');
    }

    public function editNews()
    {
        require_once('./models/news.php');
        require_once('./models/users.php');

        $news = new news();

        require_once ('./views/news/edit_news.php');
    }

}