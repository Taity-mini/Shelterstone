<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 19/07/2017
 * Time: 16:02
 * Pages object class
 */
class pages
{

    //Properties

    private $pageID, $userID, $pageTitle, $pageContent, $pageDescription, $createdDate, $modifiedDate, $visibility;

    // ***** CONSTRUCTOR *****
    function __construct($pageID = -1)
    {
        $this->pageID = htmlentities($pageID);
    }

    //Getters

    public function getPageID()
    {
        return $this->pageID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    public function getPageContent()
    {
        return $this->pageContent;
    }

    public function getPageDescription()
    {
        return $this->pageDescription;
    }

    public function getCreatedDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->createdDate);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }

    public function getModifiedDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->modifiedDate);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d/m/Y');
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    //Setters

    public function setPageID($pageID)
    {
        $this->pageID = htmlentities($pageID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = htmlentities($pageTitle);
    }

    public function setPageContent($pageContent)
    {
        $this->pageContent = $pageContent;
    }

    public function setPageDescription($pageDescription)
    {
        $this->pageDescription = htmlentities($pageDescription);
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = htmlentities($createdDate);
    }

    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = htmlentities($modifiedDate);
    }

    public function setVisibility($visibility)
    {
        $this->visibility = htmlentities($visibility);
    }

//    CRUD METHODS

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from pages WHERE pageID = :pageID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pageID', $this->getPageID(), PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setUserID($row["userID"]);
                $this->setPageTitle($row['pageTitle']);
                $this->setPageContent($row['pageContent']);
                $this->setPageDescription($row['pageDescription']);
                $this->setCreatedDate($row['createdDate']);
                $this->setModifiedDate($row['modifiedDate']);
                $this->setVisibility($row['visibility']);
            }
            return true;
        } catch (PDOException $e) {
            return "Query Get all page details failed: " . $e->getMessage();
        }
    }

    //Delete individual file or all files upload a user
    public function delete($conn, $userID = null)
    {
        $sql = "DELETE FROM pages";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (is_null($userID)) {
            $sql .= " WHERE pageID = :pageID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (is_null($userID)) {
            $stmt->bindParam(':pageID', $this->getPageID(), PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "delete page failed: " . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE pages SET pageTitle = :title, pageDescription = :description, pageContent = :content, visibility = :visibility, modifiedDate =  CURDATE() WHERE pageID = :pageID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':pageID', $this->getPageID(), PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->getPageTitle(), PDO::PARAM_STR);
            $stmt->bindParam(':content', $this->getPageContent(), PDO::PARAM_STR);
            $stmt->bindParam(':description', $this->getPageDescription(), PDO::PARAM_INT);
            $stmt->bindValue(':visibility', $this->getVisibility(), PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "update page entry failed: " . $e->getMessage();
        }
    }

    public function create($conn)
    {
        $sql = "INSERT INTO pages (userID, pageTitle, pageContent, pageDescription, createdDate, modifiedDate, visibility) VALUES (:userID, :pageTitle, :pageContent,:pageDescription, CURDATE(),CURDATE(),:visibility)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
        $stmt->bindParam(':pageTitle', $this->getPageTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':pageContent', $this->getPageContent(), PDO::PARAM_STR);
        $stmt->bindParam(':pageDescription', $this->getPageDescription(), PDO::PARAM_STR);
        $stmt->bindParam(':visibility', $this->getVisibility(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $this->setPageID($conn->lastInsertId());
            return true;
        } catch (PDOException $e) {
            return "Create page failed: " . $e->getMessage();
        }
    }

    public function doesExist($conn)
    {
        $sql = "SELECT pageID FROM pages WHERE pageID = :pageID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pageID', $this->getPageID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check page exists query failed: " . $e->getMessage();
        }
    }

    //List all pages or all pages created by user
    public function listAllPages($conn, $userID = null)
    {
        $sql = "SELECT * FROM pages";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }


        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database List pages query failed: " . $e->getMessage();
        }
    }



    public function displayVisibility()
    {
        switch ($this->getVisibility()) {
            case 0:
                return "Private";
                break;

            case 1:
                return "Public";
                break;
        }
    }

    //Validation Functions

    public function isInputValid($title, $subTitle, $mainBody) {
        if ($this->isTitleValid($title) && $this->isSubTitleValid($subTitle) && $this->isMainBodyValid($mainBody)) {
            return true;
        } else {
            return false;
        }
    }

    public function isTitleValid($title) {
        if ((strlen($title) > 0) && (strlen($title) <= 250)) {
            return true;
        } else {
            return false;
        }
    }

    public function isSubTitleValid($subTitle) {
        if (strlen($subTitle) <= 250) {
            return true;
        } else {
            return false;
        }
    }

    public function isMainBodyValid($mainBody) {
        if ((strlen($mainBody) > 0) && (strlen($mainBody) <= 10000)) {
            return true;
        } else {
            return false;
        }
    }

}