<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:28
 * File handling object model class
 */

class files
{
    //File class variables / properties

    private $fileID, $userID, $filePath, $title, $description, $visibility;

    //Constructor

    function _constructor($fileID = -1)
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
            }
            return true;
        } catch (PDOException $e) {
            return "Query Get all file details failed: " . $e->getMessage();
        }
    }

    //Delete individual file or all files upload a user
    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM fileID";

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
            unlink($this->getFilePath());
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
    public function listAllFiles($conn, $userID)
    {
        $sql = "SELECT * FROM files";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE fileID = :fileID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':usedID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);
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

    //TODO : Update upload function to create new folders
    public function uploadFile()
    {
        if (isset($_FILES['files'])) {
            $errors = array();
            $file_name = $_FILES['files']['name'];
            $file_size = $_FILES['files']['size'];
            $file_tmp = $_FILES['files']['tmp_name'];
            $file_type = $_FILES['files']['type'];
            $file_ext = strtolower(end(explode('.', $_FILES['files']['name'])));

            $extensions = array("jpeg", "jpg", "png", "gif", "pdf", "doc", "docx", "csv", "xlsx");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a valid file type.";
                return false;
            }

            if ($file_size > 500000000) {
                $errors[] = 'File size must be X MB';
                return false;
            }

            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, "upload/files/" . $file_name);
                $this->setFilePath($file_name);
                echo "Success";
                return true;
            }
        }
    }
}


