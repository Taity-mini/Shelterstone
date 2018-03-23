<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 23/03/2018
 * Time: 22:50
 */

class roles{


    private $roleID, $role, $description, $email;

    function  __construct($roleID = -1)
    {
        $this->roleID = $roleID;
    }

    /**
     * @return int
     */
    public function getRoleID()
    {
        return $this->roleID;
    }

    /**
     * @param int $roleID
     */
    public function setRoleID($roleID)
    {
        $this->roleID = $roleID;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


// ***** OTHER METHODS *****    
    public function getAllDetails($conn) {

        $sql = "SELECT * FROM roles WHERE roleID = :roleID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':roleID', $this->getRoleID(), PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setRoleID($row["roleID"]);
                $this->setRole($row["role"]);
                $this->setDescription($row["description"]);
                $this->setEmail($row["email"]);
            }
            return true;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    public function listAllRoles($conn) {
        $sql = "SELECT roleID, role FROM roles";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            $array = array();
            foreach ($results as $result) {
                $array[$result["roleID"]] = $result["role"];
            }
            return $array;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    public function isInputValid($role, $description) {
        if (isRoleValid($role) && isDescriptionValid($description)) {
            return true;
        } else {
            return false;
        }
    }

    public function isRoleValid($role) {
        if (count($role) > 0 && count($role) <= 250) {
            return true;
        } else {
            return false;
        }
    }

    public function isDescriptionValid($description) {
        if (count($description) <= 250) {
            return true;
        } else {
            return false;
        }
    }

    public function doesExist($conn) {
        $sql = "SELECT roleID FROM roles WHERE roleID = :roleID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':roleID', $this->getID(), PDO::PARAM_INT);

        try {
            $stmt->execute();
            if (count($results == 1)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }



}