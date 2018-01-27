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
    <link rel="stylesheet" href="<?php echo $domain ?>css/foundation.min.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $domain ?>css/app.css">
    <!--Favicon code START-->

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $domain ?>img/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?php echo $domain ?>img/ico/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo $domain ?>img/ico/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?php echo $domain ?>img/ico/manifest.json">
    <link rel="mask-icon" href="<?php echo $domain ?>img/ico/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo $domain ?>img/ico/favicon.ico">
    <meta name="msapplication-config" content="<?php echo $domain ?>img/ico/browseQrconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!--Favicon code END -->

    <script src="<?php echo $domain ?>js/vendor/jquery.js"></script>

    <!--highslide js START-->
    <script type="text/javascript" src="<?php echo $domain ?>highslide/highslide-with-gallery.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $domain ?>highslide/highslide.css"/>

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
<div class="row column text-center">
    <a href="<?php echo $domain ?>"><img src="<?php echo $domain ?>img/ShelterstoneLogo_Small.svg"/></a>
</div>


<!-- Start Top Bar -->
<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="large">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<!-- Start Top Bar -->
<div class="top-bar" id="main-menu">
    <div class="top-bar-left">
        <ul class="menu text-center" data-responsive-menu="drilldown large-dropdown">
            <li class="menu-text">RGU: Shelterstone</li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>">Home</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>news">News</a></li>
                    <li><a href="<?php echo $domain ?>news/announcements">Announcements</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#">About</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>about/club_information">Club Information</a></li>
                    <li><a href="<?php echo $domain ?>about/committee">Committee</a></li>
                    <li><a href="<?php echo $domain ?>about/join_us">Join Us!</a></li>
                    <li><a href="<?php echo $domain ?>about/history">History</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>events">Events</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>events">Event List</a></li>
                    <li><a href="<?php echo $domain ?>events/trips">Trips</a></li>
                    <li><a href="<?php echo $domain ?>events/competitions">Competitions</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>gallery">Galleries</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>gallery">Gallery List</a></li>
                    <li><a href="<?php echo $domain ?>gallery/events">Events</a></li>
                    <li><a href="<?php echo $domain ?>gallery/competitions">Competitions</a></li>
                    <?php
                    if (isset($_SESSION['userID'])) {
                        echo '<li><a href="' . $domain . 'gallery/personal">Personal Album</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <li class="singleLink"><a href="<?php echo $domain ?>competitions">Competitions</a></li>
            <?php
            if (isset($_SESSION['userID'])) {
                echo '<li class="has-submenu">
                <a href="' . $domain . 'profile">Profile</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="' . $domain . 'climbing_log">Climbing Log</a></li>
                    <li><a href="' . $domain . 'profile">Personal Details</a></li>
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
                        <a href="#">Committee</a>
                        <ul class="submenu menu vertical" data-submenu>
                            <li><a href="#">Members</a>
                                <ul class="submenu menu vertical" data-submenu>
                                    <li><a href="<?php echo $domain ?>committee/member_management">Member Management</a></li>
                                    <li><a href="<?php echo $domain ?>committee/memberships">Memberships</a></li>
                                    <li><a href="<?php echo $domain ?>freshers">Freshers</a></li>
                                </ul>
                            </li>
                            <li><a href="<?php echo $domain ?>committee/event_management">Event Management</a></li>
                            <li><a href="<?php echo $domain ?>committee/agenda">Agenda's & Minutes</a></li>
                        </ul>
                    </li>
                    <?php
                }

            }
            if (isset($_SESSION['userID'])) {
                echo '<li class="singleLink"><a href="' . $domain . 'Logout">Logout</a></li>';
            } else {

                ?>
                <li class="has-submenu">
                    <a href="<?php echo $domain ?>login">Login</a>
                    <ul class="submenu menu vertical" data-submenu>
                        <li><a href="<?php echo $domain ?>login">Sign in</a></li>
                        <li><a href="<?php echo $domain ?>register">Register</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <div class="top-bar-right text-center">
        <ul class="menu">
            <li><input width="100%" type="search" placeholder="Search">
            <li>
                <button type="submit" class="button">Search</button>
            </li>
        </ul>
    </div>
</div>
<!-- End Top Bar -->
<!-- Main Content-->
<div class="row" id="content">
