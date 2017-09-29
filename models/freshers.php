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
    private  $freshersID, $firstName, $lastName, $email, $studentID, $climbingXP;

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

    //Setters

    public function setFreshersID($freshersID)
    {
        $this->freshersID = htmlentities($freshersID);
    }

    public function setFirstName($firstName)
    {
        $this->firstName = htmlentities($firstName);
    }

    public function  setLastName($lastName)
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
            }
            return true;
        } catch (PDOException $e) {
            return "Query Get all freshers details failed: " . $e->getMessage();
        }
    }


    public function create($conn)
    {
        try {
            //SQL Statement
            $sql = "INSERT into freshers VALUES (NULL,:firstName, :lastName, :email , :studentID, :climbingXP)";


            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':firstName', $this->getFirstName(), PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $this->getLastName(), PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->getEmail(), PDO::PARAM_STR);
            $stmt->bindParam(':studentID', $this->getStudentID(), PDO::PARAM_STR);
            $stmt->bindParam(':climbingXP', $this->getClimbingXP(), PDO::PARAM_STR);

            $stmt->execute();
            //echo "Statement working";
            return true;
        } catch (PDOException $e) {
            //dbClose($conn);
            return "Create fresher entry failed: " . $e->getMessage();
        }
    }

//    //Delete individual file or all files upload a user
//    public function delete($conn, $userID = null)
//    {
//        $sql = "DELETE FROM files";
//
//        if (!is_null($userID)) {
//            $sql .= " WHERE userID = :userID";
//        }
//
//        if (is_null($userID)) {
//            $sql .= " WHERE fileID = :fileID";
//        }
//
//        $stmt = $conn->prepare($sql);
//
//        if (!is_null($userID)) {
//            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
//        }
//        if (is_null($userID)) {
//            $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);
//        }
//
//        try {
//            unlink('../'.$this->getFilePath());
//            $stmt->execute();
//            return true;
//        } catch (PDOException $e) {
//            return "delete file failed: " . $e->getMessage();
//        }
//    }

//    public function update($conn)
//    {
//        try {
//            $sql = "UPDATE files SET title = :title, description = :description, visibility = :visibility WHERE fileID = :fileID";
//
//            $stmt = $conn->prepare($sql);
//
//            $stmt->bindParam(':fileID', $this->getFileID(), PDO::PARAM_STR);
//            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
//            $stmt->bindParam(':description', $this->getDescription(), PDO::PARAM_INT);
//            $stmt->bindValue(':visibility', $this->getVisibility(), PDO::PARAM_INT);
//            $stmt->execute();
//            return true;
//        } catch (PDOException $e) {
//            dbClose($conn);
//            return "update file entry failed: " . $e->getMessage();
//        }
//    }


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
            1  => "Beginner",
            2  => "Intermediate",
            3  => "Experienced",
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




}