<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 14/03/2017
 * Time: 23:25
 *
 * Competitions model/object class for the competition and results table
 */
class competitions
{
    //Private variables/Properties

    private $compID, $authorID, $locationID, $title, $description, $date, $modified;

    function _constructor($compID = -1)
    {
        $this->compID = htmlentities($compID);
    }

    //Getters

    //Competition information
    public function getCompID()
    {
        return $this->compID;
    }

    public function getAuthorID()
    {
        return $this->authorID;
    }

    public function getLocationID()
    {
        return $this->locationID;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getModifiedDate()
    {
        return $this->modified;
    }

    //Setters

    public function setCompID($compID)
    {
        $this->compID = htmlentities($compID);
    }

    public function setAuthorID($authorID)
    {
        $this->authorID = htmlentities($authorID);
    }

    public function setLocationID($locationID)
    {
        $this->locationID = htmlentities($locationID);
    }

    public function setTitle($title)
    {
        $this->title = htmlentities($title);
    }

    public function setDescription($description)
    {
        $this->description = htmlentities($description);
    }

    public function setDate($date)
    {
        $this->date = htmlentities($date);
    }

    public function setModified($modified)
    {
        $this->modified = htmlentities($modified);
    }


    //CRUD Methods

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from competitions WHERE compID = :compID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':compID', $this->getCompID(), PDO::PARAM_STR);


        //Get comp details from competitions table row
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setAuthorID($row['userID']);
                $this->setLocationID($row['locationID']);
                $this->setTitle($row['title']);
                $this->setDescription($row['description']);
                $this->setDate($row['date']);
                $this->setModified($row['modified']);
            }

        } catch (PDOException $e) {
            return "Query Failed:" . $e->getMessage();
        }
    }

    public function create($conn)
    {
        try {
            //Save current date time to variable for insertion
            $date = date('Y-m-d H:i:s');

            //SQL Statement
            $sql = "INSERT INTO competitions VALUES (null, :userID, :locationID ,:title, :description, :date, :modified)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getAuthorID(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':modified', $date, PDO::PARAM_STR);
            return true;

        } catch (PDOException $e) {
            dbClose($conn);
            return "Create competition failed:" . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE competitions SET userID = :userID, title = :title, description = :description, date = :date, modified= :modified
                    WHERE compID = :compID";

            $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->getDate())));
            $modified = date('Y-m-d H:i:s');
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':compID', $this->getCompID(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->bindValue(':modified', $modified, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update competition entry failed: " . $e->getMessage();
        }
    }

    public function delete($conn, $userID)
    {
        $sql = "DELETE FROM competitions";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE compID = :compID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':compID', $this->getCompID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete competition entry failed:" . $e->getMessage();
        }
    }


    public function getTotalCount($conn)
    {
        $sql = "SELECT COUNT(*) FROM competitions";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetch();
            $count = $results[0];
            return $count;
        } catch (PDOException $e) {
            return "Database count comps query failed: " . $e->getMessage();
        }
    }


    public function listAllComps($conn, $userID = null)
    {
        $sql = "SELECT * FROM competitions c";
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
            return $results;
        } catch (PDOException $e) {
            return "List all competitions query failed: " . $e->getMessage();
        }
    }


    //Input validation functions

    public function isInputValid($title, $description)
    {
        if ($this->isTitleValid($title) && $this->isDescriptionValid($description)) {
            return true;
        } else {
            return false;
        }
    }

    public function isTitleValid($title)
    {
        if ((strlen($title) > 0) && (strlen($title) <= 200)) {
            return true;
        } else {
            return false;
        }
    }

    public function isDescriptionValid($description)
    {
        if (count($description <= 300)) {
            return true;
        } else {
            return false;
        }
    }

}