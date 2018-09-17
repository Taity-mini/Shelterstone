<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 23:26
 *
 *  404 not found error page
 */

$img = $_SESSION['domain']. "img/404.jpg";

echo "<h1>404: Page not found!</h1>";
echo "<img src= '$img'/>";
echo "Error message";