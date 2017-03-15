<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 14/03/2017
 * Time: 23:25
 *
 * Competitions model/object class for the competition and results table
 */
class competitions
{
    //Private variables/Properties

    private $compID, $authorID, $locationID, $title, $description, $date, $modified,
       $userID, $category, $position, $totalScore;

    function _constructor($compID = -1)
    {
        $this->compID = htmlentities($compID);
    }

    //Getters

    //Competition information
    public function getCompID()
    {
        return $this->compID;
    }

    public function getAuthorID()
    {
        return $this->authorID;
    }

    public function getLocationID()
    {
        return $this->locationID;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDate()
    {
        return $this->date;
    }

    //Competition results


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


}