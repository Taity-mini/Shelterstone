<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 21/06/2017
 * Time: 22:40
 * File handling object model class
 */

class files
{
    //File class variables / properties
    private $fileID, $userID, $filePath, $title, $description, $visibility, $type;

    //Constructor
    function __construct($fileID = -1)
    {
        $this->fileID = $fileID;
    }

    //Getters

    public function getFileID()
    {
        return $this->fileID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function getType()
    {
        return $this->type;
    }


    //Setters

    public function setFileID($fileID)
    {
        $this->fileID = htmlentities($fileID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setFilePath($filePath)
    {
        $this->filePath = ($filePath);
    }

    public function setTitle($title)
    {
        $this->title = htmlentities($title);
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = htmlentities($visibility);
    }

    public function setType($type)
    {
        $this->type = htmlentities($type);
    }


    //CRUD Methods

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from files WHERE fileID = :fileID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setUserID($row["userID"]);
                $this->setFilePath($row['filePath']);
                $this->setTitle($row['title']);
                $this->setDescription($row['description']);
                $this->setVisibility($row['visibility']);
                $this->setType($row['type']);
            }
            return true;
        } catch (PDOException $e) {
            return "Query Get all file details failed: " . $e->getMessage();
        }
    }


    public function create($conn)
    {
        try {
            //SQL Statement
            $sql = "INSERT into files VALUES (NULL,:userID, :filePath, :title , :description, :visibility, :type)";


            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':filePath', $this->getFilePath(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':visibility', $this->getVisibility(), PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);

            $stmt->execute();
            //echo "Statement working";
            return true;
        } catch (PDOException $e) {
            //dbClose($conn);
            return "Create file entry failed: " . $e->getMessage();
        }
    }

    //Delete individual file or all files upload a user
    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM files";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE fileID = :fileID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);
        }

        try {
            unlink('../'.$this->getFilePath());
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "delete file failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE files SET title = :title, description = :description, visibility = :visibility WHERE fileID = :fileID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_INT);
            $stmt->bindValue(':visibility', $this->getVisibility(), PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "update file entry failed: " . $e->getMessage();
        }
    }


    public function doesExist($conn)
    {
        $sql = "SELECT fileID FROM files WHERE fileID = :fileID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check file exists query failed: " . $e->getMessage();
        }
    }

    //List all files or all files upload by user
    public function listAllFiles($conn, $userID = null)
    {
        $sql = "SELECT * FROM files";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }


        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List files query failed: " . $e->getMessage();
        }
    }

    public function renameFile($file)
    {
        $fileName = $file; // can be replaced by the variable in which the file name is being stored
        $fileName_arr = explode(".", $fileName);

        $arrLength = count($fileName_arr);
        $lastEle = $arrLength - 1;
        $fileExt = $fileName_arr[$arrLength - 1]; //Gives the file extension
        unset($fileName_arr[$lastEle]);
        $fileNameMinusExt = implode(".", $fileName_arr);

        $fileNameMinusExt_arr = explode("/", $fileNameMinusExt);
        $arrLength = count($fileNameMinusExt_arr);
        $lastEle = $arrLength - 1;
        $fileName = $fileNameMinusExt_arr[$arrLength - 1]; //Gives the filename


        $fileRename = preg_replace("/[^_a-z0-9]+/i", "_", $fileName);
        $fileRenamed = $fileRename . "." . $fileExt;
        return  $fileRenamed;
    }

    public function getFileDetails($details)
    {
        $fileName = $this->getFilePath(); //$_SERVER['SCRIPT_FILENAME'] can be replaced by the variable in which the file name is being stored
        $fileName_arr = explode(".", $fileName);

        $arrLength = count($fileName_arr);
        $lastEle = $arrLength - 1;
        $fileExt = $fileName_arr[$arrLength - 1]; //Gives the file extension
        unset($fileName_arr[$lastEle]);
        $fileNameMinusExt = implode(".", $fileName_arr);

        $fileNameMinusExt_arr = explode("/", $fileNameMinusExt);
        $arrLength = count($fileNameMinusExt_arr);
        $lastEle = $arrLength - 1;
        $fileName = $fileNameMinusExt_arr[$arrLength - 1]; //Gives the filename

        switch ($details) {
            case 0:
                return $fileExt;
                break;

            case 1:
                $file = $fileName . "." . $fileExt;
                return $file;
                break;
        }
    }


    public function displayVisibility()
    {
        switch ($this->getVisibility()) {
            case 0:
                return "Private";
                break;

            case 1:
                return "Public";
                break;
        }
    }


    public function displayType()
    {
        switch ($this->getType()) {
            case 0:
                return "Image";
                break;

            case 1:
                return "Document";
                break;

            case 2:
                return "Spreadsheet";
                break;

            case 3:
                return "Other";
                break;
        }
    }


    //TODO : Update upload function to create new folders
    public function uploadFile()
    {

        $fileRename = $this->renameFile($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);

        //Set file type
        switch ($imageFileType) {
            //Images
            case "jpeg":
            case "jpg":
            case "png":
            case "gif":
                $this->setType(0);
                // Check if image file is a actual image or fake image
                if (isset($_POST["submit"])) {
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        echo "File is not an image.";
                        $uploadOk = 0;
                    }
                }
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/images/";

                //Change image file name to random sha hash.
                $randString = sha1(uniqid(mt_rand(), true));
                $fileName = $_FILES["fileToUpload"]["name"]; //the original file name
                $splitName = explode(".", $fileName); //split the file name by the dot
                $fileExt = end($splitName); //get the file extension
                $newFileName  = strtolower($randString.'.'.$fileExt); //join file name and ext.

                $target_file = $target_dir . $newFileName;

                $filePath = "uploads/files/images/" . $newFileName;
                break;

            //Documents
            case "pdf":
            case "doc":
            case "docx":
                $this->setType(1);

                $filePath = "uploads/files/docs/" . $fileRename;
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/docs/";
                $target_file = $target_dir . $fileRename;
                break;

            //Spreadsheets
            case "csv":
            case "xlsx":
                $this->setType(2);
                $filePath = "uploads/files/excel/" . $fileRename;
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/excel/";
                $target_file = $target_dir . $fileRename;
                break;

            //Other
            default:
                $this->setType(3);
                $filePath = "uploads/files/other/" . $fileRename;
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/files/other/";
                $target_file = $target_dir . $fileRename;
                break;
        }

        //File checks

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
            return false;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
            return false;
        }


        // Allow certain file formats
        $extensions = array("jpeg", "jpg", "png", "gif", "pdf", "doc", "docx", "csv", "xlsx");
        if (!in_array($imageFileType, $extensions)) {

            echo "Sorry, only JPG, JPEG, PNG,GIF, doc, pdf and excel files are allowed.";
            $uploadOk = 0;
            return false;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return false;
            // if everything is ok, try to uploads file
        } else {

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $this->setFilePath($filePath);
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                return true;
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }

    //Validation functions

    public function isInputValid($title, $description)
    {
        if ($this->isTitleValid($title) && $this->isDescriptionValid($description)) {
            return true;
        } else {
            return false;
        }
    }

    private function isTitleValid($name)
    {
        if ((strlen($name) > 0) && (strlen($name) <= 100)) {
            return true;
        } else {
            return false;
        }
    }

    private function isDescriptionValid($description)
    {
        if (strlen($description) <= 250) {
            return true;
        } else {
            return false;
        }
    }
}