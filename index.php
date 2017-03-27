<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait
 * Sheleterstone Honour's Project
 * Date: 04/03/2017
 * Time: 17:24
 */

//Setup Database connection files
session_start();
require_once('/inc/config.php');

if (isset($_SESSION['userID'])) {
    echo "logged in";
}


require_once ('views/layout.php');

