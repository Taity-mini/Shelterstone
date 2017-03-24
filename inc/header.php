<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 17:59
 * Header include file used in the design layout
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RGU ShelterStone</title>
    <link rel="stylesheet" href="<?php echo $domain ?>/css/foundation.min.css">
    <link rel="stylesheet" href="<?php echo $domain ?>/css/app.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">
    <!--Favicon code START-->

    <!--Favicon code END -->

</head>
<body>
<div class="row column text-center">
    <a href="<?php echo $domain ?>/"><img src="<?php echo $domain ?>/img/ShelterstoneLogo_Small.svg"/></a>
</div>


<!-- Start Top Bar -->
<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="large">
    <button class="menu-icon" type="button" data-toggle></button>
    <div class="title-bar-title">Menu</div>
</div>

<!-- Start Top Bar -->
<div class="top-bar" id="main-menu">
    <div class="top-bar-left">
        <ul class="menu" data-responsive-menu="drilldown large-dropdown">
            <li class="menu-text">RGU: Shelterstone</li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>/">Home</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/news">News</a></li>
                    <li><a href="<?php echo $domain ?>/news/announcements">Announcements</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#">About</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/about/club_information">Club Information</a></li>
                    <li><a href="<?php echo $domain ?>/about/committee">Committee</a></li>
                    <li><a href="<?php echo $domain ?>/about/join_us">Join Us!</a></li>
                    <li><a href="<?php echo $domain ?>/about/history">History</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>/events">Events</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/events">Event List</a></li>
                    <li><a href="<?php echo $domain ?>/events/trips">Trips</a></li>
                    <li><a href="<?php echo $domain ?>/events/competitions">Competitions</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>/gallery">Galleries</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/gallery/events">Events</a></li>
                    <li><a href="<?php echo $domain ?>/gallery/album/personal">Personal Album</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>/profile">Profile</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/climbing_log">Climbing Log</a></li>
                    <li><a href="<?php echo $domain ?>/profile">Personal Details</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="#">Committee</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/committee/member_management">Member Management</a></li>
                    <li><a href="<?php echo $domain ?>/committee/event_management">Event Management</a></li>
                    <li><a href="<?php echo $domain ?>/committee/agenda">Agenda's & Minutes</a></li>
                </ul>
            </li>
            <li class="has-submenu">
                <a href="<?php echo $domain ?>/login">Login</a>
                <ul class="submenu menu vertical" data-submenu>
                    <li><a href="<?php echo $domain ?>/login">Sign in</a></li>
                    <li><a href="<?php echo $domain ?>/register">Register</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="top-bar-right text-center">
        <ul class="menu">
            <li><input width="100%" type="search" placeholder="Search">
            <li>
                <button type="button" class="button">Search</button>
            </li>
        </ul>
    </div>
</div>
<!-- End Top Bar -->
<!-- Main Content-->
<div class="row" id="content">
