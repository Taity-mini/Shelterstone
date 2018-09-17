<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 18/09/2017
 * Time: 22:31
 * Freshers sign up model class
 */

class freshers
{
    private $freshersID, $firstName, $lastName, $email, $studentID, $climbingXP, $GDPRConsent, $GDPRDate;

    function __construct($freshersID = -1)
    {
        $this->freshersID = $freshersID;
    }

    //Getters

    public function getFreshersID()
    {
        return $this->freshersID;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getStudentID()
    {
        return $this->studentID;
    }

    public function getClimbingXP()
    {
        return $this->climbingXP;
    }

    public function getGDPRConsent()
    {
        return $this->GDPRConsent;
    }


    public function getGDPRDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->GDPRDate);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d-m-Y');
    }


    //Setters

    public function setFreshersID($freshersID)
    {
        $this->freshersID = htmlentities($freshersID);
    }

    public function setFirstName($firstName)
    {
        $this->firstName = htmlentities($firstName);
    }

    public function setLastName($lastName)
    {
        $this->lastName = htmlentities($lastName);
    }

    public function setEmail($email)
    {
        $this->email = htmlentities($email);
    }

    public function setStudentID($studentID)
    {
        $this->studentID = htmlentities($studentID);
    }

    public function setClimbingXP($climbingXP)
    {
        $this->climbingXP = htmlentities($climbingXP);
    }


    public function setGDPRConsent($GDPRConsent)
    {
        $this->GDPRConsent = $GDPRConsent;
    }


    public function setGDPRDate($GDPRDate)
    {
        $this->GDPRDate = $GDPRDate;
    }


    public function getAllDetails($conn)
    {
        $sql = "SELECT * from freshers WHERE freshersID = :freshersID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':freshersID', $this->getFreshersID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setFirstName($row['firstName']);
                $this->setLastName($row['lastName']);
                $this->setEmail($row['email']);
                $this->setStudentID($row['studentID']);
                $this->setClimbingXP($row['climbingXP']);
                $this->setGDPRConsent($row['GDPRConsent']);
                $this->setGDPRDate($row['GDPRDate']);
            }
            return true;
        } catch (PDOException $e) {
            return "Query Get all freshers details failed: " . $e->getMessage();
        }
    }


    public function create($conn)
    {
        try {
            //GDPR consent check
            if ($this->getGDPRConsent() != NULL) {
                $date = date('Y-m-d H:i:s');
            } else {
                $date = NULL;
            }

            //SQL Statement
            $sql = "INSERT into freshers VALUES (NULL,:firstName, :lastName, :email , :studentID, :climbingXP, :GDPRConsent, :GDPRDate)";


            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':firstName', $this->getFirstName(), PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $this->getLastName(), PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->getEmail(), PDO::PARAM_STR);
            $stmt->bindParam(':studentID', $this->getStudentID(), PDO::PARAM_STR);
            $stmt->bindParam(':climbingXP', $this->getClimbingXP(), PDO::PARAM_STR);
            $stmt->bindParam(':GDPRConsent', $this->getGDPRConsent(), PDO::PARAM_INT);
            $stmt->bindParam(':GDPRDate', $date, PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return "Create fresher entry failed: " . $e->getMessage();
        }
    }


    public function doesExist($conn)
    {
        $sql = "SELECT freshersID FROM freshers WHERE freshersID = :freshersID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':freshersID', $this->getFreshersID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check freshers exists query failed: " . $e->getMessage();
        }
    }

    //List all freshers
    public function listAllFreshers($conn)
    {
        $sql = "SELECT * FROM freshers";


        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List freshers query failed: " . $e->getMessage();
        }
    }


    public function listClimbingLevels()
    {
        $levels = array(
            1 => "Beginner",
            2 => "Intermediate",
            3 => "Experienced",
        );
        return $levels;
    }

    public function displayLevel()
    {
        switch ($this->getClimbingXP()) {

            case 1:
                return "Beginner";
                break;

            case 2:
                return "Intermediate";
                break;

            case 3:
                return "Experienced";
                break;
        }
    }

    public function displayMailingList()
    {
        switch ($this->getGDPRConsent()) {

            case 0:
                return "No";
                break;

            case 1:
                return "Yes";
                break;
        }
    }


}