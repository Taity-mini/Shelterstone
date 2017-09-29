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
            if ($groups->isUserCommittee($conn, $_SESSION['userID']) || $groups->isAdministrator($conn,$_SESSION['userID'])) {

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
                    if($users->approveAllUsers($conn))
                    {
                        $_SESSION['approveALL'] = true;
                        $this->redirect("committee/member_management");
                    }
                }

                if (isset($_POST['btnAccreditAll'])) {
                    $conn = dbConnect();
                    $users = new users();
                    if($users->accreditAllUsers($conn))
                    {

                        $_SESSION['accreditALL'] = true;
                        $this->redirect("committee/member_management");
                    }
                }

                if (isset($_POST['btnRemoveBans'])) {
                    $conn = dbConnect();
                    $users = new users();
                    if($users->removeAllBans($conn))
                    {
                        $_SESSION['unBanALL'] = true;
                        $this->redirect("committee/member_management");
                    }
                }

                require_once('./views/committee/member_management.php');

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