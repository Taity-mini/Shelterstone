<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 07/03/2017
 * Time: 18:46
 * Gallery Photo model class
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
        return $this->created;
    }

    public function getModifiedDate()
    {
        return $this->modified;
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
            $sql = "INSERT into gallery_photos VALUES (:userID, :albumID,  :filePath, :title , :photoDescription, :created, :modified)";

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
            unlink($this->getFilePath());
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE photos SET title = :title, description = :description, modified = :modified WHERE photoID = :photoID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':photoID', $this->getPhotoID(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_INT);
            $stmt->bindValue(':modified', $this->getModifiedDate(), PDO::PARAM_INT);

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
                $this->setFilePath('../images/placeholder.jpg');
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


}