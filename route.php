<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 15:11
 * Routing file for URLS in MVC system
 */

define('INCLUDE_DIR', dirname(__FILE__) . '/controllers/');

function call($controller, $action)
{
    require_once('controllers/' . $controller . '_controller.php');

    switch ($controller) {
        case 'pages':
            $controller = new pages_controller();
            break;
        case 'news':
            // we need the model to query the database later in the controller
            //require_once('models/post.php');
            $controller = new news_controller();
            break;
    }

    $controller->{$action}();
}


$rules = array(
//
//main pages
//
    'about' => "/about",
    'contactus' => "/contactus",
    'blog' => "/blog",
    'blog_article' => "/blog/(?'blogID'[\w\-]+)",
//
//News page
    'news' => "/news",
    'news_article' => "/news/(?'newsID'[\w\-]+)",


//Admin Pages
//
    'login' => "/login",
    'create_article' => "/createarticle",
    'logout' => "/logout",
//
// Home Page
//
    'home' => "/"
);
$uri = rtrim(dirname($_SERVER["SCRIPT_NAME"]), '/');
$uri = '/' . trim(str_replace($uri, '', $_SERVER['REQUEST_URI']), '/');
$uri = urldecode($uri);

// we're adding an entry for the new controller and its actions
$controllers = array('pages' => ['home', 'error'], 'news' => ['news', 'show']);


foreach ($rules as $action => $rule) {
    if (preg_match('~^' . $rule . '$~i', $uri, $params)) {


        switch ($action) {
            case 'home':
                call('pages', $action);
                break;

            case 'news':
                call('news', 'index');
                break;

            default:
                call('pages', 'error');
                break;
        }

//        foreach ($controllers as $controller => $actions) {
//
//        }
//
//        if (array_key_exists($controller, $controllers)) {
//            if (in_array($action, $controllers[$controller])) {
//                call($controller, $action);
//            } else {
//                call('pages', 'error');
//            }
//        } else {
//            call('pages', 'error');
//        }


//        foreach ($controllers as $key => $value)
//        {
//            echo $key . ':' . $value . "\n";
//        }

//        if ($key !== false) {
//            if (in_array($action, $controllers[$key])) {
//                call($key, $action);
//            } else {
//                echo "failed";
//                call('pages', 'error');
//            }
//        } else {
//            call('pages', 'error');
//        }

        //include(INCLUDE_DIR . $action . '.php');

        exit();
    }
}
// nothing is found so handle the 404 error
include(INCLUDE_DIR . '404.php');