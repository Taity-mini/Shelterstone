<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 01/09/2017
 * Time: 19:56
 * Controller class for the file system pages
 */

class files_controller extends controller
{
    function home()
    {
        require './models/files.php';
        require_once('./models/users.php');

        if (isset($_SESSION['userID'])) {

            $conn = dbConnect();

            $files = new files();
            $users = new users();
            $fileList = $files->listAllFiles($conn);

            $this->data['files'] = $files;
            $this->data['filesList'] = $fileList;
            $this->data['$user'] = $users;
            $this->data['domain'] = $_SESSION['domain'];

            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/files/index.php');

        } else { //Show login page otherwise
            $this->redirect("/login");
        }
    }

    function uploadFile()
    {

        require 'models/files.php';
        require_once('models/users.php');

        if (isset($_SESSION['userID'])) {
            $conn = dbConnect();

            if (isset($_POST['btnSubmit'])) {

                $users = new users($_SESSION['userID']);
                $users->setUserID($_SESSION['userID']);
                $users->getAllDetails($conn);
                var_dump($users);

                $files = new files();

                if (isset($_POST['txtTitle']) && (isset($_POST['txtDescription']))) {

                    $files->setUserID($users->getUserID());
                    $files->setTitle(htmlentities($_POST['txtTitle']));
                    $files->setDescription(htmlentities($_POST['txtDescription']));
                    $files->setVisibility(htmlentities($_POST['chkVisibility']));

                    if (var_dump($files->uploadFile())) {
                        echo "file uploaded";
                        if ($files->create($conn)) {
                            $_SESSION['upload'] = true;
                            if (isset($_SESSION['addFiles'])) {
                                $pageID = $_SESSION['addFiles'];
                                unset($_SESSION['addFiles']);
                                $this->redirect("/pages/edit/" . $pageID);
                            } else {
                                $this->redirect("/files");
                            }
                        }
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            $this->data['domain'] = $_SESSION['domain'];

            //Extract data array to display variables on view template
            extract($this->data);

            require_once('./views/files/upload.php');
        } else { //Show login page otherwise
            $this->redirect("/login");
        }

    }

    function viewFile()
    {
        require 'models/files.php';
        require_once('models/users.php');

        $fileID = $_SESSION['params']['fileID'];

        // Check for a parameter before we send the header
        if (is_null($fileID ) || !is_numeric($fileID)) {
            $this->redirect("/404");
            exit;
        } else {
            $connection = dbConnect();
            $files= new files($fileID);
            $files->getAllDetails($connection);
            if (!$files->doesExist($connection)) {
                $this->redirect("/404");
                exit;
            }

            if (!isset($_SESSION['userID']) && $files->getVisibility()  == 0) {
                $this->redirect("/login");
                exit;
            }

            $this->data['domain'] = $_SESSION['domain'];
            $this->data['$files'] = $files;
            //Extract data array to display variables on view template
            extract($this->data);
            require_once('./views/files/view.php');
        }
    }

    function editFile()
    {
        require 'models/files.php';
        require_once('models/users.php');

        $fileID = $_SESSION['params']['fileID'];

        if (isset($_SESSION['userID'])) {


//            if (!filesFullAccess($connection, $currentUser, $memberValidation)) {
//                header('Location:' . $domain . 'message.php?id=badaccess');
//            }

            $conn = dbConnect();

            $files = new files($fileID);
            $files->getAllDetails($conn);



            if (!$files->doesExist($conn)) {
                $this->redirect("/404");
            }

            $users= new users($_SESSION['userID']);
            $users->setUserID($_SESSION['userID']);
            $users->getAllDetails($conn);


            $this->data['domain'] = $_SESSION['domain'];
            $this->data['$files'] = $files;
            //Extract data array to display variables on view template
            extract($this->data);
            require_once('./views/files/edit.php');


            if (isset($_POST['btnSubmit'])) {
                $files = new files(htmlentities($fileID));
                $files->getAllDetails($conn);
                if (isset($_POST['txtTitle']) && (isset($_POST['txtDescription']))) {

                    $files->setTitle(htmlentities($_POST['txtTitle']));
                    $files->setDescription(htmlentities($_POST['txtDescription']));
                    $files->setVisibility(htmlentities($_POST['chkVisibility']));

                    if ($files->update($conn)) {
                        $_SESSION['update'] = true;
                        $this->redirect("/files");
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            if (isset($_POST['btnDelete'])) {

                $files = new files(htmlentities($fileID));
                $files->getAllDetails($conn);


                //Finally delete album
                if ($files->delete($conn)) {
                    $_SESSION['delete'] = true;
                    $this->redirect("/files");
                } else {
                    $_SESSION['errorDelete'] = true;
                }
            }

        } else {
            $this->redirect("/login");
        }
    }

    function downloadFile()
    {
        require 'models/files.php';
        require_once('models/users.php');

        $fileID = $_SESSION['params']['fileID'];

        // Check for a parameter before we send the header
        if (is_null($fileID ) || !is_numeric($fileID)) {
            $this->redirect("/404");
            exit;
        } else {

            $conn = dbConnect();

            $files = new files($fileID);
            $files->getAllDetails($conn);

            //Visibility checks
            if (!isset($_SESSION['userID']) && $files->getVisibility() == 0) {
                $this->redirect("/login");
                exit;
            }


            //File details - Extension and  file name
            $fileLink = $_SESSION['domain']. $files->getFilePath();

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

    }

}
