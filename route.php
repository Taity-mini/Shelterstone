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
    require_once('controllers/controller.php');
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

        case 'competition':
            $controller = new competition_controller();
            break;

        case 'events':
            $controller = new events_controller();
            break;

        case'committee':
            $controller = new committee_controller();
            break;


        case'files':
            $controller = new files_controller();
            break;
    }

    $controller->{$action}();
}


$rules = array(

//
//main pages
//

//FB Redirect

'fbclid'=> "^(.*)&?fbclid=[^&]+&?(.*)$",


//About us
    'about' => "/about/club_information",
    'committee' => "/about/committee",
    'join_us' => "/about/join_us",
    'history' => "/about/history",

//Events
    'events' => "/events",
    'event_add' => "/events/add",
    'event_view' => "/events/view/(?'eventID'[\w\-]+)",
    'event_edit' => "/events/edit/(?'eventID'[\w\-]+)",
    'trip_events' => "/events/trips",
    'comp_events' => "/events/competitions",

//Competitions
    'competitions' => "/competitions",
    'competition_results' => "/competitions/result/(?'compID'[\w\-]+)",
    'competition_results_edit' => "/competitions/result/edit/(?'compResultsID'[\w\-]+)",
    'competition_edit' => "/competitions/edit/(?'compID'[\w\-]+)",
    'competition_add' => "/competitions/add",

//Galleries
    'gallery' => "/gallery",
    'gallery_events' => "/gallery/events",
    'gallery_comps' => "/gallery/competitions",
    'gallery_add' => "/gallery/add",
    'gallery_upload' => "/gallery/upload",
    'gallery_photo' => "/gallery/photo/(?'photoID'[\w\-]+)",
    'gallery_photo_edit' => "/gallery/photo/edit/(?'photoID'[\w\-]+)",
    'gallery_view' => "/gallery/album/(?'albumID'[\w\-]+)",
    'gallery_edit' => "/gallery/edit/(?'albumID'[\w\-]+)",
    'personal_album' => "/gallery/personal",

//Profile
    'profile' => "/profile",
    'profile_view' => "/profile/view/(?'userID'[\w\-]+)",
    'profile_edit' => "/profile/edit/(?'userID'[\w\-]+)",


//Climbing Log

    //Logbook
    'climbing_log' => "/climbing_log",
    'climbing_logbook' => "/climbing_log/logbook/(?'logID'[\w\-]+)",
    'climbing_logbook_edit' => "/climbing_log/logbook/edit/(?'logID'[\w\-]+)",

    //Locations
    'climbing_log_locations' => "/climbing_log/locations",
    'climbing_log_location_edit' => "/climbing_log/locations/edit/(?'locationID'[\w\-]+)",

    //Routes
    'climbing_log_route' => "/climbing_log/route/(?'routeID'[\w\-]+)",
    'climbing_log_route_edit' => "/climbing_log/route/edit/(?'routeID'[\w\-]+)",

//Committee (Admin Pages)
    'member_management' => "/committee/member_management",
    'event_management' => "/committee/event_management",
    'agenda' => "/committee/agenda",
    'memberships' => "/committee/memberships",
    'editMemberships' => "/committee/memberships/edit/(?'memID'[\w\-]+)",



//News page
    'news' => "/news",
    'announcements' => "/news/announcements",
    'news_add' => "/news/add",
    'news_article' => "/news/(?'newsID'[\w\-]+)",
    'news_edit' => "/news/edit/(?'newsID'[\w\-]+)",
    'news_type' => "/news/type/(?'type'[\w\-]+)",
    'news_user' => "/news/user/(?'userID'[\w\-]+)",

//Search
    'search' => "/search",

//Login and register Pages
    'login' => "/login",
    'logout' => "/logout",
    'register' => "/register",


//Files
    'files' => "/files",
    'uploadFile' => "/files/upload",
    'viewFile' => "/files/view/(?'fileID'[\w\-]+)",
    'editFile' => "/files/edit/(?'fileID'[\w\-]+)",
    'downloadFile' => "/files/download/(?'fileID'[\w\-]+)",

//CMS Page System
    'pages' => "/pages",
    'addPage' => "/pages/add",
    'viewPage' => "/pages/view/(?'pageID'[\w\-]+)",
    'editPage' => "/pages/edit/(?'pageID'[\w\-]+)",
    'deletePage' => "/pages/delete/(?'pageID'[\w\-]+)",

//Freshers
    'freshers' => "/freshers",
    'addFreshers' => "/freshers/add",


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

        //Store URL parameters in session variable for controllers to access
        $_SESSION['params'] = $params;
        //And domain url..
        $_SESSION['domain'] = $domain;

        switch ($action) {

            //Handle FB URL IDs
            case 'fbclid':
                $url = $_SERVER['REQUEST_URI'];
                //Find start fbclid  - question mark
                $pos = strpos($url, '?');
                //Remove from main url
                $finalURL =substr($url, 0,$pos);

                //Store in session
                $_SESSION['finalURL'] = $finalURL;

                //Call controller to redirect accordingly
                call('pages', 'redirectFB');
                break;

            case 'home':
                call('pages', $action);
                break;

            //Standard pages

            case 'login':
                call('pages', $action);
                break;

            case 'logout':
                unset($_SESSION);
                session_destroy();
                header('Location: ' . $domain);
                break;

            case 'register':
                call('pages', $action);
                break;


            case 'profile':
                call('pages', $action);
                break;


            case 'profile_view':
                call('pages', 'viewProfile');
                break;

            case 'profile_edit':
                call('pages', $action);
                break;

            //News
            case 'news':
                call('news', 'index');
                break;

            case 'announcements':
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

            case 'news_type':
                call('news', 'newsByType');
                break;
            case 'news_user':
                call('news', 'newsByUser');
                break;


            //About
            case 'about':
                call('pages', 'club');
                break;

            case 'committee':
                call('pages', $action);
                break;
            case 'join_us':
                call('pages', 'joinUs');
                break;

            case 'history':
                call('pages', 'history');
                break;


            // Events
            case 'events':
                call('events', 'listEvents');
                break;

            case 'event_add':
                call('events', 'addEvent');
                break;

            case 'events_edit':
                call('events', 'editEvent');
                break;

            case 'events_view':
                call('events', 'viewEvent');
                break;

            case 'trip_events':
                call('events', 'tripEvents');
                break;

            case 'comp_events':
                call('events', 'compEvents');
                break;


            //Gallery
            case 'gallery':
                call('gallery', 'home');
                break;

            case 'gallery_events':
                call('gallery', 'events');
                break;

            case 'gallery_comps':
                call('gallery', 'competitions');
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

            //Climbing
            case 'climbing_log':
                call('climbing', 'listLogbooks');
                break;

            case 'climbing_logbook':
                call('climbing', 'logbook');
                break;

            case 'climbing_logbook_edit':
                call('climbing', 'editLogbook');
                break;

            case 'climbing_log_locations':
                call('climbing', 'locations');
                break;

            case 'climbing_log_location_edit':
                call('climbing', 'editLocations');
                break;


            case 'climbing_log_route':
                call('climbing', 'viewRoutes');
                break;

            case 'climbing_log_route_edit':
                call('climbing', 'editRoutes');
                break;

            //Committee

            //Member Management
            case 'member_management':
                call('committee', 'member_management');
                break;


            case 'memberships':
                call('committee', 'memberships');
                break;

            case 'editMemberships':
                call('committee', $action);
                break;

            case 'event_management':
                call('committee', $action);
                break;

            case 'agenda':
                call('committee', $action);
                break;

            //Competitions
            case 'competitions':
                call('competition', $action);
                break;

            case 'competition_results':
                call('competition', $action);
                break;

            case 'competition_add':
                call('competition', $action);
                break;

            case 'competition_edit':
                call('competition', $action);
                break;


             //Files
            case 'files':
                call('files', 'home');
                break;

            case 'uploadFile':
                call('files', $action);
                break;

            case 'viewFile':
                call('files', $action);
                break;

            case 'editFile':
                call('files', $action);
                break;

            case 'downloadFile':
                call('files', $action);
                break;

            //CMS Pages
            case 'pages':
                call('pages', 'pageIndex');
                break;

            case 'addPage':
                call('pages', $action);
                break;

            case 'editPage':
                call('pages', $action);
                break;


            case 'deletePage':
                call('pages', $action);
                break;

            case 'viewPage':
                call('pages', $action);
                break;

            case 'freshers':
                call('pages', $action);
                break;

            case 'addFreshers':
                call('pages', $action);
                break;

            default:
                call('pages', 'error');
                break;
        }
        return;
    }
}
// nothing is found so handle the 404 error
call('pages', 'notFound');


