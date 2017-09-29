<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:28
 * User groups class
 */
class users_groups
{

    //Class variables for group and user group fields

    private $groupID, $groupName, $groupDescription, $userID;

    //Constructor
    function __construct($userID = "zzz", $groupID = -1)
    {
        $this->userID = htmlentities($userID);
        $this->groupID = htmlentities($groupID);
    }

    //Getters

    public function getGroupID()
    {
        return $this->groupID;
    }

    public function getGroupName()
    {
        return $this->groupName;
    }

    public function getGroupDescription()
    {
        return $this->groupDescription;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    //Setters

    public function setGroupID($groupID)
    {
        $this->groupID = htmlentities($groupID);
    }

    public function setGroupName($groupName)
    {
        $this->groupName = htmlentities($groupName);
    }

    public function setGroupDescription($groupDescription)
    {
        $this->groupDescription = htmlentities($groupDescription);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    //Group Manipulation functions

    //Creating a group for the user

    public function create($conn)
    {
        $sql = "INSERT INTO groups VALUES(:userID, :groupID)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
        $stmt->bindParam(':groupID', $this->getGroupID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "Create user group failed: " . $e->getMessage();
        }
    }

    //Delete group from user

    public function delete($conn, $groupID)
    {
        $sql = "DELETE FROM groups WHERE groupID = :groupID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $groupID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $row) {
                array_push($array, $row["roleID"]);
            }
            return $array;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Get all details

    public function getAllDetails($conn)
    {
        try {
            $sql = "SELECT * FROM groups g WHERE g.groupID = :groupID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':groupID', $this->getGroupID(), PDO::PARAM_STR);

            try {
                $stmt->execute();
                $results = $stmt->fetchAll();

                foreach ($results as $row) {
                    $this->setGroupID($row["groupID"]);
                    $this->setGroupDescription($row['groupDescription']);
                    $this->setGroupName($row['groupName']);
                }
                return true;
            } catch (PDOException $e) {
                return "Query failed: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //List all groups for drop down menus
    public function listAllGroups($conn)
    {
        $sql = "SELECT groupID, groupName FROM groups";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $row) {
                $array[$row['groupID']] = $row['groupName'];
            }
            return $array;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Group/security permissions

    //Admin ID 1
    public function isAdministrator($conn, $userID)
    {
        $sql = "SELECT u.userID FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 1 AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Is user apart of the committee ID:2

    public function isUserCommittee($conn, $userID)
    {
        $sql = "SELECT u.userID FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Standard users - Member ID: 3

    public function isUserMember($conn, $userID)
    {
        $sql = "SELECT u.userID FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 3 AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Past Members - ID :4

    public function isUserPastMember($conn, $userID)
    {
        $sql = "SELECT u.userID FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 3 AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Security checks functions

    //User pages
    public function userFullAccess($conn, $userID)
    {
        if ($this->isAdministrator($conn, $userID) || $this->isUserCommittee($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }

    public function userViewAccess($conn, $userID)
    {
        if ($this->userFullAccess($conn, $userID)) {
            return true;
        } else if ($this->isUserMember($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }

    //News pages
    public function newsFullAccess($conn, $userID)
    {
        if ($this->isAdministrator($conn, $userID) || $this->isUserCommittee($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }

    public function newsViewAccess($conn, $userID)
    {
        if ($this->newsFullAccess($conn, $userID)) {
            return true;
        } else if ($this->isUserMember($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }

    //Gallery Pages

    public function galleryFullAccess($conn, $userID)
    {
        if ($this->isAdministrator($conn, $userID) || $this->isUserCommittee($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }

    public function galleryViewAccess($conn, $userID)
    {
        if ($this->galleryFullAccess($conn, $userID)) {
            return true;
        } else if ($this->isUserMember($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }


    //CMS
    public function pageFullAccess($conn, $userID)
    {
        if ($this->isAdministrator($conn, $userID) || $this->isUserCommittee($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }

    //File upload/delete/view System

    public function filesFullAccess($conn, $userID)
    {
        if ($this->isAdministrator($conn, $userID) || $this->isUserCommittee($conn, $userID)) {
            return true;
        } else {
            return false;
        }
    }


    //List Committee members

    public function ListCommittee($conn)
    {
        //$sql = "SELECT userID FROM users u, user_groups ug, groups g WHERE ug.groupID = g.groupID AND g.groupID IN (2,3,4,5,6) AND u.userID = :userID";

        $sql = "SELECT u.userID FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.userID = :userID ORDER BY g.groupID ASC";

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $result) {
                if (array_key_exists($result["groupID"], $array)) {
                    $list = $array[$result["groupID"]];
                    array_push($list, $result["userID"]);
                    $array[$result["groupID"]] = $list;
                } else {
                    $list = array();
                    array_push($list, $result["userID"]);
                    $array[$result["groupID"]] = $list;
                }
            }
            return $array;
        } catch (PDOException $e) {
            return "List Committee Query failed: " . $e->getMessage();
        }
    }

    //Committee Roles

    //Current President - based on role
    public function isUserPresident($conn, $userID)
    {
        $sql = "SELECT u.userID, u.role FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.role='President' AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Current competitions vice president: ID 3
    public function isUserCompsPres($conn, $userID)
    {
        $sql = "SELECT u.userID, u.role FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.role='Competitions Vice president' AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Current outdoor events/trips vice president ID: 4
    public function isUserTripsPres($conn, $userID)
    {
        $sql = "SELECT u.userID, u.role FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.role='Outdoor Trips Chair' AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Current Social Chair
    public function isUserSocialChair($conn, $userID)
    {
        $sql = "SELECT u.userID, u.role FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.role='Social Chair' AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Current Fundraising Chair
    public function isUserFundraisingChair($conn, $userID)
    {
        $sql = "SELECT u.userID, u.role FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.role='Fundraising Chair' AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Current safety officer ID: 6

    public function isUserSafetyOfficer($conn, $userID)
    {
        $sql = "SELECT u.userID, u.role FROM users u, groups g WHERE u.groupID = g.groupID AND u.groupID = 2 AND u.role='Safety Officer' AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Validation functions
    public function isInputValid($name, $description)
    {
        if ($this->isNameValid($name) && $this->isDescriptionValid($description)) {
            return true;
        } else {
            return false;
        }
    }

    private function isNameValid($name)
    {
        if ((strlen($name) > 0) && (strlen($name) <= 50)) {
            return true;
        } else {
            return false;
        }
    }

    private function isDescriptionValid($description)
    {
        if (strlen($description) <= 250) {
            return true;
        } else {
            return false;
        }
    }

}