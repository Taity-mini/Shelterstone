<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 08/03/2017
 * Time: 15:13
 *
 * Climbing routes object model class
 */
class climbing_routes
{
    //Class variables/properties

    private $routeID, $logID, $routeName, $routeStyle, $routeGrade, $partnerID;

    //Constructor

    function _constructor($routeID = -1)
    {
        $this->routeID = $routeID;
    }

    //Getters

    public function getRouteID()
    {
        return $this->routeID;
    }

    public function getLogID()
    {
        return $this->logID;
    }

    public function getRouteName()
    {
        return $this->routeName;
    }

    public function getRouteStyle()
    {
        return $this->routeStyle;
    }

    public function getRouteGrade()
    {
        return $this->routeGrade;
    }

    public function getPartnerID()
    {
        return $this->partnerID;
    }

    //Setters

    public function setRouteID($routeID)
    {
        $this->routeID = htmlentities($routeID);
    }

    public function setLogID($logID)
    {
        $this->logID = htmlentities($logID);
    }

    public function setRouteName($routeName)
    {
        $this->routeName = htmlentities($routeName);
    }

    public function setRouteStyle($routeStyle)
    {
        $this->routeStyle = htmlentities($routeStyle);
    }

    public function setRouteGrade($routeGrade)
    {
        $this->routeGrade = htmlentities($routeGrade);
    }

    public function setPartnerID($partnerID)
    {
        $this->partnerID = htmlentities($partnerID);
    }

    //CRUD Methods

    public function getALLDetails($conn)
    {
        $sql = "SELECT * FROM climbing_routes WHERE routeID = " . $this->getRouteID();
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            // Iterate through the results and set the details
            foreach ($results as $row) {
                $this->setLogID($row['logID']);
                $this->setRouteName($row['routeName']);
                $this->setRouteStyle($row["routeStyle"]);
                $this->setRouteGrade($row["routeGrade"]);
                $this->setPartnerID($row["partnerID"]);
            }
            return true;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return "Query failed: " . $e->getMessage();
        }
    }


    public function create($conn)
    {
        $sql = "INSERT INTO climbing_routes VALUES(:logID, :routeName, :routeStyle, :routeGrade, :partnerID)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':logID', $this->getLogID(), PDO::PARAM_STR);
        $stmt->bindParam(':routeName', $this->getRouteName(), PDO::PARAM_STR);
        $stmt->bindParam(':routeStyle', $this->getRouteStyle(), PDO::PARAM_STR);
        $stmt->bindParam(':routeGrade', $this->getRouteGrade(), PDO::PARAM_STR);
        $stmt->bindParam(':partnerID', $this->getPartnerID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create climbing route failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE climbing_routes SET logID = :logID, routeName = :routeName, routeStyle = :routeStyle, routeGrade = :routeGrade, partnerID = :partnerID  
                    WHERE routeID = :routeID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':routeID', $this->getRouteID(), PDO::PARAM_STR);
            $stmt->bindParam(':logID', $this->getLogID(), PDO::PARAM_STR);
            $stmt->bindParam(':routeName', $this->getRouteName(), PDO::PARAM_STR);
            $stmt->bindParam(':routeStyle', $this->getRouteStyle(), PDO::PARAM_STR);
            $stmt->bindParam(':routeGrade', $this->getRouteGrade(), PDO::PARAM_STR);
            $stmt->bindParam(':partnerID', $this->getPartnerID(), PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update climbing route failed: " . $e->getMessage();
        }
    }


    //Delete individual route or all routes from a logbook
    public function delete($conn, $logID = null)
    {
        $sql = "DELETE FROM climbing_routes";

        if (!is_null($logID)) {
            $sql .= " WHERE logID = :logID";
        }

        if (is_null($logID)) {
            $sql .= " WHERE routeID = :routeID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($logID)) {
            $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
        }
        if (is_null($logID)) {
            $stmt->bindParam(':routeID', $this->getRouteID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete climbing route failed: " . $e->getMessage();
        }
    }

    //List all routes or all routes in a logbook
    public function listAllRoutes($conn, $logID = null)
    {
        $sql = "SELECT * FROM climbing_logbook";

        if (!is_null($logID)) {
            $sql .= " WHERE logID = :logID";
        }

        if (is_null($logID)) {
            $sql .= " WHERE routeID = :routeID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($logID)) {
            $stmt->bindParam(':logID', $logID, PDO::PARAM_STR);
        }
        if (is_null($logID)) {
            $stmt->bindParam(':routeID', $this->getRouteID(), PDO::PARAM_STR);
        }

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List routes query failed: " . $e->getMessage();
        }
    }

    public function listTypes()
    {
        $types = array(
            1  => "Boulder",
            2  => "Solo",
            3  => "DWS",
            4  => "Lead",
            5  => "Alt-Lead",
            6  => "Second",
            7  => "Top Rope",
        );
        return $types;
    }

    public function displayType()
    {
        switch ($this->getType()) {
            case 1:
                return "Boulder";
                break;
            case 2:
                return "Solo";
                break;
            case 3:
                return "DWS";
                break;
            case 4:
                return "Lead";
                break;

            case 4:
                return "Alt-Lead";
                break;

            case 5:
                return "Second";
                break;

            case 5:
                return "Top Rope";
                break;
        }
    }

 //Validation functions

    public function isInputValid($name, $style, $grade) {
        if ($this->isNameValid($name) && $this->isStyleValid($style) && $this->isGradeValid($grade)) {
            return true;
        } else {
            return false;
        }
    }

    private function isNameValid($title) {
        if ((strlen($title) > 0) && (strlen($title) <= 100)) {
            return true;
        } else {
            return false;
        }
    }

    private function isStyleValid($subTitle) {
        if (strlen($subTitle) <= 100) {
            return true;
        } else {
            return false;
        }
    }

    private function isGradeValid($subTitle) {
        if (strlen($subTitle) <= 25) {
            return true;
        } else {
            return false;
        }
    }
}
