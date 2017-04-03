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

    private $userID, $groupID, $oauth_uid, $username, $email, $firstName, $lastName, $bio, $interests, $picture, $link, $role, $certifications,
        $approved, $accredited, $driver, $banned, $created, $modified, $tokenCode;


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

    public function getGroupID()
    {
        return $this->groupID;
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
        //Convert mysql date format to UK format
        $date = new DateTime($this->created);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d-m-Y');
    }

    public function getModifiedDate()
    {
        //Convert mysql date format to UK format
        $date = new DateTime($this->modified);
        $date->setTimezone(new DateTimeZone('Europe/London'));
        return $date->format('d-m-Y H:i:s');
    }

    //Profiles fields

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

    public function getRole()
    {
        return $this->role;
    }

    public function getCertifications()
    {
        return $this->certifications;
    }

    public function getTokenCode()
    {
        return $this->tokenCode;
    }

    //Flags

    public function getApproved()
    {
        return $this->approved;
    }

    public function getAccredited()
    {
        return $this->accredited;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getBanned()
    {
        return $this->banned;
    }


    public function getFullName()
    {
        return $this->getFirstName() . " " . $this->getLastName();
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


//Setters

    //Users Table
    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setGroupID($groupID)
    {
        $this->groupID = htmlentities($groupID);
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

    public function setModifiedDate($modified)
    {
        $this->modified = htmlentities($modified);
    }


    //Profile fields
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

    public function setRole($role)
    {
        $this->role = htmlentities($role);
    }

    public function setCertifications($certifications)
    {
        $this->certifications = ($certifications);
    }

    //Set flags

    public function setApproved($approved)
    {
        $this->approved = htmlentities($approved);
    }

    public function setAccredited($accredited)
    {
        $this->accredited = htmlentities($accredited);
    }

    public function setDriver($driver)
    {
        $this->driver = htmlentities($driver);
    }

    public function setBanned($banned)
    {
        $this->banned = htmlentities($banned);
    }

//Get all users' details

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from users WHERE userID = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);


        //Get user's details from users table row
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setGroupID($row['groupID']);
                $this->setUserName($row['username']);
                $this->setOAuthUID($row['oauth_uid']);
                $this->setEmail($row['email']);
                $this->setFirstName($row['firstName']);
                $this->setLastName($row['lastName']);
                $this->setBio($row['bio']);
                $this->setInterests($row['interests']);
                $this->setPicture($row['picture']);
                $this->setLink($row['link']);
                $this->setRole($row['role']);
                $this->setCertifications($row['certifications']);
                $this->setApproved($row['approved']);
                $this->setAccredited($row['accredited']);
                $this->setDriver($row['driver']);
                $this->setBanned($row['banned']);
                $this->setCreatedDate($row['created']);
                $this->setModifiedDate($row['modified']);
            }

        } catch (PDOException $e) {
            return "Query Failed:" . $e->getMessage();
        }
    }



//Creating Functions

    //Create user table record

    public function create($conn, $password)
    {
        try {
            ini_set('display_errors', true);
            //First let's hash the password with the bcrypt function
            $hash = password_hash($password, PASSWORD_DEFAULT);

            //Save current date time to variable for insertion
            $date = date('Y-m-d H:i:s');

            //SQL Statement
            //$sql = "INSERT INTO `users` (`userID`, `groupID`, `oauth_uid`, `username`, `password`, `email`, `firstName`, `lastName`, `bio`, `interests`, `picture`, `link`, `role`, `certifications`, `approved`, `accredited`, `driver`, `banned`, `created`, `modified`, `tokenCode`) VALUES (NULL, :groupID, :oauth, :username, :password, :email, :firstName, :lastName, :bio, :interests, :picture, :link, :role, :certifications, :approved, :accredited, :driver, :banned, :created, :modified, :tokenCode)";
            $sql = "INSERT INTO users VALUES (null, :groupID, :oauth ,:username, :password, :email, :firstName, :lastName, :bio, :interests, :picture, :link, :role, :certifications, :approve, :accredited, :driver, :banned, :created, :modified, :tokenCode)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':groupID', 3, PDO::PARAM_INT);
            $stmt->bindValue(':oauth', $this->getOauthUID(), PDO::PARAM_STR);
            $stmt->bindValue(':username', $this->getUsername(), PDO::PARAM_STR);
            $stmt->bindValue(':password', $hash, PDO::PARAM_STR);


            //Profile Fields

            $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':firstName', $this->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $this->getLastName(), PDO::PARAM_STR);
            $stmt->bindValue(':bio', $this->getBio(), PDO::PARAM_STR);
            $stmt->bindValue(':interests', $this->getInterests(), PDO::PARAM_INT);
            $stmt->bindValue(':picture', $this->getPicture(), PDO::PARAM_STR);
            $stmt->bindValue(':link', $this->getLink(), PDO::PARAM_STR);
            $stmt->bindValue(':role', $this->getRole(), PDO::PARAM_STR);
            $stmt->bindValue(':certifications', $this->getCertifications(), PDO::PARAM_STR);
            $stmt->bindValue(':approve', 0, PDO::PARAM_INT);
            $stmt->bindValue(':accredited', 0, PDO::PARAM_INT);
            $stmt->bindValue(':driver', 0, PDO::PARAM_INT);
            $stmt->bindValue(':banned', 0, PDO::PARAM_INT);
            $stmt->bindValue(':created', $date, PDO::PARAM_STR);
            $stmt->bindValue(':modified', $date, PDO::PARAM_STR);
            $stmt->bindValue(':tokenCode', $this->getTokenCode(), PDO::PARAM_STR);
            $stmt->execute();

            var_dump($stmt->debugDumpParams());

            return true;

        } catch (PDOException $e) {
            //dbClose($conn);
            return "Create user failed: " . $e->getMessage();
        } catch (Exception $e) {
            dbClose($conn);
            return "create failed: " . $e->getMessage();
        }
    }


    //Update user's profile
    public function updateUser($conn)
    {
        $date = date('Y-m-d H:i:s');
        try {
            $sql = "UPDATE users SET groupID = :groupID, email = :email, firstName = :firstName, lastName = :lastName, bio = :bio, interests = :interests, picture = :picture, link = :link, role = :role, certifications = :certifications,
                    approved = :approve, accredited = :accredited, driver = :driver, banned = :banned, modified = :modified
                    WHERE userID = :userID";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindValue(':groupID', $this->getGroupID(), PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $stmt->bindValue(':firstName', $this->getFirstName(), PDO::PARAM_STR);
            $stmt->bindValue(':lastName', $this->getLastName(), PDO::PARAM_STR);
            $stmt->bindValue(':bio', $this->getBio(), PDO::PARAM_STR);
            $stmt->bindValue(':interests', $this->getInterests(), PDO::PARAM_STR);
            $stmt->bindValue(':picture', $this->getPicture(), PDO::PARAM_STR);
            $stmt->bindValue(':link', $this->getLink(), PDO::PARAM_STR);
            $stmt->bindValue(':role', $this->getRole(), PDO::PARAM_STR);
            $stmt->bindValue(':certifications', $this->getCertifications(), PDO::PARAM_STR);
            $stmt->bindValue(':approve', $this->getApproved(), PDO::PARAM_INT);
            $stmt->bindValue(':accredited', $this->getAccredited(), PDO::PARAM_INT);
            $stmt->bindValue(':driver', $this->getDriver(), PDO::PARAM_INT);
            $stmt->bindValue(':banned', $this->getBanned(), PDO::PARAM_INT);
            $stmt->bindValue(':modified', $date, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return "update user failed: " . $e->getMessage();
        }

    }

    //List all users

    public function listAllUsers($conn, $name = null)
    {
        $sql = "SELECT * FROM users u";
        if (!is_null($name)) {
            $sql .= " WHERE u.firstName = :name OR u.lastName = :name";
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


    //Banning, approval ,accredited and driver Methods

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

    public function isDriver($conn)
    {
        $sql = "SELECT userID FROM users u WHERE u.driver = 1  AND u.userID = :userID";

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


    public function approveToggleUser($conn)
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
        } else if ($this->isApproved($conn)) {
            $sql = "UPDATE users SET approved = 0 WHERE userID = :userID";
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

    public function accreditToggleUser($conn)
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
        } else if ($this->isAccredited($conn)) {
            $sql = "UPDATE users SET accredited = 0 WHERE userID = :userID";
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


    public function drivingToggleUser($conn)
    {
        //Check if user can drive, if not then let flag to true
        if (!$this->isDriver($conn)) {
            $sql = "UPDATE users SET driver = 1 WHERE userID = :userID";
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

        } //Otherwise we can let flag to false
        else if ($this->isDriver($conn)) {
            $sql = "UPDATE users SET driver = 0 WHERE userID = :userID";
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
        $sql = "SELECT * FROM users u";
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
        $sql = "SELECT * FROM users u";
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
        $sql = "SELECT * FROM users u";
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
            return "List banned users query failed: " . $e->getMessage();
        }
    }

    public function listDrivers($conn)
    {
        $sql = "SELECT * FROM users u";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            $drivers = array();
            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                //Check if the user is approved or not
                if ($this->isDriver($conn)) {
                    //if not approved then add to array
                    $drivers [] = $row;
                }
            }
            return $drivers;
        } catch (PDOException $e) {
            return "List drivers query failed: " . $e->getMessage();
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
            return "User exist query failed: " . $e->getMessage();
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
            $hash = @$results[0]['password'];

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
            return "Login failed: " . $e->getMessage();
        }
    }

    //Searching Functions
    public function search($conn, $field, $query)
    {
        try {

            $field = "`" . str_replace("`", "``", $field) . "`";
            $sql = "SELECT * FROM `users` WHERE $field LIKE :users";
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

    public function isInputValid($conn, $username, $email, $firstName, $lastName, $bio, $interests, $picture, $link, $role, $certifications)
    {
        if ($this->isUsernameValid($conn, $username)
            && $this->isEmailValid($email)
            && $this->isFirstNameValid($firstName)
            && $this->isLastNameValid($lastName)
            && $this->isBioValid($bio)
            && $this->isInterestsValid($interests)
            && $this->isPictureValid($picture)
            && $this->isLinkValid($link)
            && $this->isRoleValid($role)
            && $this->isCertificationsValid($certifications)
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
        if (count($interests <= 100)) {
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

    public function isRoleValid($role)
    {
        if (count($role <= 200)) {
            return true;
        } else {
            return false;
        }
    }

    public function isCertificationsValid($certifications)
    {
        if (count($certifications <= 500)) {
            return true;
        } else {
            return false;
        }
    }
}


