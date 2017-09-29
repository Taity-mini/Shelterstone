<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 19/03/2017
 * Time: 23:42
 * Event pages controller
 */

class events_controller  extends controller
{

    function constructor()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/events.php');

    }

    public function listEvents()
    {
        require_once ('./views/events/event_list.php');
    }

    public function addEvent()
    {
        require_once ('./views/events/event_add.php');
    }

    public function editEvent()
    {
        require_once ('./views/events/event_edit.php');
    }

    public function viewEvent()
    {
        require_once ('./views/events/event_view.php');
    }

    public function compEvents()
    {
        require_once ('./views/events/comp_events.php');
    }

    public function  tripEvents()
    {
        require_once ('./views/events/trip_events.php');
    }
}