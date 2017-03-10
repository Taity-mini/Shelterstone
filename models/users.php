<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:23
 * User's object model class
 *
 */
class users
{

    //class variables based on user and profile fields

    private $userID, $oauth_uid, $username, $approved, $accredited, $banned, $created, $modified,
        $email, $firstName, $lastName, $bio, $interests, $picture, $link;


    //Constructor

    function __construct($userID = -1)
    {
        $this->userID = $userID;
    }


    //Getters

    public function getUserIDFromUsername($conn)
    {
        $sql = "SELECT userID FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $this->getUsername(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->userID = $row["userID"];
            }
            return true;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    public function getUserNameFromUserID($conn)
    {
        $sql = "SELECT username FROM users WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->username = $row["username"];
            }
            return true;
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Users Table

    public function getUserID()
    {
        return $this->userID;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getOauthUID()
    {
        return $this->oauth_uid;
    }


    public function getCreatedDate()
    {
        return $this->created;
    }

    public function getModifiedDate()
    {
        return $this->modified;
    }

    //Profiles Table

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function getInterests()
    {
        return $this->interests;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function getLink()
    {
        return $this->link;
    }

//Setters

    //Users Table
    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setUserName($username)
    {
        $this->username = htmlentities($username);
    }

    public function setOAuthUID($oauthUID)
    {
        $this->oauth_uid = htmlentities($oauthUID);
    }

    public function setCreatedDate($created)
    {
        $this->created = htmlentities($created);
    }

    public function setModifiedDate($modifed)
    {
        $this->modified = htmlentities($modifed);
    }


    //Profiles Table
    public function setEmail($email)
    {
        $this->email = htmlentities($email);
    }

    public function setFirstName($firstName)
    {
        $this->firstName = htmlentities($firstName);
    }

    public function setLastName($lastName)
    {
        $this->lastName = htmlentities($lastName);
    }

    public function setBio($bio)
    {
        $this->bio = htmlentities($bio);
    }

    public function setInterests($interests)
    {
        $this->interests = htmlentities($interests);
    }

    public function setPicture($picture)
    {
        $this->picture = htmlentities($picture);
    }

    public function setLink($link)
    {
        $this->link = htmlentities($link);
    }

//Get all users' details

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from profiles WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

        $sql2 = "SELECT username, oauth_uid, created, modified FROM users WHERE userID = :userID";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

        //Get user's details from profile
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setEmail($row['email']);
                $this->setFirstName($row['firstName']);
                $this->setLastName($row['lastName']);
                $this->setBio($row['bio']);
                $this->setInterests($row['interests']);
                $this->setPicture($row['picture']);
                $this->setLink($row['link']);
            }

        } catch (PDOException $e) {
            return "Query Failed:" . $e->getMessage();
        }

        //Get user's details from user's table
        try {
            $stmt2->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setUserName($row['username']);
                $this->setOAuthUID($row['oauth_uid']);
                $this->setCreatedDate($row['created']);
                $this->setModifiedDate($row['modified']);
            }

        } catch (PDOException $e) {
            return "Query Failed:" . $e->getMessage();
        }
    }

    //Get total number of registered users count
    public function getTotalCount($conn)
    {
        $sql = "SELECT COUNT(*) FROM users";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetch();
            $count = $results[0];
            return $count;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }


//Creating Functions


    public function create($conn, $password)
    {
        if ($this->createUser($conn, $password) && $this->createProfile($conn)) {
            return true;
        } else {
            return false;
        }
    }

    //Create user table record

    public function createUser($conn, $password)
    {
        try {
            //First let's hash the password with the bcrypt function
            $hash = password_hash($password, PASSWORD_DEFAULT);

            //Save current date time to variable for insertion
            $date = date('Y-m-d H:i:s');

            //SQL Statement
            $sql = "INSERT INTO users VALUES (null, :oauth ,:username, :password, :approve, :accredited, :banned, :created, :modifed)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':oauth', $this->getOauthUID(), PDO::PARAM_STR);
            $stmt->bindParam(':username', $this->getUsername(), PDO::PARAM_STR);
            $stmt->bindParam(':password', $hash, PDO::PARAM_STR);
            $stmt->bindParam(':approve', 0, PDO::PARAM_STR);
            $stmt->bindParam(':accredited', 0, PDO::PARAM_STR);
            $stmt->bindParam(':created', $date, PDO::PARAM_STR);
            $stmt->bindParam(':modified', $date, PDO::PARAM_STR);

            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            dbClose($conn);
            return "Create user failed: " . $e->getMessage();
        }
    }

    //Create user's profile table record
    public function createProfile($conn)
    {
        $this->getUserIDFromUsername($conn);
        try {
            $sql = "INSERT INTO profiles VALUES (:userID, :email, :firstName, :lastName, :bio, :interests, :picture, :link)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_INT);
            $stmt->bindValue(':firstName', $this->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $this->getLastName(), PDO::PARAM_INT);
            $stmt->bindValue(':bio', $this->getBio(), PDO::PARAM_INT);
            $stmt->bindValue(':interests', $this->getInterests(), PDO::PARAM_INT);
            $stmt->bindValue(':picture', $this->getPicture(), PDO::PARAM_STR);
            $stmt->bindValue(':link', $this->link, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Create profile failed: " . $e->getMessage();
        }

    }

    //Update user's profile
    public function updateProfile($conn)
    {
        try {
            $sql = "UPDATE profiles SET email = :email, firstName = :firstName, lastName = :lastName, bio = :bio, interests = :interests, picture = :picture, link = :link WHERE userID = :userID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_INT);
            $stmt->bindValue(':firstName', $this->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $this->getLastName(), PDO::PARAM_INT);
            $stmt->bindValue(':bio', $this->getBio(), PDO::PARAM_INT);
            $stmt->bindValue(':interests', $this->getInterests(), PDO::PARAM_STR);
            $stmt->bindValue(':link', $this->getLink(), PDO::PARAM_INT);

            //var_dump($stmt);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "update profile failed: " . $e->getMessage();
        }
    }

    //List all users

    public function listAllUsers($conn, $name = null)
    {
        $sql = "SELECT * FROM profiles p";
        if (!is_null($name)) {
            $sql .= " WHERE p.firstName = :name OR p.lastName = :name";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($name)) {
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }


    //Banning and approval and accredited Methods

    public function isApproved($conn)
    {
        $sql = "SELECT userID FROM users u WHERE u.approved = 1  AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

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

    public function isBanned($conn)
    {
        $sql = "SELECT userID FROM users u WHERE u.banned = 1  AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

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

    public function isAccredited($conn)
    {
        $sql = "SELECT userID FROM users u WHERE u.accredited = 1  AND u.userID = :userID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);

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

    public function approveUser($conn)
    {
        if (!$this->isApproved($conn)) {
            $sql = "UPDATE users SET approved = 1 WHERE userID = :userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            try {
                $stmt->execute();
                dbClose($conn);
                return true;
            } catch (PDOException $e) {
                dbClose($conn);
                return "Approval failed: " . $e->getMessage();
            }
        }
    }

    public function accreditUser($conn)
    {
        if (!$this->isAccredited($conn)) {
            $sql = "UPDATE users SET accredited = 1 WHERE userID = :userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            try {
                $stmt->execute();
                dbClose($conn);
                return true;
            } catch (PDOException $e) {
                dbClose($conn);
                return "Accredit failed: " . $e->getMessage();
            }
        }
    }


    public function banningToggleUser($conn)
    {
        //Check if the user is banned
        //Not currently banned? Then let's ban them from the site
        if (!$this->isBanned($conn)) {
            $sql = "UPDATE users SET banned = 1 WHERE userID = :userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            try {
                $stmt->execute();
                dbClose($conn);
                return true;
            } catch (PDOException $e) {
                dbClose($conn);
                return "Update failed: " . $e->getMessage();
            }

        } //Otherwise we can unban them from the site
        else if ($this->isBanned($conn)) {
            $sql = "UPDATE users SET banned = 0 WHERE userID = :userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            try {
                $stmt->execute();
                dbClose($conn);
                return true;
            } catch (PDOException $e) {
                dbClose($conn);
                return "Update failed: " . $e->getMessage();
            }
        }
    }

    //Listing functions for user attributes

    public function listUsersToApprove($conn)
    {
        $sql = "SELECT * FROM profiles p";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            $toApprove = array();
            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                //Check if the user is approved or not
                if (!$this->isApproved($conn)) {
                    //if not approved then add to array
                    $toApprove [] = $row;
                }
            }
            return $toApprove;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }

    public function listUsersToAccredit($conn)
    {
        $sql = "SELECT * FROM profiles p";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            $toAccredit = array();
            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                //Check if the user is approved or not
                if (!$this->isAccredited($conn)) {
                    //if not approved then add to array
                    $toAccredit [] = $row;
                }
            }
            return $toAccredit;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }

    public function listBannedUsers($conn)
    {
        $sql = "SELECT * FROM profiles p";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            $banList = array();
            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                //Check if the user is approved or not
                if ($this->isBanned($conn)) {
                    //if not approved then add to array
                    $banList [] = $row;
                }
            }
            return $banList;
        } catch (PDOException $e) {
            return "Database query failed: " . $e->getMessage();
        }
    }


    //Checking boolean methods
    //Does the user exist
    public function doesExist($conn)
    {
        $sql = "SELECT userID FROM users WHERE userID = :userID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //No user with the same username
    public function doesUserNameExist($conn)
    {
        $sql = "SELECT username FROM users WHERE username = :username LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $this->getUsername(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }


    //Login Function
    public function Login($userID, $password, $conn)
    {
        try {
            $sql = "SELECT userID, password from users WHERE userID =:userID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', htmlentities($userID), PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll();
            $hash = $results[0]['password'];

            if (isset($results)) {
                if (password_verify($password, $hash)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Searching Functions
    public function search($conn, $field, $query)
    {
        try {

            $field = "`" . str_replace("`", "``", $field) . "`";
            $sql = "SELECT * FROM `profiles` WHERE $field LIKE :query";
            $stmt = $conn->prepare($sql);

            //$stmt->bindParam(':field', $field, PDO::PARAM_STR);
            $stmt->bindParam(':query', $query, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (isset($results)) {
                return $results;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    //Validation Functions

    public function isInputValid($conn, $username, $email, $firstName, $lastName, $bio, $interests, $picture, $link)
    {
        if ($this->isUsernameValid($conn, $username)
            && $this->isEmailValid($email)
            && $this->isFirstNameValid($firstName)
            && $this->isLastNameValid($lastName)
            && $this->isBioValid($bio)
            && $this->isInterestsValid($interests)
            && $this->isPictureValid($picture)
            && $this->isLinkValid($link)
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function isUsernameValid($conn, $username)
    {
        $sql = "SELECT username FROM users WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        try {
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return true;
                //echo 'true';
            } else {
                return false;
                // echo 'false';
            }
        } catch (PDOException $e) {
            return "Query failed: " . $e->getMessage();
        }
    }

    public function isEmailValid($email)
    {
        if (strlen($email) > 0 && strlen($email) <= 250) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function isFirstNameValid($firstName)
    {
        if ((strlen($firstName) > 0) && (strlen($firstName) <= 60)) {
            return true;
        } else {
            return false;
        }
    }


    public function isLastNameValid($lastName)
    {
        if ((strlen($lastName) > 0) && (strlen($lastName) <= 60)) {
            return true;
        } else {
            return false;
        }
    }

    public function isBioValid($bio)
    {
        if (count($bio <= 600)) {
            return true;
        } else {
            return false;
        }
    }

    public function isInterestsValid($interests)
    {
        if (count($interests <= 50)) {
            return true;
        } else {
            return false;
        }
    }

    public function isPictureValid($picture)
    {
        if (count($picture <= 255)) {
            return true;
        } else {
            return false;
        }
    }


    public function isLinkValid($link)
    {
        if (count($link <= 255)) {
            return true;
        } else {
            return false;
        }
    }
}


