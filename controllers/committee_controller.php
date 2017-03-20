<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 15:58
 * Committee members pages controller
 */
class committee_controller
{

    function constructor()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/memberships.php');
    }

    public function member_management()
    {

        require_once('./views/committee/member_management.php');

    }

    public function event_management()
    {
        require_once('./models/events.php');
        require_once('./views/committee/event_management.php');
    }

    public function agenda()
    {
        require_once('./models/files.php');
        require_once('./views/committee/agenda.php');
    }

}