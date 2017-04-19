<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 07/03/2017
 * Time: 18:46
 * Gallery Photo model class
 *
*/

class gallery_photos
{
    //Gallery photos variables/properties
    private $photoID, $userID, $albumID, $filePath, $title, $description, $created, $modified;

    //Constructor
    function __construct($photoID = -1)
    {
        $this->photoID = htmlentities($photoID);
    }

    //Getters

    public function getPhotoID()
    {
        return $this->photoID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getAlbumID()
    {
        return $this->albumID;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function getFullFilePath()
    {
        return $_SESSION['domain'].$this->filePath;
    }

    public function getLocalFilePath()
    {
        return $_SERVER['DOCUMENT_ROOT']. $this->filePath;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }


    public function getCreatedDate()
    {

        //Convert mysql date format to UK format
        $date = new DateTime($this->created);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }

    public function getModifiedDate()
    {
        $date = new DateTime($this->modified);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }



    //Setters


    public function setPhotoID($photoID)
    {
        $this->photoID = htmlentities($photoID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setAlbumID($albumID)
    {
        $this->albumID = htmlentities($albumID);
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function setTitle($title)
    {
        $this->title = htmlentities($title);
    }

    public function setDescription($description)
    {
        $this->description = htmlentities($description);
    }

    public function setCreatedDate($created)
    {
        $this->created = htmlentities($created);
    }

    public function setModifiedDate($modified)
    {
        $this->modified = htmlentities($modified);
    }


    //Main Methods


    public function getAllDetails($conn)
    {
        $sql = "SELECT * FROM gallery_photos WHERE photoID = :photoID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':photoID', $this->getPhotoID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setAlbumID($row['albumID']);
                $this->setUserID($row["userID"]);
                $this->setFilePath($row['filePath']);
                $this->setTitle($row['title']);
                $this->setDescription($row['description']);
                $this->setCreatedDate($row['created']);
                $this->setModifiedDate($row['modified']);
            }
            return true;
        } catch (PDOException $e) {
            return "Query Get all photo details failed: " . $e->getMessage();
        }
    }

    public function getTotalCount($conn)
    {
        $sql = "SELECT COUNT(*) FROM gallery_photos";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute();
            $results = $stmt->fetch();
            $count = $results[0];
            return $count;
        } catch (PDOException $e) {
            return "Database get total photo count query failed: " . $e->getMessage();
        }
    }


    //Gallery Photo CRUD functions

    public function create($conn)
    {
        try {
            //SQL Statement
            $sql = "INSERT into gallery_photos VALUES (NULL,:userID, :albumID,  :filePath, :title , :photoDescription, :created, :modified)";

            //Save current date time to variable for insertion
            $date = date('Y-m-d H:i:s');

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);
            $stmt->bindParam(':filePath', $this->getFilePath(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':photoDescription', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':created', $date, PDO::PARAM_STR);
            $stmt->bindParam(':modified', $date, PDO::PARAM_STR);
            $stmt->execute();
            //echo "Statement working";
            return true;
        } catch (PDOException $e) {
            //dbClose($conn);
            return "Create photo failed: " . $e->getMessage();
        }
    }


    public function delete($conn, $albumID = null)
    {
        $sql = "DELETE FROM gallery_photos";

        if (!is_null($albumID)) {
            $sql .= " WHERE albumID = :albumID";
        }

        if (is_null($albumID)) {
            $sql .= " WHERE photoID = :photoID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($albumID)) {
            $stmt->bindParam(':albumID', $albumID, PDO::PARAM_STR);
        }
        if (is_null($albumID)) {
            $stmt->bindParam(':photoID', $this->getPhotoID(), PDO::PARAM_STR);
        }


        try {
            unlink($this->getLocalFilePath());
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE gallery_photos SET title = :title, description = :description, modified = :modified WHERE photoID = :photoID";

            $date = date('Y-m-d H:i:s');
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':photoID', $this->getPhotoID(), PDO::PARAM_INT);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindValue(':modified', $date, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "update photo failed: " . $e->getMessage();
        }
    }


    public function doesExist($conn)
    {
        $sql = "SELECT photoID FROM gallery_photos WHERE photoID = :photoID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':photoID', $this->getPhotoID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    public function listPhotoAlbum($conn)
    {
        $sql = "SELECT * FROM gallery_photos where albumID = :albumID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List photo album query failed: " . $e->getMessage();
        }
    }

    public function getLatestPhoto($conn)
    {
        $sql = "SELECT filePath FROM gallery_photos WHERE albumID= :albumID ORDER BY photoID  DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                foreach ($results as $row) {
                    $this->setFilePath($row['filePath']);
                }
                return true;
            } else {
                $this->setFilePath('/img/placeholder.jpg');
                return false;
            }
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }

    public function getLatestPhotos($conn, $limit)
    {
        $sql = "SELECT * FROM gallery_photos ORDER BY photoID  DESC LIMIT :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database get latest photos query failed: " . $e->getMessage();
        }
    }

    //Searching Functions
    public function search($conn, $field, $query)
    {
        try {
            $field = "`" . str_replace("`", "``", $field) . "`";
            $sql = "SELECT * FROM `gallery_photos` WHERE $field LIKE :query";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':query', $query, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (isset($results)) {
                return $results;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return "Search photos Query failed: " . $e->getMessage();
        }
    }

    //TODO: Upload photos - update to create folder structure


    public function uploadPhoto()
    {
        $target_dir = $_SERVER['DOCUMENT_ROOT']."/uploads/photos/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        $filePath = "/uploads/photos/" . basename($_FILES["fileToUpload"]["name"]) ;

        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
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
        if ($imageFileType != "jpg" && $imageFileType != "JPG"  && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            return false;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            return false;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $this->setFilePath($filePath);
                return true;

                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }


    //Validation functions
    public function isInputValid($name, $description)
    {
        if ($this->isNameValid($name) && $this->isDescriptionValid($description)) {
            return true;
        } else {
            return false;
        }
    }

    private function isNameValid($name)
    {
        if ((strlen($name) > 0) && (strlen($name) <= 50)) {
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