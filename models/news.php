<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:28
 *  News object model class
 *
 */
class news
{
    //Class Variables/Properties

    private $newsID, $userID, $title, $mainBody, $date, $type, $visibility;

    function __construct($newsID = -1)
    {
        $this->newsID = htmlentities($newsID);
    }

    //Getters

    public function getNewsID()
    {
        return $this->newsID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMainBody()
    {
        return $this->mainBody;
    }

    //Get Summary of news item
    public function getSummary()
    {
        $output = substr($this->getMainBody(), 0, 250);
        $output += "...";
        return $output;
    }

    public function getDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->date);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }

    public function getType()
    {
        return $this->type;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    //Setters

    public function setNewsID($newsID)
    {
        $this->newsID = htmlentities($newsID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setTitle($title)
    {
        $this->title = htmlentities($title);
    }

    public function setMainBody($mainBody)
    {
        $this->mainBody = htmlentities($mainBody);
    }

    public function setDate($date)
    {
        $this->date = htmlentities($date);
    }

    public function setType($type)
    {
        $this->type = htmlentities($type);
    }

    public function setVisibility($visibility)
    {
        $this->visibility = htmlentities($visibility);
    }

    //Get all details from news table record
    public function getAllDetails($conn)
    {
        $sql = "SELECT * FROM news WHERE newsID = :newsID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newsID', $this->getNewsID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            // Iterate through the results and set the details
            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                $this->setTitle($row["title"]);
                $this->setMainBody($row["mainBody"]);
                $this->setDate($row["date"]);
                $this->setType($row["type"]);
                $this->setVisibility($row["visibility"]);
            }
            return true;
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
    }

    //Set all details at once from news form

    public function setAllDetails($newsID, $userID, $title, $mainBody, $date, $type, $visibility)
    {
        $this->setNewsID($newsID);
        $this->setUserID($userID);
        $this->setTitle($title);
        $this->setMainBody($mainBody);
        $this->setDate($date);
        $this->setType($type);
        $this->setVisibility($visibility);
    }

    //News manipulation methods

    public function create($conn)
    {
        $sql = "INSERT INTO news (userID, title, mainBody, date, type, visibility) VALUES (:userID, :title, :mainBody, :date, :type, :visibility)";
        $stmt = $conn->prepare($sql);

        //Save current date time to variable for insertion
        $date = date('Y-m-d H:i:s');

        $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
        $stmt->bindParam(':mainBody', $this->getMainBody(), PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $this->getVisibility(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE news SET title = :title, userID = :userID, date = :date, mainBody = :mainBody, type = :type, visibility = :visibility  WHERE newsID = :newsID";

            $stmt = $conn->prepare($sql);

            $date = date('Y-m-d H:i:s');

            $stmt->bindParam(':newsID', $this->getNewsID(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':mainBody', $this->getMainBody(), PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindParam(':visibility', $this->getVisibility(), PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Update failed: " . $e->getMessage();
        }
    }

    public function delete($conn)
    {
        try {
            $sql = "DELETE FROM news WHERE newsID = :newsID";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':newsID', $this->getNewsID(), PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "News Delete failed: " . $e->getMessage();
        }
    }


    //Display news article functions

    public function getAllNews($conn)
    {
        $sql = "SELECT newsID FROM news ORDER BY date DESC";

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database news query failed: " . $e->getMessage();
        }
    }

    public function getAllNewsFiltered($conn, $type = null, $visibility = null, $userID = null)
    {
        $sql = "SELECT newsID FROM news";

        if (!is_null($type)) {
            $sql .= " WHERE type = :type";
        }

        if (!is_null($visibility)) {
            $sql .= " WHERE visibility = :visibility";
        }

        $sql .= " ORDER BY date DESC";

        $stmt = $conn->prepare($sql);

        if (!is_null($type)) {
            $stmt->bindParam(':type', $type, PDO::PARAM_INT);
        }

        if (!is_null($visibility)) {
            $stmt->bindParam(':visibility', $visibility, PDO::PARAM_INT);
        }

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database news query failed: " . $e->getMessage();
        }
    }


    public function getAllNonCommitteeNews($conn)
    {
        $sql = "SELECT newsID FROM news WHERE visibility = 2 OR visibility = 3 ORDER BY date DESC";

        $stmt = $conn->prepare($sql);


        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database public news query failed: " . $e->getMessage();
        }
    }

    public function getAllMemberNews($conn)
    {
        $sql = "SELECT newsID FROM news WHERE visibility = 2 ORDER BY date DESC";

        $stmt = $conn->prepare($sql);


        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database public news query failed: " . $e->getMessage();
        }
    }

    public function getAllPublicNews($conn, $limit= null)
    {
        $sql = "SELECT newsID FROM news WHERE visibility = 3 ORDER BY date DESC";

        $stmt = $conn->prepare($sql);


        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database public news query failed: " . $e->getMessage();
        }
    }

    public function getAllNewsByType($conn, $visibility = null)
    {
        if (is_null($visibility)) {
            $sql = "SELECT newsID FROM news WHERE type = :type ORDER BY date DESC";
        } else {
            $sql = "SELECT newsID FROM news WHERE type = :type AND visibility = :visibility ORDER BY date DESC";
        }

        $stmt = $conn->prepare($sql);
        if (!is_null($visibility)) {
            $stmt->bindParam(':visibility', $visibility, PDO::PARAM_INT);
        }
        $stmt->bindParam(':type', $this->getType(), PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database news by type query failed: " . $e->getMessage();
        }
    }

    public function getAllNewsByUser($conn, $visibility = null)
    {
        if (is_null($visibility)) {
            $sql = "SELECT newsID FROM news WHERE userID= :userID ORDER BY date DESC";
        } else {
            $sql = "SELECT newsID FROM news WHERE userID = :userID AND visibility = :visibility ORDER BY date DESC";
        }

        $stmt = $conn->prepare($sql);
        if (!is_null($visibility)) {
            $stmt->bindParam(':visibility', $visibility, PDO::PARAM_INT);
        }
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database news by user query failed: " . $e->getMessage();
        }
    }


    public function getMostRecent($conn, $limit)
    {
        $sql = "SELECT newsID FROM news ORDER BY Date DESC LIMIT :limit";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database news query failed: " . $e->getMessage();
        }
    }

    public function doesExist($conn)
    {
        $sql = "SELECT newsID FROM news WHERE newsID = :newsID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newsID', $this->getNewsID(), PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Database news exist query failed: " . $e->getMessage();
        }
    }

    //Display functions

    public function displayType()
    {
        switch ($this->getType()) {
            case 1:
                return "Standard";
                break;
            case 2:
                return "Announcements";
                break;
            case 3:
                return "Competitions";
                break;
            case 4:
                return "Events";
                break;
        }
    }

    public function displayVisibility()
    {
        switch ($this->getVisibility()) {
            case 1:
                return "Committee";
                break;
            case 2:
                return "Members";
                break;
            case 3:
                return "Public";
                break;
        }
    }


    //News validation methods

    public function isInputValid($title, $mainBody)
    {
        if ($this->isTitleValid($title) && $this->isMainBodyValid($mainBody)) {
            return true;
        } else {
            return false;
        }
    }

    public function isTitleValid($title)
    {
        if ((strlen($title) > 0) && (strlen($title) <= 250)) {
            return true;
        } else {
            return false;
        }
    }

    public function isMainBodyValid($mainBody)
    {
        if ((strlen($mainBody) > 0) && (strlen($mainBody) <= 5000)) {
            return true;
        } else {
            return false;
        }
    }


}