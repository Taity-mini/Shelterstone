<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 17:59
 * Database configuration file
 */

ob_start(); //Turn on output buffering for header redirects..

//Database connection variables

$mysqlusername = "root";
$mysqlpassword = "";
$mysqldatabase = "shelterstone";
$host = "localhost";
$domain ="http://shelterstone.test/";

//Database connection and close function using PDO methods

function dbConnect() {
    global $host, $mysqldatabase, $mysqlusername, $mysqlpassword;
    try {
        $conn = new PDO("mysql:host=$host;dbname=$mysqldatabase", $mysqlusername, $mysqlpassword);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $conn;
    } catch (PDOException $e) {
        echo 'Cannot connect to database';
        exit;
    }
}
function dbClose()
{
    $conn = null;
}
