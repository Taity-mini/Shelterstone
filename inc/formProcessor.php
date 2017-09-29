<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 28/09/2017
 * Time: 20:57
 * Script to process AJAX requests for various form functions
 */
session_start();
require_once('../inc/config.php');
require_once('../models/users.php');
require_once('../models/users_groups.php');

//Security Checks

if (isset($_SESSION['userID'])) {

    $conn = dbConnect();

    $users = new users();
    $groups = new users_groups();

    //$currentUser = $users->setUserID($_SESSION['userID']);

    //committee or admin check
    if ($groups->isUserCommittee($conn, $_SESSION['userID']) || $groups->isAdministrator($conn, $_SESSION['userID'])) {
    //Approve User
        if (isset($_POST['approve'])) {
            $conn = dbConnect();

            $userID = $_POST['userID'];
            $conn = dbConnect();
            //Get data from fields
            $users = new Users(htmlentities($userID));

            //Approve user in the database
            if ($users->approveToggleUser($conn, $users->getUserID())) {
                $_SESSION['approve'] = true;
                return true;
            } else {
                $_SESSION['approve'] = true;
                return false;
            }
        }


//Accredit User

        if (isset($_POST['accreditUser'])) {
            $conn = dbConnect();

            $userID =  $_POST['userID'];
            //Get data from fields
            $users = new Users(htmlentities($userID));

            //Ban user in the database
            if ($users->accreditToggleUser($conn, $users->getUserID())) {
                $_SESSION['accredit'] = true;
                return true;
            } else {
                $_SESSION['accreditError'] = true;
                return false;
                exit;
            }
        }


//Ban User

        if (isset($_POST['banUser'])) {
            $conn = dbConnect();

            $userID =  $_POST['userID'];
            //Get data from fields
            $users = new Users(htmlentities($userID));

            //Ban user in the database
            if ($users->banningToggleUser($conn, $users->getUserID())) {
                $_SESSION['ban'] = true;
                return true;
            } else {
                $_SESSION['banError'] = true;
                return false;
                exit;
            }
        }
    }
} else {
    return false;
    exit;
}

