<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:08
 */
class climbing_controller extends controller
{
    public function listLogbooks()
    {
        //Check if user is logged in
        if (isset($_SESSION['userID'])) {

            require_once('./models/climbing_locations.php');
            require_once('./models/climbing_logbooks.php');
            require_once('./models/climbing_routes.php');
            include('./inc/forms.inc.php');

            $conn = dbConnect();
            $locations = new climbing_locations();
            $logbooks = new climbing_logbooks();

            $userID = $_SESSION['userID'];
            $logbookList = $logbooks->listAllLogbooks($conn, $userID);

            //Dropdown lists for forms
            $logbookTypes = $logbooks->listTypes();
            $locationList = $locations->listAllLocationsDropdown($conn);


            //Add new logbook
            if (isset($_POST['btnSubmit'])) {

                $conn = dbConnect();

                $logbook = new climbing_logbooks();

                $logbook->setLocationID($_POST['sltLocation']);
                $logbook->setUserID($_SESSION['userID']);
                $logbook->setDate($_POST['txtDate']);
                $logbook->setLogType($_POST['sltType']);
                $logbook->setNotes($_POST['txtNotes']);

                if ($logbook->isInputValid($logbook->getNotes())) {
                    if ($logbook->create($conn)) {
                        $_SESSION['create'] = true;
                        $this->redirect("climbing_log");
                    } else {
                        $_SESSION['error'] = true;
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            require_once('./views/climbing/logbook.php');
        } else {//Show login page otherwise
            $this->redirect("login");
        }
    }

    //Individual logbook
    public function logbook()
    {
        //Check if user is logged in
        if (isset($_SESSION['userID'])) {

            require_once('./models/climbing_locations.php');
            require_once('./models/climbing_logbooks.php');
            require_once('./models/climbing_routes.php');
            include('./inc/forms.inc.php');

            $conn = dbConnect();
            $users = new users();

            $logID = $_SESSION['params']['logID'];
            $locations = new climbing_locations();
            $logbook = new climbing_logbooks();
            $logbook->setLogID($logID);
            $logbook->getAllDetails($conn);

            $routes = new climbing_routes();

            $userID = $_SESSION['userID'];
            $routeList = $routes->listAllRoutes($conn, $logID);


            //Dropdown lists
            $partnerList = $users->listAllUsersDropdown($conn);

            //remove current user from partner list
            unset($partnerList[$userID]);
            $routeStyles = $routes->listStyles();

            //Add new route
            if (isset($_POST['btnSubmit'])) {

                $conn = dbConnect();

                $route = new climbing_routes();
                $logID = $_SESSION['params']['logID'];
                $route->setLogID($logID);
                $route->setRouteName($_POST['txtName']);
                $route->setRouteStyle($_POST['sltStyle']);
                $route->setRouteGrade($_POST['txtGrade']);

                //Set partner ID to selection or NULL (No Partner)
                if (isset($_POST['sltPartner'])) {
                    if ($_POST['sltPartner'] = '') {
                        $route->setPartnerID(NULL);
                    }
                } else {
                    $route->setPartnerID($_POST['sltPartner']);
                }

                if ($route->isInputValid($route->getRouteName(), $route->getRouteStyle(), $route->getRouteGrade())) {
                    if ($route->create($conn)) {
                        $_SESSION['create'] = true;
                        $this->redirect("climbing_log/logbook/" . $logID);
                    } else {
                        $_SESSION['error'] = true;
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            require_once('./views/climbing/view_logbook.php');

        } else {//Show login page otherwise
            $this->redirect("login");
        }


    }

    public function editLogbook()
    {
        //Check if user is logged in
        if (isset($_SESSION['userID'])) {

            require_once('./models/climbing_locations.php');
            require_once('./models/climbing_logbooks.php');
            require_once('./models/climbing_routes.php');
            include('./inc/forms.inc.php');

            $conn = dbConnect();
            $locations = new climbing_locations();
            $logbooks = new climbing_logbooks();


            $logID = $_SESSION['params']['logID'];

            $logbook = new climbing_logbooks();
            $logbook->setLogID($logID);
            $logbook->getAllDetails($conn);

            $userID = $_SESSION['userID'];

            //Dropdown lists for forms
            $logbookTypes = $logbooks->listTypes();
            $locationList = $locations->listAllLocationsDropdown($conn);


            //Update logbook
            if (isset($_POST['btnSubmit'])) {

                $conn = dbConnect();

                $logbook = new climbing_logbooks();
                $logID = $_SESSION['params']['logID'];
                $logbook->setLogID($logID);
                $logbook->setLocationID($_POST['sltLocation']);
                $logbook->setDate($_POST['txtDate']);
                $logbook->setLogType($_POST['sltType']);
                $logbook->setNotes($_POST['txtNotes']);


                if ($logbook->isInputValid($logbook->getNotes())) {
                    if ($logbook->update($conn)) {
                        $_SESSION['update'] = true;
                        $this->redirect("climbing_log");
                    } else {
                        $_SESSION['error'] = true;
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }


            //Perform Delete
            if (isset($_POST['btnDelete'])) {
                $conn = dbConnect();

                $logbook = new climbing_logbooks();
                $logID = $_SESSION['params']['logID'];
                $logbook->setLogID($logID);

                if ($logbook->delete($conn)) {
                    $_SESSION['delete'] = true;
                    $this->redirect("climbing_log");
                } else {
                    $_SESSION['error'] = true;
                }
            }

            require_once('./views/climbing/edit_logbooks.php');
        } else {//Show login page otherwise
            $this->redirect("login");
        }

    }

    public function locations()
    {
        require_once('./models/climbing_locations.php');

        //Check if user is logged in
        if (isset($_SESSION['userID'])) {


            include('./inc/forms.inc.php');

            $conn = dbConnect();
            $locations = new climbing_locations();

            $locationsList = $locations->listAllLocations($conn);


            //Add new location
            if (isset($_POST['btnSubmit'])) {
                $conn = dbConnect();

                $location = new climbing_locations();

                $location->setLocationName($_POST['txtName']);
                $location->setLocationDescription($_POST['txtDescription']);

                if ($location->isInputValid($location->getLocationName(), $location->getLocationDescription())) {
                    if ($location->create($conn)) {
                        $_SESSION['create'] = true;
                        $this->redirect("climbing_log/locations");
                    } else {
                        $_SESSION['error'] = true;
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }

            require_once('./views/climbing/locations.php');
        } else {//Show login page otherwise
            $this->redirect("login");
        }


    }

    public function editLocations()
    {
        require_once('./models/climbing_locations.php');

        //Check if user is logged in
        if (isset($_SESSION['userID'])) {
            require_once('./models/users.php');
            include('./inc/forms.inc.php');

            $conn = dbConnect();

            $locationID = $_SESSION['params']['locationID'];

            $location = new climbing_locations();
            $location->setLocationID($locationID);
            $location->getAllDetails($conn);


            // Security and error checks
            if (!$location->doesExist($conn)) {
                $this->redirect("error");
            }


            //Perform location update
            if (isset($_POST['btnUpdate'])) {

                $conn = dbConnect();
                $locationID = $_SESSION['params']['locationID'];
                $location = new climbing_locations();
                $location->setLocationID($locationID);

                $location->setLocationName($_POST['txtName']);
                $location->setLocationDescription($_POST['txtDescription']);

                if ($location->isInputValid($location->getLocationName(), $location->getLocationDescription())) {
                    //Check if location is in use by any log books
                    if (!$location->inUse($conn)) {
                        if ($location->update($conn)) {
                            $_SESSION['update'] = true;
                            $this->redirect("climbing_log/locations");
                        } else {
                            $_SESSION['error'] = true;
                        }
                    } else {
                        $_SESSION['inUse'] = true;
                    }

                } else {
                    $_SESSION['error'] = true;
                }
            }


            //Perform Delete
            if (isset($_POST['btnDelete'])) {
                $conn = dbConnect();
                $locationID = $_SESSION['params']['locationID'];
                $location = new climbing_locations();
                $location->setLocationID($locationID);

                if ($location->delete($conn)) {
                    $_SESSION['delete'] = true;
                    $this->redirect("climbing_log/locations");

                } else {
                    $_SESSION['error'] = true;
                }
            }


            $this->data['location'] = $location;
            //Extract data array to display variables on view template
            extract($this->data);
            require_once('./views/climbing/edit_locations.php');

        } else { //Show login page otherwise
            $this->redirect("login");
        }

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

        //Check if user is logged in
        if (isset($_SESSION['userID'])) {
            require_once('./models/users.php');
            include('./inc/forms.inc.php');

            $conn = dbConnect();

            $routeID = $_SESSION['params']['routeID'];
            $route = new climbing_routes();

            $route->setRouteID($routeID);
            $route->getALLDetails($conn);

            $logbook = new climbing_logbooks();
            $logbook->setLogID($route->getLogID());
            $logbook->getAllDetails($conn);

            $userID = $_SESSION['userID'];
            $users = new users();


            //Dropdown lists
            $partnerList = $users->listAllUsersDropdown($conn);
            //remove current user from partner list
            unset($partnerList[$userID]);

            $routeStyles = $route->listStyles();


            //Update new route
            if (isset($_POST['btnSubmit'])) {

                $conn = dbConnect();

                $route = new climbing_routes();
                $routeID = $_SESSION['params']['routeID'];
                $route->setRouteID($routeID);
                $route->setRouteName($_POST['txtName']);
                $route->setRouteStyle($_POST['sltStyle']);
                $route->setRouteGrade($_POST['txtGrade']);

                //Set partner ID to selection or NULL (No Partner)

                if ($_POST['sltPartner'] = '') {
                    $route->setPartnerID(NULL);
                } else {
                    $route->setPartnerID($_POST['sltPartner']);
                }

                if ($route->isInputValid($route->getRouteName(), $route->getRouteStyle(), $route->getRouteGrade())) {
                    if ($route->update($conn)) {
                        $_SESSION['update'] = true;
                        $route->getALLDetails($conn);
                        $logID = $route->getLogID();
                        $this->redirect("climbing_log/logbook/" . $logID);
                    } else {
                        $_SESSION['error'] = true;
                    }
                } else {
                    $_SESSION['error'] = true;
                }
            }


            require_once('./views/climbing/edit_routes.php');

        } else {
            $this->redirect("login");
        }

    }
}