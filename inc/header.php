<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 17:59
 * Header include file used in the design layout
 */

//Logged in checks/functions

if (isset($_SESSION['userID'])) {
    //echo "logged in";
    require_once('./models/users.php');
    require_once('./models/users_groups.php');
    $conn = dbConnect();

    $users = new users($_SESSION['userID']);
    $groups = new users_groups();

    $users->getAllDetails($conn);
//    var_dump($users);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RGU ShelterStone</title>
    <link  rel="stylesheet" href="<?php echo $domain ?>css/foundation.min.css">

    <link href="<?php echo $domain ?>css/foundation-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $domain ?>css/app.css">
    <!--Favicon code START-->

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $domain ?>img/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php echo $domain ?>img/ico/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo $domain ?>img/ico/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?php echo $domain ?>img/ico/manifest.json">
    <link rel="mask-icon" href="<?php echo $domain ?>img/ico/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo $domain ?>img/ico/favicon.ico">
    <meta name="msapplication-config" content="<?php echo $domain ?>img/ico/browseQrconfig.xml">
    <meta name="viewport" content="width=device-width,initial-scale=1.0"
    <meta name="theme-color" content="#ffffff">

    <!--Favicon code END -->

    <!--Responsive Tables-->


    <link type="text/css" media="screen" rel="stylesheet" href="<?php echo $domain ?>vendor/responsive_tables/responsive-tables.min.css" />
    <script type="text/javascript" src="<?php echo $domain ?>vendor/responsive_tables/responsive-tables.min.js"></script>



    <script src="<?php echo $domain ?>js/vendor/jquery.min.js"></script>

    <!--highslide js START-->
    <script type="text/javascript" src="<?php echo $domain ?>highslide/highslide-with-gallery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $domain ?>highslide/highslide.min.css"/>


    <!--
        2) Optionally override the settings defined at the top
        of the highslide.js file. The parameter hs.graphicsDir is important!
    -->

    <script type="text/javascript">
        // Remove the ugly Facebook appended hash
        // <https://github.com/jaredhanson/passport-facebook/issues/12>
        (function removeFacebookAppendedHash() {
            if (!window.location.hash || window.location.hash !== '#_=_')
                return;
            if (window.history && window.history.replaceState)
                return window.history.replaceState('', document.title, window.location.pathname + window.location.search);
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop,
                left: document.body.scrollLeft
            };
            window.location.hash = "";
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }());
    </script>

    <script type="text/javascript">
        hs.graphicsDir = '<?php echo $domain ?>highslide/graphics/';
        hs.align = 'center';
        hs.transitions = ['expand', 'crossfade'];
        hs.outlineType = 'rounded-white';
        hs.fadeInOut = true;
        //hs.dimmingOpacity = 0.75;

        // Add the controlbar
        hs.addSlideshow({
            //slideshowGroup: 'group1',
            interval: 5000,
            repeat: false,
            useControls: true,
            fixedControls: 'fit',
            overlayOptions: {
                opacity: .75,
                position: 'bottom center',
                hideOnMouseOut: true
            }
        });
    </script>
    <!--highslide js END-->

    <script src='<?php echo $domain ?>tinymce/tinymce.min.js'></script>
</head>
<body>
<div id="container">
<div class="row column text-center">
    <a href="<?php echo $domain ?>"><img src="<?php echo $domain ?>img/ShelterstoneLogo_Small.svg"/></a>
</div>

<!-- Start Top Bar -->
<div class="title-bar text-center" data-responsive-toggle="main-menu" data-hide-for="large">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<!-- Start Top Bar -->
<div class="top-bar" id="main-menu">
<div class="menu-centered">
        <ul class="menu align-center" data-responsive-menu="drilldown large-dropdown">
            <li class="has-submenu">
                <a href="<?php echo $domain ?>">Home <i class="fi-home"></i></a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>news">News <i class="fi-info"></i></a></li>
                    <li><a href="<?php echo $domain ?>news/announcements">Announcements <i class="fi-megaphone"></i></a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#">About <i class="fi-info"></i></a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>about/club_information">Club Information <i class="fi-info"></i></a></li>
                    <li><a href="<?php echo $domain ?>about/committee">Committee <i class="fi-torsos-all"></i></a></li>
                    <li><a href="<?php echo $domain ?>about/join_us">Join Us! <i class="fi-like"></i></a></li>
                    <li><a href="<?php echo $domain ?>about/history">History <i class="fi-quote"></i></a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>events">Events <i class="fi-mountains"></i></a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>events">Event List <i class="fi-list"></i></a></li>
                    <li><a href="<?php echo $domain ?>events/trips">Trips <i class="fi-compass"></i> </a></li>
                    <li><a href="<?php echo $domain ?>events/competitions">Competitions <i class="fi-trophy"></i></a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>gallery">Galleries <i class="fi-photo"></i></a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>gallery">Gallery List <i class="fi-thumbnails"></i></a></li>
                    <li><a href="<?php echo $domain ?>gallery/events">Events <i class="fi-mountains"></i> </a></li>
                    <li><a href="<?php echo $domain ?>gallery/competitions">Competitions <i class="fi-trophy"></i></a></li>
                    <?php
                    if (isset($_SESSION['userID'])) {
                        echo '<li><a href="' . $domain . 'gallery/personal">Personal Album <i class="fi-camera"></i></a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li class="singleLink"><a href="<?php echo $domain ?>competitions">Competitions <i class="fi-trophy"></i></a></li>
            <?php
            if (isset($_SESSION['userID'])) {
                echo '<li class="has-submenu">
                <a href="' . $domain . 'profile">Profile <i class="fi-torso"></i></a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="' . $domain . 'climbing_log">Climbing Log <i class="fi-book"></i></a></li>
                    <li><a href="' . $domain . 'profile">Personal Details <i class="fi-pencil"></i></a></li>
                </ul>
            </li>';
            }


            if (isset($_SESSION['userID'])) {
                $conn = dbConnect();
                $groups = new users_groups();
                //Committee only!
                if ($groups->isUserCommittee($conn, $_SESSION['userID']) || $groups->isAdministrator($conn, $_SESSION['userID'])) {

                    ?>
                    <li class="has-submenu">
                        <a href="#">Committee <i class="fi-torsos-all"></i></a>
                        <ul class="submenu menu vertical" data-submenu>
                            <li><a href="#">Members <i class="fi-torsos-all"></i></a>
                                <ul class="submenu menu vertical" data-submenu>
                                    <li><a href="<?php echo $domain ?>committee/member_management">Member Management <i class="fi-male-female"></i> </a></li>
                                    <li><a href="<?php echo $domain ?>committee/memberships">Memberships <i class="fi-results-demographics"></i></a></li>
                                    <li><a href="<?php echo $domain ?>freshers">Freshers <i class="fi-torsos-female-male"></i> <i class="fi-plus"></i></a></li>
                                </ul>
                            </li>
                            <li><a href="#">Climbing <i class="fi-climber"></i> </a>
                                <ul class="submenu menu vertical" data-submenu>
                                    <li><a href="<?php echo $domain ?>climbing_log/">Logbooks (ALL) <i class="fi-book"></i></a></li>
                                    <li><a href="<?php echo $domain ?>climbing_log/locations">Locations (ALL) <i class="fi-map"></i></a></li>
                                </ul>
                            </li>
                            <li><a href="#">Pages <i class="fi-page-multiple"></i></a>
                                <ul class="submenu menu vertical" data-submenu>
                                    <li><a href="<?php echo $domain ?>pages/">View all <i class="fi-page-search"></i></a></li>
                                    <li><a href="<?php echo $domain ?>pages/add">Create <i class="fi-page-add"></i></a></li>
                                </ul>
                            </li>
                            <li><a href="#">Files <i class="fi-save"></i></a>
                                <ul class="submenu menu vertical" data-submenu>
                                    <li><a href="<?php echo $domain ?>files/">View all <i class="fi-cloud"></i></a></li>
                                    <li><a href="<?php echo $domain ?>files/upload">Upload <i class="fi-upload-cloud"></i></a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo $domain ?>committee/event_management">Event Management <i class="fi-calendar"></i></a></li>
                            <li><a href="<?php echo $domain ?>committee/agenda">Agenda's & Minutes <i class="fi-clock"></i></a></li>
                        </ul>
                    </li>
                    <?php
                }

            }
            if (isset($_SESSION['userID'])) {
                echo '<li class="singleLink"><a href="' . $domain . 'Logout">Logout <i class="fi-unlock"></i></a></li>';
            } else {

                ?>
                <li class="has-submenu">
                    <a href="<?php echo $domain ?>login">Login <i class="fi-key"></i></a>
                    <ul class="submenu menu vertical" data-submenu>
                        <li><a href="<?php echo $domain ?>login">Sign in <i class="fi-lock"></i></a></li>
                        <li><a href="<?php echo $domain ?>register">Register <i class="fi-plus"></i></a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
<!--    <div class="top-bar-right text-center">-->
<!--        <ul class="menu">-->
<!--            <li><input width="100%" type="search" placeholder="Search">-->
<!--            <li>-->
<!--                <button type="submit" class="button">Search <i class="fi-magnifying-glass"></i></button>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
</div>
<!-- End Top Bar -->
<!-- Main Content-->


<div class="row" id="content">
