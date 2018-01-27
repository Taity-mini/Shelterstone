<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 29/09/2017
 * Time: 21:09
 * Memberships system for tracking active and paid subscriptions for the current session
 */
?>

<h1 class="pageTitle" >Committee | Memberships</h1>

<p>Manage current session memberships</p>


<?php

if (isset($_SESSION['memberShipCreate'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Membership Successfully Added!</h5>
          </div>';
    unset($_SESSION['memberShipCreate']);
}

if (isset($_SESSION['update'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Membership Successfully updated!</h5>
          </div>';
    unset($_SESSION['update']);
}

if (isset($_SESSION['delete'])) {
    echo '<br/>';
    echo '<div class="callout alert">
          <h5>Membership Successfully Deleted!</h5>
          </div>';
    unset($_SESSION['delete']);
}

echo '<h4 class="large-text-center">Memberships for Current Session</h4>';


if ($membershipsList !=null) {
    echo '<table style="border 1px;" class="fileTable" style=" overflow-y: scroll;">
        <tr>

            <th>ID#</th>
            <th>Member<br></th>
            <th>Type</th>
            <th>Paid</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Edit</th>
        </tr>';

    foreach ($membershipsList as $row) {
        $membershipItem = new memberships($row['memberShipID']);
        $membershipItem->getAllDetails($conn);
        $userName = new users($row['userID']);
        $userName->getAllDetails($conn);
        $editLink = $domain . "committee/memberships/edit/" . $membershipItem->getMemberShipID();
        echo '<tr>';
        echo '<td>'.$membershipItem->getMemberShipID().'</td>';
        echo '<td>' . $userName->getFirstName() . ' '.$userName->getLastName().'</td>';
        echo '<td>'.$membershipItem->displayType().'</td>';
        echo '<td>'.$membershipItem->displayPaid().'</td>';
        echo '<td>'.$membershipItem->displayStartDate().'</td>';
        echo '<td>'.$membershipItem->displayEndDate().'</td>';
        echo '<td><a href="'.$editLink.'">Edit</a></td></tr>';

    }
    echo "</table><hr>";
} else {
    echo "No memberships added - add one in the form below. <hr>" ;
}

echo '<h4 class="large-text-center">Add Membership</h4>';

echo formStart();

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["sltType"])) {
        echo comboInputEmptyError(true, "Type", "sltType", "Please select...", "errEmptType", "Please select a Type", $memberships->listTypes());
    } else {
        echo comboInputPostback(true, "Type", "sltType", $_POST["sltType"], $memberships->listTypes());
    }
} else {
    echo comboInputBlank(true, "Type", "sltType", "Please select...", $memberships->listTypes());
}

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["sltMember"])) {
        echo comboInputEmptyError(true, "Member", "sltMember", "Please select...", "errEmptType", "Please select a member", $users->listAllUsersDropdown($conn));
    } else {
        echo comboInputPostback(true, "Member", "sltMember", $_POST["sltMember"],     $users->listAllUsersDropdown($conn));
    }
} else {
    echo comboInputBlank(true, "Member", "sltMember", "Please select...",     $users->listAllUsersDropdown($conn));
}

echo'<div class="large-12 medium-12 small-12 columns">
                <label><b>
                         Paid?</b>
                    <input type="hidden" value="0" name="chkPaid"/>
                    <input id="chkPaid" type="checkbox" name="chkPaid" value="1"/>
                </label>
            </div>
        ';

echo formEndWithButton("Add Membership");

?>