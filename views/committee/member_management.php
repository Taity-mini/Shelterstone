<?php
/**
 * Creataccreditedrm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:20
 * Committee  | Member management
 */
?>
    <h1 class="pageTitle" >Committee | Member Management</h1>

    <p>List of all members and various modification options</p>

<?php

//TO BE APPROVED MEMBERS LIST START
echo '<hr>';
echo '<h4 class="large-text-center">Members to be Approved</h4>';

if (isset($_SESSION['approve'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Member Successfully Approved!</h5>
          </div>';
    unset($_SESSION['approve']);
}

if ($toApproveList !=null) {
    echo '<table style="border 1px;">
        <tr>
            <th>Name</th>
            <th>Username<br></th>
            <th>Group</th>
            <th>Approve</th>
        </tr>';

    foreach ($toApproveList as $row) {
        $userName = new users($row['userID']);
        $userName->getAllDetails($conn);
        $group = new users_groups($userName->getUserID(), $userName->getGroupID());
        $group->getAllDetails($conn);
        $userlink = "../profile/view/" . $row['userID'];


        echo '<td> <a href="' . $userlink . '">' . $userName->getUsername() . '</a></td>';
        echo '<td>' . $userName->getFirstName() . ' '.$userName->getLastName().'</td>';
        echo '<td>'.$group->getGroupName().'</td>';
        echo '<td align="center"><button type="button" class="button" data-value0="0" data-value1="' . $userName->getUserID() . '">Approve </button></td>';   echo "<tr>";
    }
    echo "</table>";
    echo '<form action="" method="post"><input type="submit" name="btnApproveAll" class="button large-text-center" value="Approve All Users"
                       onclick="return confirm(\'Are you sure you want to approve all users?\')"></form> <hr/>';

} else {
    echo "No Members to be Approved";
}


//TO BE APPROVED MEMBERS LIST END


echo '<h4 class="large-text-center">Members to be Accredited</h4>';

if (isset($_SESSION['accredit'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Member Successfully Accredited!</h5>
          </div>';
    unset($_SESSION['accredit']);
}

if ($toAccredit !=null) {
    echo '<table style="border 1px;">
        <tr>
            <th>Name</th>
            <th>Username<br></th>
            <th>Group</th>
            <th>Action</th>
        </tr>';

    foreach ($toAccredit as $row) {
        $userName = new users($row['userID']);
        $userName->getAllDetails($conn);
        $group = new users_groups($userName->getUserID(), $userName->getGroupID());
        $group->getAllDetails($conn);
        $userlink = "../profile/view/" . $row['userID'];


        echo '<td> <a href="' . $userlink . '">' . $userName->getUsername() . '</a></td>';
        echo '<td>' . $userName->getFirstName() . ' '.$userName->getLastName().'</td>';
        echo '<td>'.$group->getGroupName().'</td>';
        echo '<td align="center"><button type="button" class="button" data-value0="1" data-value1="' . $userName->getUserID() . '">Accredit</button></td>';   echo "<tr>";
    }
    echo "</table>";
    echo '<form action="" method="post"><input type="submit" name="btnAccreditAll" class="button large-text-center" value="Accredit All Users"
                       onclick="return confirm(\'Are you sure you want to accredit all users?\')"></form> <hr/>';

} else {
    echo "No Members to be Accredited";
}



//STANDARD MEMBERS LIST START


echo '<h4 class="large-text-center">Members list</h4>';

if ($membersList !=null) {
    echo '<table style="border 1px;">
        <tr>

            <th>Name</th>
            <th>Username<br></th>
            <th>Group</th>
            <th>Role</th>
            <th>View</th>
            <th>Edit</th>
        </tr>';

    foreach ($membersList as $row) {
        $userName = new users($row['userID']);
        $userName->getAllDetails($conn);
        $group = new users_groups($userName->getUserID(), $userName->getGroupID());
        $group->getAllDetails($conn);

        //Hyperlinks
        $userlink = "../profile/view/" . $row['userID'];
        $editlink = "../profile/edit/" . $row['userID'];
        $approveLink = "../admin/approve.php?u=" . $row['userID'];
        $banLink = "../admin/banning.php?u=" . $row['userID'];

        echo '<td>' . $userName->getFirstName() . ' '.$userName->getLastName().'</td>';
        echo '<td> '.$userName->getUsername().'</td>';
        echo '<td>'.$group->getGroupName().'</td>';
        echo '<td>'.$userName->getRole().'</td>';
        echo '<td><a href="' . $userlink . '">View</a></td>';
        echo '<td><a href="' . $editlink . '">Edit</a></td>';
    }
    echo "</table><hr>";
} else {
    echo "No Users Registered, how are you here?! <hr>" ;
}


//STANDARD MEMBERS LIST END

//DRIVERS LIST START

echo '<h4 class="large-text-center">List of Club Drivers</h4>';


if ($drivers !=null) {
    echo '<table style="border 1px;">
        <tr>
            <th>Name</th>
            <th>Username<br></th>
            <th>Group</th>
            <th>Role</th>
        </tr>';

    foreach ($drivers as $row) {
        $userName = new users($row['userID']);
        $userName->getAllDetails($conn);
        $group = new users_groups($userName->getUserID(), $userName->getGroupID());
        $group->getAllDetails($conn);
        $userlink = "../profile/view/" . $row['userID'];


        echo '<td>' . $userName->getFirstName() . ' '.$userName->getLastName().'</td>';
        echo '<td> <a href="' . $userlink . '">' . $userName->getUsername() . '</a></td>';
        echo '<td>'.$group->getGroupName().'</td>';
        echo '<td>'.$userName->getRole().'</td>';
    }
} else {
    echo "No Drivers currently in the club";
}
echo "</table> <hr/>";
//DRIVERS LIST END

echo '<h4 class="large-text-center">Banned Members</h4>';

if (isset($_SESSION['unBan'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Member Successfully Accredited!</h5>
          </div>';
    unset($_SESSION['unBan']);
}

if ($bannedUsers !=null) {
    echo '<table style="border 1px;">
        <tr>
            <th>Name</th>
            <th>Username<br></th>
            <th>Group</th>
            <th>Role</th>
            <th>Action</th>
        </tr>';

    foreach ($bannedUsers as $row) {
        $userName = new users($row['userID']);
        $userName->getAllDetails($conn);
        $group = new users_groups($userName->getUserID(), $userName->getGroupID());
        $group->getAllDetails($conn);
        $userlink = "../profile/view/" . $row['userID'];


        echo '<td>' . $userName->getFirstName() . ' '.$userName->getLastName().'</td>';
        echo '<td> <a href="' . $userlink . '">' . $userName->getUsername() . '</a></td>';
        echo '<td>'.$group->getGroupName().'</td>';
        echo '<td>'.$userName->getRole().'</td>';
        echo '<td align="center"><button type="button" class="button" data-value0="2" data-value1="' . $userName->getUserID() . '">UnBan</button></td>';   echo "<tr>";
    }

    echo "</table>";
    echo '<form action="" method="post"><input type="submit" name="btnRemoveBans" class="button large-text-center" value="Remove all Bans"
                       onclick="return confirm(\'Are you sure you want to remove all current bans?\')"></form>';

} else {
    echo "No Members currently Banned in the club";
}


?>

<script>




</script>
