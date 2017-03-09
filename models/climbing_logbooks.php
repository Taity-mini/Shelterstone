<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:26
 * Climbing logbook object model class
 *
 */
class climbing_logbooks
{

    //Class variables/properties

    private $logID, $userID, $locationID, $logType, $date, $notes;

    function _constructor($logID = -1)
    {
        $this->logID = htmlentities($logID);
    }

    //Getters

    public function getLogID()
    {
        return $this->logID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getLocationID()
    {
        return $this->locationID;
    }

    public function getLogType()
    {
        return $this->logType;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getNotes()
    {
        return $this->notes;
    }


    //Setters

    public function setLogID($logID)
    {
        $this->logID = htmlentities($logID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setLocationID($locationID)
    {
        $this->locationID = htmlentities($locationID);
    }

    public function setLogType($logtype)
    {
        $this->logType = htmlentities($logtype);
    }

    public function setDate($date)
    {
        $this->date = htmlentities($date);
    }

    public function setNotes($notes)
    {
        $this->notes = htmlentities($notes);
    }


    //CRUD functions

    public function getAllDetails($conn)
    {
        $sql = "SELECT * FROM climbing_logbook WHERE logID = " . $this->getLogID();
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            // Iterate through the results and set the details
            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                $this->setLocationID($row['locationID']);
                $this->setDate($row["date"]);
                $this->setLogType($row["logType"]);
                $this->setNotes($row["notes"]);

            }
            return true;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return "Query failed: " . $e->getMessage();
        }
    }

    public function create($conn)
    {
        $sql = "INSERT INTO climbing_logbook VALUES(:userID, :locationID, :logType, :date, :notes)";
        $stmt = $conn->prepare($sql);

        //Save current date time to variable for insertion
        $date = date('Y-m-d H:i:s');

        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
        $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
        $stmt->bindParam(':logType', $this->getLogType(), PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':logType', $this->getNotes(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create climbing logbook failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE climbing_logbook SET userID = :userID, locationID = :locationID, logType = :logType, date = :date, notes = :notes  
                    WHERE logID = :logID";

            $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->getDate())));
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':logID', $this->getLogID(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_INT);
            $stmt->bindValue(':logType', $this->getLogType(), PDO::PARAM_INT);
            $stmt->bindValue(':date', $date, PDO::PARAM_INT);
            $stmt->bindValue(':notes', $this->getNotes, PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update climbing logbook failed: " . $e->getMessage();
        }
    }


    //Delete individual logbooks or all logbooks submitted by user
    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM climbing_logbook";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE logID = :logID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':logID', $this->getLogID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete climbing logbook failed: " . $e->getMessage();
        }
    }

    public function doesExist($conn)
    {
        $sql = "SELECT logID FROM climbing_logbook WHERE logID = :logID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':logID', $this->getLogID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check logbook exists query failed: " . $e->getMessage();
        }
    }

    //List all logbooks and filter by user or location
    public function listAllLogbooks($conn, $userID = null, $locationID = null)
    {
        $sql = "SELECT * FROM climbing_logbook";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (!is_null($locationID)) {
            $sql .= " WHERE locationID = :locationID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (!is_null($locationID)) {
            $stmt->bindParam(':locationID', $locationID, PDO::PARAM_STR);
        }

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List logbooks query failed: " . $e->getMessage();
        }
    }

//Validation functions

    public function isInputValid($notes)
    {
        if ($this->isNotesValid($notes)) {
            return true;
        } else {
            return false;
        }
    }

    private function isNotesValid($notes)
    {
        if ((strlen($notes) > 0) && (strlen($notes) <= 250)) {
            return true;
        } else {
            return false;
        }
    }

}



