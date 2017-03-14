<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 15:11
 * Routing file for URLS in MVC system
 */

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

        case 'gallery':
            $controller = new gallery_controller();
            break;

        case 'climbing':
            $controller = new climbing_controller();
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
        exit();
    }
}
// nothing is found so handle the 404 error
call('pages', 'notFound');