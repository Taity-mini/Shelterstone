<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 08/03/2017
 * Time: 15:13
 * Climbing Locations Object model class
 */

class climbing_locations
{
    //Class variables/properties

    private $locationID, $locationName, $locationDescription;

    //Constructor

    function _constructor($locationID = -1)
    {
        $this->locationID  =  htmlentities($locationID);
    }

    //Getters

    public function getLocationID()
    {
        return $this->locationID;
    }

    public function getLocationName()
    {
        return $this->locationName;
    }

    public function getLocationDescription()
    {
        return $this->getLocationDescription();
    }

    //Setters

    public function setLocationID($locationID)
    {
        $this->locationID = htmlentities($locationID);
    }

    public function setLocationName($locationName)
    {
        $this->locationName = htmlentities($locationName);
    }

    public function setLocationDescription($locationDescription)
    {
        $this->locationDescription = htmlentities($locationDescription);
    }

    //CRUD Functions


    public function getAllDetails($conn)
    {
        $sql = "SELECT * FROM climbing_locations WHERE locationID = " . $this->getLocationID();
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            // Iterate through the results and set the details
            foreach ($results as $row) {
                $this->setLocationName($row['locationName']);
                $this->setLocationDescription($row['locationDescription']);
            }
            return true;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return "Query failed: " . $e->getMessage();
        }
    }

    public function create($conn)
    {
        $sql = "INSERT INTO climbing_location VALUES(:locationName, :locationDescription)";
        $stmt = $conn ->prepare($sql);

        $stmt->bindParam(':locationName', $this->getLocationName(), PDO::PARAM_STR);
        $stmt->bindParam(':locationDescription', $this->getLocationName(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create climbing location failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE climbing_locations SET locationName = :locationName, locationDescription = :locationDescription,  
                    WHERE locationID = :locationID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':locationName', $this->getLocationName(), PDO::PARAM_STR);
            $stmt->bindParam(':locationDescription', $this->getLocationName(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update climbing location failed: " . $e->getMessage();
        }
    }

    public function delete($conn)
    {
        $sql = "DELETE FROM climbing_locations";

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete climbing location failed: " . $e->getMessage();
        }
    }


    public function doesExist($conn)
    {
        $sql = "SELECT locationID FROM climbing_locations WHERE locationID = :locationID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check climbing location exists query failed: " . $e->getMessage();
        }
    }

    public function listAllLocations($conn)
    {
        $sql = "SELECT * FROM climbing_locations";

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List locations query failed: " . $e->getMessage();
        }
    }

}