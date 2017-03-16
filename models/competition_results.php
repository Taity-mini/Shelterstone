<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 15/03/2017
 * Time: 01:45
 * Competition results object/model class
 */
class competition_results
{

    //Properties / Variables for competition results table

    private $compResultsID, $compID, $userID, $category, $position, $totalScore;


    function _constructor($compResultsID = -1)
    {
        $this->compResultsID = $compResultsID;
    }


    //Getters

    public function getCompResultsID()
    {
        return $this->compResultsID;
    }

    public function getCompID()
    {
        return $this->compID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getTotalScore()
    {
        return $this->totalScore;
    }


    //Setters

    public function setCompResultsID($compResultsID)
    {
        $this->compResultsID = htmlentities($compResultsID);
    }

    public function setCompID($compID)
    {
        $this->compID = htmlentities($compID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setCategory($category)
    {
        $this->category = htmlentities($category);
    }

    public function setPosition($position)
    {
        $this->position = htmlentities($position);
    }

    public function setTotalScore($totalScore)
    {
        $this->$totalScore = htmlentities($totalScore);
    }

    //CRUD Functions


    public function getAllDetails($conn)
    {
        $sql = "SELECT * from competitions_results WHERE compResultsID = :compResultsID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':compResultsID', $this->getCompResultsID(), PDO::PARAM_STR);


        //Get user's details from users table row
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setCompID($row['compID']);
                $this->setUserID($row['userID']);
                $this->setCategory($row['category']);
                $this->setPosition($row['position']);
                $this->setTotalScore($row['totalScore']);
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
            $sql = "INSERT INTO competitions_results VALUES (null, :compID, :userID, :category, :position, :totalScore)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':compID', $this->getCompID(), PDO::PARAM_STR);
            $stmt->bindParam(':category', $this->getCategory(), PDO::PARAM_STR);
            $stmt->bindParam(':position', $this->getPosition(), PDO::PARAM_STR);
            $stmt->bindParam(':totalScore', $this->getTotalScore(), PDO::PARAM_STR);
            return true;

        } catch (PDOException $e) {
            dbClose($conn);
            return "Create competition results entry failed:" . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE competitions_results SET userID = :userID, compID = :compID, category = :category, position = :position, totalScore= :totalScore
                    WHERE compResultsID = :compResultsID";


            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':compResultsID', $this->getCompResultsID(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':compID', $this->getCompID(), PDO::PARAM_STR);
            $stmt->bindParam(':category', $this->getCategory(), PDO::PARAM_STR);
            $stmt->bindParam(':position', $this->getPosition(), PDO::PARAM_STR);
            $stmt->bindParam(':totalScore', $this->getTotalScore(), PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update competition results entry failed: " . $e->getMessage();
        }
    }

    public function delete($conn, $userID, $compID)
    {
        $sql = "DELETE FROM competitions_results";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (!is_null($compID)) {
            $sql .= " WHERE compID = :compID";
        }

        if (is_null($userID) && is_null($compID)) {
            $sql .= " WHERE compResultsID = :compResultsID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID) && is_null($compID)) {
            $stmt->bindParam(':compResultsID', $this->getCompResultsID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Delete competition results entry failed:" . $e->getMessage();
        }
    }


    public function listAllCompResults($conn, $userID = null)
    {
        $sql = "SELECT * FROM competitions_results cr";
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
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "List all competition results query failed: " . $e->getMessage();
        }
    }


}