<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 17/03/2017
 * Time: 01:15
 * Event Attendees object/model class
 */
class event_attendees
{

    //Properties/variables

    private $eventAttendeeID, $eventID, $userID, $paid, $notes;

    //Constructor

    function _constructor($eventAttendeeID = -1)
    {
        $this->eventAttendeeID = htmlentities($eventAttendeeID);
    }

    //Getters

    public function getEventAttendeeID()
    {
        return $this->eventAttendeeID;
    }

    public function getEventID()
    {
        return $this->eventID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getPaid()
    {
        return $this->paid;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    //Setters

    public function setEventAttendeeID($eventAttendeeID)
    {
        $this->eventAttendeeID = htmlentities($eventAttendeeID);
    }

    public function setEventID($eventID)
    {
        $this->eventID = htmlentities($eventID);
    }

    public function setUserID($userID)
    {
        $this->userID = htmlentities($userID);
    }

    public function setPaid($paid)
    {
        $this->paid = htmlentities($paid);
    }

    public function setNotes($notes)
    {
        $this->notes = htmlentities($notes);
    }

    //Get total number of events attendees count
    public function getTotalCount($conn, $eventID = null)
    {
        $sql = "SELECT COUNT(*) FROM event_attendees";

        if (!is_null($eventID)) {
            $sql .= " WHERE eventID = :eventID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($eventID)) {
            $stmt->bindParam(':eventID', $eventID, PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            $results = $stmt->fetch();
            $count = $results[0];
            return $count;
        } catch (PDOException $e) {
            return "Event attendees total count query failed: " . $e->getMessage();
        }
    }


    //CRUD Methods

    public function getAllDetails($conn)
    {
        $sql = "SELECT * from events_attendees WHERE eventAtendeeID = :eventAttendeeID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventAttendeeID', $this->getEventAttendeeID(), PDO::PARAM_STR);


        //Get events details from events table row
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $row) {
                $this->setUserID($row['userID']);
                $this->setEventID($row['eventID']);
                $this->setPaid($row['paid']);
                $this->setNotes($row['notes']);
            }
        } catch (PDOException $e) {
            return "events get details query Failed:" . $e->getMessage();
        }
    }

    public function create($conn)
    {
        try {
            //SQL Statement
            $sql = "INSERT INTO events VALUES (null, :userID, :locationID ,:title, :description, :type, :cost)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':locationID', $this->getLocationID(), PDO::PARAM_STR);
            $stmt->bindValue(':title', $this->getType(), PDO::PARAM_STR);
            $stmt->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->getType(), PDO::PARAM_STR);
            $stmt->bindParam(':cost', $this->getCost(), PDO::PARAM_STR);
            return true;

        } catch (PDOException $e) {
            dbClose($conn);
            return "Create events attendee entry failed:" . $e->getMessage();
        }
    }

    public function update($conn)
    {
        try {
            $sql = "UPDATE events_attendees SET eventID = :eventID, userID = :userID, paid = :paid, notes = :notes
                    WHERE eventAttendeeID = :eventAttendeeID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':eventID', $this->getEventID(), PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->getUserID(), PDO::PARAM_STR);
            $stmt->bindParam(':paid', $this->getPaid(), PDO::PARAM_STR);
            $stmt->bindValue(':notes', $this->getNotes(), PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            dbClose($conn);
            return "Update events attendee entry failed: " . $e->getMessage();
        }
    }

    public function delete($conn, $eventID = null, $userID = null)
    {
        $sql = "DELETE * FROM event_attendees";

        if (!is_null($userID)) {
            $sql .= " WHERE userID = :userID";
        }

        if (!is_null($eventID)) {
            $sql .= " WHERE eventID = :eventID";
        }

        if (is_null($userID) && is_null($eventID)) {
            $sql .= " WHERE eventAttendeeID = :eventAttendeeID";
        }

        $stmt = $conn->prepare($sql);

        if (!is_null($userID)) {
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        }
        if (!is_null($eventID)) {
            $stmt->bindParam(':eventID', $eventID, PDO::PARAM_STR);
        }

        if (is_null($userID) && is_null($eventID)) {
            $stmt->bindParam(':eventAttendeeID', $this->getEventAttendeeID(), PDO::PARAM_STR);
        }

        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "Delete events attendees query failed: " . $e->getMessage();
        }
    }

    //Listing Event attendees

    public function listAllEventAttendees($conn)
    {
        $sql = "SELECT * FROM events_attendees WHERE eventsID = : eventID";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':eventID', $this->getEventID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            return $results;
        } catch (PDOException $e) {
            return "List all events results query failed: " . $e->getMessage();
        }
    }

    //Boolean checker functions

    public function doesExist($conn)
    {
        $sql = "SELECT eventAttendeeID FROM events_attendees WHERE eventAttendeeID = :eventAttendeeID LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventID', $this->getEventAttendeeID(), PDO::PARAM_STR);
        try {
            $stmt->execute();
            $results = $stmt->fetchAll();
            if (count($results) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Check events attendee record exists query failed: " . $e->getMessage();
        }
    }

    public function hasPaid($conn)
    {
        $sql = "SELECT eventAttendeeID FROM event_attendees ea WHERE ea.paid = 1  AND ea.eventAttendeeID = :eventAttendeeID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventAttendeeID', $this->getEventAttendeeID(), PDO::PARAM_STR);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Has user paid for events query failed: " . $e->getMessage();
        }
    }

    //Input validation functions
    public function isNotesValid($notes)
    {
        if (count($notes <= 400)) {
            return true;
        } else {
            return false;
        }
    }


}