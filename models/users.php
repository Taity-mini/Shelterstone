<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 04/03/2017
 * Time: 19:23
 * User's object model class
 *
 */


class users{

    //class variables based on user and profile fields

    private $userID, $oauth_uid, $username, $approved, $accredited, $banned, $created, $modified,
        $email, $firstName, $lastName, $bio, $interests, $picture, $link;


    //Constructor

    function __construct($userID = -1)
    {
        $this->userID = $userID;
    }


    //Getters

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
        $this->modified =htmlentities($modifed);
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
        $this ->link = htmlentities($link);
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

            foreach($results as $row) {
                $this->setEmail($row['email']);
                $this->setFirstName($row['firstName']);
                $this->setLastName($row['lastName']);
                $this->setBio($row['bio']);
                $this->setWebsite($row['website']);
            }

        } catch (PDOException $e) {
            return "Query Failed:" . $e->getMessage();
        }

        //Get user's details from user's table
        try {
            $stmt2->execute();
            $results = $stmt->fetchAll();

            foreach($results as $row) {
                $this->setUserName($row['username']);
                $this->setOAuthUID($row['oauth_uid']);
                $this->setCreatedDate($row['created']);
                $this->setModifiedDate($row['modified']);
            }

        } catch (PDOException $e) {
            return "Query Failed:" . $e->getMessage();
        }
    }



}


