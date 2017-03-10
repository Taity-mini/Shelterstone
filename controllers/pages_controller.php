<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 10/03/2017
 * Time: 15:53
 * Page Controller class
 */

class pages_controller
{

    //Standard pages
    public function home()
    {
        require_once ('./views/pages/home.php');
    }

    public function error()
    {
        require_once ('views/pages/error.php');
    }
}
