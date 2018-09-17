<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 01/10/2017
 * Time: 17:10
 * Membership edit page
 */

echo'<div class="large-12 medium-12 small-12 columns">';
echo '<h4 class="large-text-center">Edit Membership ID: '.$memberships->getMemberShipID().'</h4>';

echo formStart();


echo textInputSetup(true, "<i class='fi-torso'></i>", "txtMember", $users->getFullName(), 8, true);


if (isset($_POST["btnSubmit"])) {
    echo comboInputPostback(true, "Type", "sltType", $_POST["sltType"],$memberships->listTypes());
} else {
    if (!is_null($memberships->getType())) {
        echo comboInputSetup(true, "Type", "sltType", $memberships->getType(), $memberships->listTypes());
    } else {
        echo comboInputBlank(true, "Type", "sltType", "Please select...", $memberships->listTypes());
    }
}


?>
<div class="large-8 medium-8 small-12 columns">
    <input id="chkPaid" type="checkbox" name="chkPaid" value="1"
    <?php echo($memberships->getPaid() == 1 ? 'checked' : ''); ?>/><label
    for="Paid"><b>Paid?</b></label>

</div>

<div class="large-5 large-centered medium-8 medium-centered small-12 small-centered columns">
        <input class="success button" type="submit" name="btnSubmit" value="Update Membership">
        <input type="submit" name="btnDelete" class="alert button" value="Delete Membership"
               onclick="return confirm('Are you sure? This WILL delete this membership.')">

        <input class="button" type="reset" value="Reset">

</div>
<a href="/committee/memberships" class="button">Go Back</a>
</div>
</div>
</div>