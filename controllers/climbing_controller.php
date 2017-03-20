<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:08
 */
class climbing_controller
{
    public function listLogbooks()
    {
        require_once('./models/climbing_locations.php');
        require_once('./models/climbing_logbooks.php');
        require_once('./models/climbing_routes.php');

        require_once('./views/climbing/logbook.php');
    }

    //Individual logbook
    public function logbook()
    {
        require_once('./models/climbing_locations.php');
        require_once('./models/climbing_logbooks.php');
        require_once('./models/climbing_routes.php');

        require_once('./views/climbing/view_logbook.php');
    }

    public function locations()
    {
        require_once('./models/climbing_locations.php');
        require_once('./views/climbing/locations.php');
    }

    public function editLocations()
    {
        require_once('./models/climbing_locations.php');
        require_once('./views/climbing/locations.php');
    }

    public function viewRoutes()
    {
        require_once('./models/climbing_locations.php');
        require_once('./models/climbing_logbooks.php');
        require_once('./models/climbing_routes.php');
        require_once('./views/climbing/view_routes.php');
    }

    public function editRoutes()
    {
        require_once('./models/climbing_locations.php');
        require_once('./models/climbing_logbooks.php');
        require_once('./models/climbing_routes.php');
        require_once('./views/climbing/edit_route.php');

    }

}