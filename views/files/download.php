<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 07/08/2017
 * Time: 00:47
 * Download file header script
 */
session_start();

require '../inc/connection.inc.php';
require '../inc/security.inc.php';
require '../obj/files.obj.php';

if (is_null($_GET["id"]) || !is_numeric($_GET["id"])) {
    header('Location:' . $domain . '404.php');
    exit;
} else {

    $conn = dbConnect();

    $files = new files($_GET["id"]);
    $files->getAllDetails($conn);

    //Visibility checks
    if (!isset($_SESSION['username']) && $files->getVisibility() == 0) {
        header('Location:' . $domain . 'login.php');
        exit;
    }


    //File details - Extension and  file name
    $fileLink = $domain . $files->getFilePath();

    $fileExt = $files->getFileDetails(0);
    $fileName = $files->getFileDetails(1);


    //Change script header based on file extension
   switch ($fileExt)
   {
       //Images
       case "jpeg":
           header("Content-type:image/jpeg");
           break;
       case "jpg":
           header("Content-type:image/jpg");
           break;
       case "png":
           header("Content-type:image/png");
           break;
       case "gif":
           header("Content-type:image/gif");
           break;


       //Documents
       case "pdf":
           header("Content-type:application/pdf");
           break;
       case "doc":
           header("Content-type:application/msword");
           break;
       case "docx":
           header("Content-type:application/msword");
           break;

       //Spreadsheets
       case "csv":
           header("Content-type:application/vnd.ms-excel");
           break;
       case "xlsx":
           header("Content-type:application/vnd.ms-excel");
           break;
   }

    header('Content-Description:File Transfer');
    header("Content-Disposition: attachment; filename=" . $fileName . "");
    header("Cache-control: private");
    readfile($fileLink);
}
