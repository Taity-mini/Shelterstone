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

//    'contactus' => "/contactus",
//    'blog' => "/blog",
//    'blog_article' => "/blog/(?'blogID'[\w\-]+)",

//About us
    'about' => "/about/club_information",
    'committee' => "/about/committee",
    'join_us' => "/about/join_us",

//Events
    'events' => "/events/",
    'event_view' => "/events/view/(?'compID'[\w\-]+)",
    'trip_events' => "/events/trips",
    'comp_events' => "/events/competitions",

    //Competitions
    'competitions' => "/competitions/",
    'competition_results' => "/competitions/result/(?'compID'[\w\-]+)",
    'competition_edit' => "/competitions/edit/(?'compID'[\w\-]+)",
    'competition_add' => "/competitions/add",

//Galleries
    'gallery' => "/gallery",
    'gallery_events' => "/gallery/events",
    'gallery_add' => "/gallery/add",
    'gallery_upload' => "/gallery/upload",
    'gallery_photo' => "/gallery/photo/(?'photoID'[\w\-]+)",
    'gallery_photo_edit' => "/gallery/photo/edit/(?'photoID'[\w\-]+)",
    'gallery_view' => "/gallery/album/(?'albumID'[\w\-]+)",
    'gallery_edit' => "/gallery/edit/(?'albumID'[\w\-]+)",
    'personal_album' => "/gallery/album/personal",

//Profile
    'profile' => "/profile/",
    'profile_view' => "/profile/view/(?'userID'[\w\-]+)",


//Climbing Log
    'climbing_log' => "/climbing_log",
    //Logbook

    'climbing_log_logbook' => "/climbing_log/logbook/(?'logID'[\w\-]+)",
    //Locations
    'climbing_log_locations' => "/climbing_log/locations",
    'climbing_log_location_edit' => "/climbing_log/locations/(?'locationID'[\w\-]+)",

    //Routes
    'climbing_log_route' => "/climbing_log/route/(?'routeID'[\w\-]+)",
    'climbing_log_route_edit' => "/climbing_log/route/edit/(?'routeID'[\w\-]+)",

//Committee (Admin Pages)
    'member_management' => "/committee/member_management",
    'event_management' => "/committee/event_management",
    'agenda' => "/committee/agenda",


//News page
    'news' => "/news",
    'news_add' => "/news/add",
    'news_article' => "/news/(?'newsID'[\w\-]+)",
    'news_edit' => "/news/edit/(?'newsID'[\w\-]+)",

//Search
    'search' => "/search",

//Login and register Pages
    'login' => "/login",
    'logout' => "/logout",
    'register' => "/register",
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

            //News
            case 'news':
                call('news', 'index');
                break;

            case 'news_add':
                call('news', 'addNews');
                break;

            case 'news_edit':
                call('news', 'editNews');
                break;

            case 'news_article':
                call('news', 'article');
                break;


            //About
            case 'about':
                call('about', 'club');
                break;

            case 'committee':
                call('about', $action);
                break;

            case 'join_us':
                call('about', 'joinUs');
                break;

            // Events

            //Gallery
            case 'gallery':
                call('gallery', 'home');
                break;

            case 'gallery_events':
                call('gallery', 'events');
                break;

            case 'gallery_photo':
                call('gallery', 'viewPhoto');
                break;

            case 'gallery_add':
                call('gallery', 'addAlbum');
                break;

            case 'gallery_upload':
                call('gallery', 'addPhoto');
                break;

            case 'gallery_view':
                call('gallery', 'viewAlbum');
                break;

            case 'gallery_edit':
                call('gallery', 'editAlbum');
                break;

            case 'gallery_photo_edit':
                call('gallery', 'editPhoto');
                break;

            case 'personal_album':
                call('gallery', 'personalAlbum');
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