<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 14/03/2017
 * Time: 23:05
 * Events object/model class
 */
class events
{
    //Properties/ Variables

    private $eventID, $userID, $locationID, $title, $description, $type, $cost;


    //Constructor

    function _constructor($eventID = -1)
    {
        $this->eventID = htmlentities($eventID);
    }

    //Getters


    public function getEventID()
    {
        return $this->eventID;
    }

    public function getUserID()
    {
        return $this->userID;
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

    public function getType()
    {
        return $this->type;
    }

    public function getCost()
    {
        return $this->cost;
    }

    //Setters

    public function setEventID($eventID)
    {
        $this->eventID = htmlentities($eventID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
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

    public function setType($type)
    {
        $this->type = htmlentities($type);
    }

    public function setCost($cost)
    {
        $this->cost = htmlentities($cost);
    }

    //Get total number of events count
    public function getTotalCount($conn)
    {
        $sql = "SELECT COUNT(*) FROM events";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetch();
            $count = $results[0];
            return $count;
        } catch (PDOException $e) {
            return "Events total count query failed: " . $e->getMessage();
        }
    }


    //CRUD Methods

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from events WHERE eventID = :eventID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventID', $this->getEventID(), PDO::PARAM_STR);


        //Get events details from events table row
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                $this->setLocationID($row['locationID']);
                $this->setTitle($row['title']);
                $this->setDescription($row['description']);
                $this->getType($row['type']);
                $this->getCost($row['cost']);
            }

        } catch (PDOException $e) {
            return "events get details query Failed:" . $e->getMessage();
        }
    }


    public function create($conn)
    {
        try {
            //SQL Statement
            $sql = "INSERT INTO events VALUES (null, :userID, :locationID ,:title, :description, :type, :cost)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->getType(), PDO::PARAM_STR);
            $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindParam(':cost', $this->getCost(), PDO::PARAM_STR);
            return true;

        } catch (PDOException $e) {
            dbClose($conn);
            return "Create membership failed:" . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE events SET userID = :userID, locationID = :locationID, title = :title, description = :description, type = :type, cost = :cost
                    WHERE eventID = :eventID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':eventID', $this->getEventID(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->getType(), PDO::PARAM_STR);
            $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindParam(':cost', $this->getCost(), PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update events entry failed: " . $e->getMessage();
        }
    }

    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM events";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE eventID = :eventID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':eventID', $this->getEventID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete events entry failed:" . $e->getMessage();
        }
    }


    //List events - ALL or by userID

    public function listAllEvents($conn, $userID = null)
    {
        $sql = "SELECT * FROM events";
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
            return "List all events results query failed: " . $e->getMessage();
        }
    }

    //Boolean checker functions

    public function doesExist($conn)
    {
        $sql = "SELECT eventID FROM events WHERE eventID = :eventID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventID', $this->getEventID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check events record exists query failed: " . $e->getMessage();
        }
    }

}