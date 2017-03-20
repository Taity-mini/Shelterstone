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
        require_once ('./views/pages/home.php');
    }

    public function search()
    {
        require_once ('./views/pages/search.php');
    }

    //PROFILE PAGES

    //Profile for current user
    public function profile()
    {
        require_once ('./views/pages/profile.php');
    }


    //View other user's profile
    public function viewProfile()
    {
        require_once ('./views/pages/profile.php');
    }

    //Edit other user's profile
    public function profile_edit()
    {
        require_once ('./views/pages/profile_edit.php');
    }

    //ABOUT US PAGES

    //Club
    public function club()
    {
        require_once ('./views/pages/club.php');
    }

    public function committee()
    {
        require_once ('./views/pages/committee.php');
    }

    public function joinUs()
    {
        require_once ('./views/pages/join_us.php');
    }


    //Login and registration
    public function login()
    {
        require_once ('./models/users.php');
        require_once ('./models/users_groups.php');
        require_once ('./views/pages/login.php');
    }

    public function register()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./views/pages/register.php');
    }


    //Error pages
    public function error()
    {
        require_once ('views/pages/error.php');
    }

    public function notFound()
    {
        require_once ('views/pages/404.php');
    }
}
