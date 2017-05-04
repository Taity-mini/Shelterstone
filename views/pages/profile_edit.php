<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 17:37
 * Edit user's profile
 */
if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Profile Update Failed</h5>
          <p>Form incomplete, errors are highlighted below.</p>
          </div>';
    unset($_SESSION['error']);
}

?>

<h1 class="pageTitle">Edit Profile: <?= $profile->getUsername() ?></h1>

<p>Edit user's profile</p>
<div class="small-6 small-centered large-10 large-centered columns">
    <form method="post">

        <div class="row collapse">
            <div class="small-2  columns">
                <span class="prefix"><i class="fi-torso"></i></span>
            </div>
            <div class="small-10  columns">
                <?= $profile->getUsername() ?>
            </div>
        </div>


        <div class="row collapse">
            <div class="small-2 columns">
                <span class="prefix"><i class="fi-mail"></i></span>
            </div>
            <div class="small-10  columns">
                <input type="text" id="txtEmail" name="txtEmail" maxlength="100" value="<?= $profile->getEmail(); ?>"/>
            </div>
        </div>

        <div class="row collapse">
            <div class="small-2 columns">
                <span><b>First Name</b></span>
            </div>
            <div class="small-10  columns">
                <input type="text" id="txtFirstName" name="txtFirstName" maxlength="20"
                       value="<?= $profile->getFirstName(); ?>"/>
            </div>
        </div>

        <div class="row collapse">
            <div class="small-2 columns">
                <span><b>Last Name</b></span>
            </div>
            <div class="small-10  columns">
                <input type="text" id="txtLastName" name="txtLastName" maxlength="20"
                       value="<?= $profile->getLastName(); ?>"/>
            </div>
        </div>

        <div class="row collapse">
            <div class="small-2 columns">
                <span><b>Link</b></span>
            </div>
            <div class="small-10  columns">
                <input type="text" id="txtLink" name="txtLink" maxlength="255"
                       value="<?= $profile->getLink(); ?>"/>
            </div>
        </div>

        <div class="row collapse">
            <div class="small-2 columns">
                <label for="left-label" class="text-left"><b>Bio</b></label>
            </div>
            <div class="small-10 columns">
                <textarea id="txtBio" name="txtBio" rows="8" maxlength="500"><?= $profile->getBio(); ?></textarea>
            </div>
        </div>

        <div class="row collapse">
            <div class="small-2 columns">
                <label for="left-label" class="text-left"><b>Interests</b></label>
            </div>
            <div class="small-10 columns">
                <textarea id="txtInterests" name="txtInterests" rows="2"
                          maxlength="100"><?= $profile->getInterests(); ?></textarea>
            </div>
        </div>

        <div class="row collapse">
            <div class="small-2 columns">
                <label for="left-label" class="text-left"><b>Certifications</b></label>
            </div>
            <div class="small-10 columns">
                <textarea id="txtCertifications" name="txtCertifications" rows="8"
                          maxlength="500"><?= $profile->getCertifications(); ?></textarea>
            </div>
        </div>

        <?php
        if ($limitedEdit) {
            ?>
            <input id="chkDriver" type="checkbox" name="chkDriver" value="1"
                <?php echo($profile->getDriver() == 1 ? 'checked' : ''); ?>/><label
                for="Driver"><b>Driver</b></label>
            <?php
        } else if (!$limitedEdit) {
            ?>
            <fieldset class="fieldset">
                <legend>Admin Stuff</legend>

                <div class="row collapse">
                    <div class="small-2 columns">
                        <span><b>Role</b></span>
                    </div>
                    <div class="small-10  columns">
                        <input type="text" id="txtRole" name="txtRole" maxlength="200"
                               value="<?= $profile->getRole(); ?>"/>
                    </div>
                </div>


                <?php

                         $output = '<div class="large-12 medium-12 small-12 columns">
                                <label><b>
                                    <span class="required">* Group </span></b>
                                <select id="sltGroup" name="sltGroup">';

                            foreach ($group->listAllGroups($conn) as $key => $value) {
                                if ($value == $profile->getGroupID() || $key == $profile->getGroupID()) {
                                    $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                                } else {
                                    $output .= '<option value="' . $key . '">' . $value . '</option>';
                                }
                            }
                            $output .= '</select>';
                            echo $output;
                ?>

                <div class="row collapse">
                    <div class="small-2  columns">
                        <span class="prefix">Registered Date:</i></span>
                    </div>
                    <div class="small-10  columns">
                        <?= $profile->getCreatedDate() ?>
                    </div>
                </div>

                <div class="row collapse">
                    <div class="small-2  columns">
                        <span class="prefix">Last Modified Date:</span>
                    </div>
                    <div class="small-10  columns">
                        <?= $profile->getModifiedDate() ?>
                    </div>
                </div>

                <fieldset class="large-12s columns">
                    <legend>Profile Flags</legend>
                    <input id="chkApproved" type="checkbox" name="chkApproved" value="1"
                        <?php echo($profile->getApproved() == 1 ? 'checked' : ''); ?>/><label
                        for="Approved"><b>Approved</b></label>
                    <input id="chkApproved" type="checkbox" name="chkAccredited" value="1"
                        <?php echo($profile->getAccredited() == 1 ? 'checked' : ''); ?>/><label for="Accredited"><b>Accredited</b></label>
                    <input id="chkDriver" type="checkbox" name="chkDriver" value="1"
                        <?php echo($profile->getDriver() == 1 ? 'checked' : ''); ?>/><label
                        for="Driver"><b>Driver</b></label>
                    <input id="chkBanned" type="checkbox" name="chkApproved" value="1"
                        <?php echo($profile->getBanned() == 1 ? 'checked' : ''); ?>/> <label
                        for="Banned"><b>Banned</b></label>
                </fieldset>
            </fieldset>
        <?php } ?>
        <div class="row collapse">
            <div class="small-5 columns">
                <input class="button" type="submit" name="btnSubmit" value="Update Profile">
            </div>
            <div class="small-5  columns">
                <input class="button" type="reset" value="Reset">
            </div>
        </div>
    </form>
</div>