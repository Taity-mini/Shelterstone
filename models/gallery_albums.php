<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:26
 * Gallery album model class
 *
 */

class gallery_album
{
    // Gallery Album Class Variables/properties

    private $albumID, $userID, $albumName, $albumDescription, $created, $modified, $visibility;

    //Constructor
    function _constructor($albumID = -1)
    {
        $this->albumID = htmlentities($albumID);
    }

    //Getters

    public function getAlbumID()
    {
        return $this->albumID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getAlbumName()
    {
        return $this->albumName;
    }

    public function getAlbumDescription()
    {
        return $this->albumDescription;
    }

    public function getCreatedDate()
    {
        return $this->created;
    }

    public function getModifiedDate()
    {
        return $this->modified;
    }


    public function getVisibility()
    {
        return $this->visibility;
    }

    //Setters

    public function setAlbumID($albumID)
    {
        $this->albumID = htmlentities($albumID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setAlbumName($albumName)
    {
        $this->albumName = htmlentities($albumName);
    }

    public function setAlbumDescription($albumDescription)
    {
        $this->albumDescription = htmlentities($albumDescription);
    }

    public function setCreatedDate($created)
    {
        $this->created = htmlentities($created);
    }

    public function setModifiedDate($modified)
    {
        $this->modified = htmlentities($modified);
    }

    public function setVisibility($visibility)
    {
        $this->visibility = htmlentities($visibility);
    }


    //Main Methods

    public function getAllDetails($conn)
    {
        $sql = "SELECT * FROM gallery_albums WHERE albumID = :albumID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setAlbumName($row['albumName']);
                $this->setAlbumDescription($row["albumDescription"]);
                $this->setUserID($row["userID"]);
                $this->setCreatedDate($row['created']);
                $this->setModifiedDate($row['modified']);
                $this->setVisibility($row["visibility"]);
            }
            return true;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    public function getTotalCount($conn)
    {
        $sql = "SELECT COUNT(*) FROM gallery_albums";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute();
            $results = $stmt->fetch();
            $count = $results[0];
            return $count;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }


    public function create($conn)
    {
        try {
            //SQL Statement
            $sql = "INSERT into gallery_albums VALUES (:userID, :albumName, :albumDescription, :created, :modified, :visibility)";
            $date = date('Y-m-d H:i:s');
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':albumName', $this->getAlbumName(), PDO::PARAM_STR);
            $stmt->bindParam(':albumDescription', $this->getAlbumDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':created', $date, PDO::PARAM_STR);
            $stmt->bindParam(':modified', $date, PDO::PARAM_STR);
            $stmt->bindParam(':visibility', $this->getVisibility(), PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            //dbClose($conn);
            return "Create album failed: " . $e->getMessage();
        } catch (Exception $e) {
            //dbClose($conn);
            return "Create album failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        $sql = "UPDATE gallery_albums SET albumName = :albumName, albumDescription = :albumDescription, modified = :modified, visibility = :visibility WHERE albumID = :albumID";
        $stmt = $conn->prepare($sql);
        $date = date('Y-m-d H:i:s');
        $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);
        $stmt->bindParam(':albumName', $this->getAlbumName(), PDO::PARAM_STR);
        $stmt->bindParam(':albumDescription', $this->getAlbumDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':modified', $date, PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $this->getVisibility(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            dbClose($conn);
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update failed: " . $e->getMessage();
        } catch (Exception $e) {
            dbClose($conn);
            return "Update failed: " . $e->getMessage();
        }
    }

    //Delete album for either 1 album or all of user's albums
    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM gallery_albums";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE albumID = :albumID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }

        $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete album failed: " . $e->getMessage();
        }
    }


  //Listing functions



//List all albums in the database and from user from optional parameter
    public function listAllAlbums($conn, $userID = null)
    {
        $sql = "SELECT * FROM gallery_albums a";

        if (!is_null($userID)) {
            $sql .= " WHERE a.userID = :userID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }

    public function listAllAlbumSelect($conn, $userID = null)
    {
        $sql = "SELECT albumID, albumName FROM gallery_albums";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $result) {
                $array[$result["albumID"]] = $result["albumName"];
            }
            return $array;

        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }

    //Get latest albums based on limit parameter
    public function getLatestAlbums($conn, $limit)
    {
        $sql = "SELECT * FROM gallery_albums ORDER BY albumID  DESC LIMIT :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database get latest album query failed: " . $e->getMessage();
        }
    }


    public function doesExist($conn)
    {
        $sql = "SELECT albumID FROM gallery_albums WHERE albumID = :albumID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':albumID', $this->getAlbumID(), PDO::PARAM_STR);
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

}
