<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 14/03/2017
 * Time: 23:08
 *
 * Membership Model/Object class
 */
class memberships
{

    //Properties/Variables
    private $memberShipID, $userID, $type, $paid, $startDate, $endDate;

    //Constructor
    function __construct($memberShipID = -1)
    {
        $this->memberShipID = htmlentities($memberShipID);
    }

    //Getters
    public function getMemberShipID()
    {
        return $this->memberShipID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getPaid()
    {
        return $this->paid;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function displayStartDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->getStartDate());
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }

    public function displayEndDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->getEndDate());
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }


    //Setters
    public function setMemberShipID($memberShipID)
    {
        $this->memberShipID = htmlentities($memberShipID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setType($type)
    {
        $this->type = htmlentities($type);
    }

    public function setPaid($paid)
    {
        $this->paid = htmlentities($paid);
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    //CRUD methods

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from memberships WHERE memberShipID = :memberShipID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':memberShipID', $this->getMemberShipID(), PDO::PARAM_STR);


        //Get membership details from memberships table row
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                $this->setType($row['type']);
                $this->setPaid($row['paid']);
                $this->setStartDate($row['startDate']);
                $this->setEndDate($row['endDate']);
            }

        } catch (PDOException $e) {
            return "Membership get details query Failed:" . $e->getMessage();
        }
    }

    public function create($conn)
    {
        try {
//            //Save current date time to variable for insertion
//            $startDate = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->getStartDate())));
//            $endDate = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $this->getEndDate())));


            //SQL Statement
            $sql = "INSERT INTO memberships VALUES (null, :userID, :type ,:paid, :startDate, :endDate)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindParam(':paid', $this->getPaid(), PDO::PARAM_STR);
            $stmt->bindValue(':startDate', $this->getStartDate(), PDO::PARAM_STR);
            $stmt->bindValue(':endDate', $this->getEndDate(), PDO::PARAM_STR);

            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            dbClose($conn);
            return "Create membership failed:" . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE memberships SET userID = :userID, type = :type, paid = :paid, startDate = :startDate, endDate= :endDate
                    WHERE memberShipID = :memberShipID";


            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':memberShipID', $this->getMemberShipID(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindParam(':paid', $this->getPaid(), PDO::PARAM_STR);
            $stmt->bindValue(':startDate', $this->getStartDate(), PDO::PARAM_STR);
            $stmt->bindValue(':endDate', $this->getEndDate(), PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update membership entry failed: " . $e->getMessage();
        }
    }

    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM memberships";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE memberShipID = :memberShipID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':memberShipID', $this->getMemberShipID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete membership entry failed:" . $e->getMessage();
        }
    }

    public function doesExist($conn)
    {
        $sql = "SELECT memberShipID FROM memberships WHERE memberShipID = :memberShipID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':memberShipID', $this->getMemberShipID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check membership record exists query failed: " . $e->getMessage();
        }
    }

    private function isDateBetweenDates(DateTime $date, DateTime $startDate, DateTime $endDate)
    {
        return $date > $startDate && $date < $endDate;
    }


    public function calculateMemberShipDate()
    {
        //local variables

        //dates based off 2018 calender: http://www.rgu.ac.uk/areas-of-study/academic-calendar/academic-calendar/
        $currentYear = date('o');
        $nextYear = $currentYear + 1;
        $previousYear = $currentYear - 1;
        $now = new DateTime(date("Y-m-d"));

        $semesterOneStart = new DateTime();
        $semesterOneEnd = new DateTime();
        $semesterOneStart->setDate($currentYear, 8, 10);
        $semesterOneEnd->setDate($currentYear, 12, 21);
        $semesterTwoStart = new DateTime();
        $semesterTwoEnd = new DateTime();
        $semesterTwoStart->setDate($nextYear, 1, 28);
        $semesterTwoEnd->setDate($nextYear, 5, 13);


        switch ($this->getType()) {
            case 0:
                if ($this->isDateBetweenDates($semesterOneStart, $semesterOneEnd, $now)) {
                    $this->setStartDate($semesterOneStart->format('Y-m-d'));
                    $this->setEndDate($semesterOneEnd->format('Y-m-d'));
                } else if ($this->isDateBetweenDates($semesterTwoStart, $semesterTwoEnd, $now)) {
                    $this->setStartDate($semesterTwoStart->format('Y-m-d'));
                    $this->setEndDate($semesterTwoEnd->format('Y-m-d'));
                }
                break;

            case 1:
                $this->setStartDate($semesterOneStart->format('Y-m-d'));
                $this->setEndDate($semesterTwoEnd->format('Y-m-d'));
                break;

        }

    }

    //List memberships - ALL or by userID

    public function listAllMemberships($conn, $userID = null)
    {
        $sql = "SELECT * FROM memberships";
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
            return "List all memberships results query failed: " . $e->getMessage();
        }
    }

    //Boolean checkers

    public function hasPaid($conn)
    {
        $sql = "SELECT memberShipID FROM memberships ms WHERE ms.paid = 1  AND ms.memberShipID = :memberShipID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':memberShipID', $this->getMemberShipID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Is user paid membership query failed: " . $e->getMessage();
        }
    }


//Display type of membership based on type flag 0 = one semester, 1 = full membership
    public function displayType()
    {
        switch ($this->getType()) {
            case 0:
                return "One Semester";
                break;

            case 1:
                return "Full Membership";
                break;
        }
    }

    public function listTypes()
    {
        $types = array(
            0 => "One Semester",
            1 => "Full Membership",
        );
        return $types;
    }


    public function displayPaid()
    {
        switch ($this->getType()) {
            case 0:
                return "No";
                break;

            case 1:
                return "Yes";
                break;
        }
    }

    //Input validation

    public function isInputValid($startDate, $endDate)
    {
        if ((strtotime($endDate) > strtotime($startDate))) {
            return true;
        } else {
            return false;
        }
    }


    public function dateInRange($startDate, $endDate)
    {
        $now = new DateTime();
        $startdate = new DateTime($startDate);
        $enddate = new DateTime($endDate);

        if ($startdate <= $now && $now <= $enddate) {
            return true;
        } else {
            return false;
        }

    }


}