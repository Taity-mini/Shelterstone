<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 04/03/2017
 * Time: 19:28
 * User groups class
 */


class users_groups
{

    //Class variables for group and user group fields

    private $groupID, $groupName, $groupDescription, $userID;

    //Constructor
    function _constructor($userID = "zzz", $groupID = -1)
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
        $sql = "INSERT INTO user_groups VALUES(:userID, :groupID)";
        $stmt = $conn ->prepare($sql);

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

    public function delete($conn, $userID)
    {
        $sql = "DELETE FROM user_groups WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

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
            $sql = "SELECT * FROM user_groups ug, groups g WHERE ug.userID = :userID and ug.groupID = g.groupID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

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

    //Get all groups

    public function getAllGroups($conn)
    {
        $sql = "SELECT g.groupID, g.groupName FROM user_groups m, groups g WHERE m.groupID = g.groupID";
        $stmt = $conn->prepare($sql);
        //$stmt->bindParam(':member', $this->getMember(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $row) {
                $array[$row["groupID"]] = $array[$row["groupName"]];
            }
            return $array;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Check permissions

    //Admin ID 1
    public function isAdministrator($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 1 AND ug.userID = :userID";

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

    //Current President ID 2
    public function isUserPresident($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 2 AND ug.userID = :userID";

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
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 3 AND ug.userID = :userID";

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

    //Current outdoor event/trips vice president ID: 4
    public function isUserTripsPres($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 4 AND ug.userID = :userID";

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

    //Current social secretary ID: 5
    public function isUserSocialSecretary($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 5 AND ug.userID = :userID";

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

    //Current health coordinator ID: 6

    public function isUserHealthCoordinator($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 6 AND ug.userID = :userID";

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

    //Standard users - Member ID: 7

    public function isUserMember($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 7 AND ug.userID = :userID";

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


    //Past Members - ID :8

    public function isUserPastMember($conn, $userID)
    {
        $sql = "SELECT ug.userID FROM user_groups ug, groups g WHERE ug.groupID = g.groupID AND ug.groupID = 8 AND ug.userID = :userID";

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

    //Is user apart of the committee

    public function isUserCommittee($conn, $userID)
    {
        $sql = "SELECT userID FROM users u, user_groups ug, groups g WHERE ug.groupID = g.groupID AND g.groupID IN (2,3,4,5,6,) AND u.userID = :userID";
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

    //List Committee members

    public function ListCommittee($conn)
    {
        //$sql = "SELECT userID FROM users u, user_groups ug, groups g WHERE ug.groupID = g.groupID AND g.groupID IN (2,3,4,5,6) AND u.userID = :userID";

        $sql = "SELECT u.userID, g.groupID FROM users u, user_groups ug, groups g WHERE ug.groupID = g.groupID AND g.groupID IN (2,3,4,5,6) AND u.userID = :userID ORDER BY g.groupIDASC";

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $result) {
                if (array_key_exists($result["groupID"],$array)) {
                    $list = $array[$result["groupID"]];
                    array_push($list,$result["userID"]);
                    $array[$result["groupID"]] = $list;
                } else {
                    $list = array();
                    array_push($list,$result["userID"]);
                    $array[$result["groupID"]] = $list;
                }
            }
            return $array;
        } catch (PDOException $e) {
            return "List Committee Query failed: " . $e->getMessage();
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