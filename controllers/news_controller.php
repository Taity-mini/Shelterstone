<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 10/03/2017
 * Time: 16:02
 */

class news_controller
{
    public function index()
    {
        require_once('./models/news.php');

        require_once('./models/users.php');
    }

}