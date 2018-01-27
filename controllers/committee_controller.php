<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 15:58
 * Committee members pages controller
 */
class committee_controller extends controller
{

    function __construct()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/memberships.php');
    }

    public function member_management()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/memberships.php');

        //login check
        if (isset($_SESSION['userID'])) {

            $conn = dbConnect();

            $users = new users();
            $groups = new users_groups();
            //$currentUser = $users->setUserID($_SESSION['userID']);

            //committee or admin check
            if ($groups->isUserCommittee($conn, $_SESSION['userID']) || $groups->isAdministrator($conn, $_SESSION['userID'])) {

                //MemberLists
                $membersList = $users->listAllUsers($conn);
                $toApproveList = $users->listUsersToApprove($conn);
                $toAccredit = $users->listUsersToAccredit($conn);
                $bannedUsers = $users->listBannedUsers($conn);
                $drivers = $users->listDrivers($conn);


                //Perform Approve All Members
                if (isset($_POST['btnApproveAll'])) {
                    $conn = dbConnect();
                    $users = new users();
                    if ($users->approveAllUsers($conn)) {
                        $_SESSION['approveALL'] = true;
                        $this->redirect("committee/member_management");
                    }
                }

                if (isset($_POST['btnAccreditAll'])) {
                    $conn = dbConnect();
                    $users = new users();
                    if ($users->accreditAllUsers($conn)) {

                        $_SESSION['accreditALL'] = true;
                        $this->redirect("committee/member_management");
                    }
                }

                if (isset($_POST['btnRemoveBans'])) {
                    $conn = dbConnect();
                    $users = new users();
                    if ($users->removeAllBans($conn)) {
                        $_SESSION['unBanALL'] = true;

                    }
                    $this->redirect("committee/member_management");
                }

                require_once('./views/committee/member_management.php');

            } else {
                $this->redirect("error");
            }
        } else {
            $this->redirect("login");
        }


    }

    public function memberships()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/memberships.php');
        include('./inc/forms.inc.php');
        $domain = $_SESSION['domain'];

        //login check
        if (isset($_SESSION['userID'])) {

            $conn = dbConnect();

            $users = new users();
            $groups = new users_groups();
            $memberships = new memberships();


            //committee or admin check
            if ($groups->isUserCommittee($conn, $_SESSION['userID']) || $groups->isAdministrator($conn, $_SESSION['userID'])) {

                $membershipsList = $memberships->listAllMemberships($conn);

                //Add
                if (isset($_POST['btnSubmit'])) {

                    $conn = dbConnect();

                    $membership = new memberships();
                    $membership->setUserID($_POST['sltMember']);
                    $membership->setType($_POST['sltType']);
                    $membership->setPaid($_POST['chkPaid']);

                    $date = date("Y/m/d");
                    $membership->setStartDate($date);
                    $membership->setEndDate($date);

                    if ($membership->create($conn)) {
                        $_SESSION['memberShipCreate'] = true;
                        $this->redirect("committee/memberships");
                    } else {
                        $_SESSION['error'] = true;
                    }
                }

                require_once('./views/committee/memberships.php');

            } else {
                $this->redirect("error");
            }
        } else {
            $this->redirect("login");
        }
    }

    public function editMemberships()
    {
        require_once('./models/users.php');
        require_once('./models/users_groups.php');
        require_once('./models/memberships.php');
        include('./inc/forms.inc.php');

        $domain = $_SESSION['domain'];

        //login check
        if (isset($_SESSION['userID'])) {

            $conn = dbConnect();

            $users = new users();
            $groups = new users_groups();
            $memberships = new memberships();
            $memberships->setMemberShipID($_SESSION['params']['memID']);
            $memberships->getAllDetails($conn);

            $users->setUserID($memberships->getUserID());
            $users->getAllDetails($conn);


            if (!$memberships->doesExist($conn)) {
                $this->redirect("error");
            }


            //committee or admin check
            if ($groups->isUserCommittee($conn, $_SESSION['userID']) || $groups->isAdministrator($conn, $_SESSION['userID'])) {

                //Update
                if (isset($_POST['btnSubmit'])) {

                    $conn = dbConnect();

                    $membership = new memberships();
                    $membership->setMemberShipID($_SESSION['params']['memID']);
                    $membership->getAllDetails($conn);
                    $membership->setType($_POST['sltType']);
                    $payment = (isset($_POST['chkPaid']));
//                    if(isset($_POST['chkPaid']))
//                    {
//                        $membership->setPaid(1);
//                    } else{
//                        $membership->setPaid(0);
//                    }

                    $membership->setPaid($payment);


                    if ($membership->update($conn)) {
                        $_SESSION['update'] = true;
                        $this->redirect("committee/memberships");
                    } else {
                        $_SESSION['error'] = true;
                    }
                }
                //Delete
                if (isset($_POST['btnDelete'])) {
                    $conn = dbConnect();

                    $membership = new memberships();
                    $membership->setMemberShipID($_SESSION['params']['memID']);

                    if ($membership->delete($conn)) {
                        $_SESSION['delete'] = true;
                        $this->redirect("committee/memberships");
                    } else {
                        $_SESSION['delError'] = true;
                    }
                }
                require_once('./views/committee/membership_edit.php');

            } else {
                $this->redirect("error");
            }
        } else {
            $this->redirect("login");
        }
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