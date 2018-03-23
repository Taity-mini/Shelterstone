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


echo '<div class="small-6 small-centered large-10 large-centered columns">';

echo '<h1 class="pageTitle">Edit Profile: ' . $profile->getUsername() . '</h1>';

echo formStart();

echo textInputSetup(true, "<i class='fi-torso'></i>", "txtUsername", $profile->getUsername(), 8, true);


if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtEmail"])) {
        echo textInputEmptyError(true, "<span class='prefix'><i class='fi-mail'></i></span>", "txtEmail", "errEmptyEmail", "Please enter a valid email", 250);
    } else {
        echo textInputPostback(true, "<span class='prefix'><i class='fi-mail'></i></span>", "txtEmail", $_POST["txtEmail"], 250);
    }
} else {
    echo textInputSetup(true, "<span class='prefix'><i class='fi-mail'></i></span>", "txtEmail", $profile->getEmail(), 250);
}

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtFirstName"])) {
        echo textInputEmptyError(true, "First Name", "txtFirstName", "errEmptyFName", "Please enter your first name", 60);
    } else {
        echo textInputPostback(true, "First Name", "txtFirstName", $_POST["txtFirstName"], 60);
    }
} else {
    echo textInputSetup(true, "First Name", "txtFirstName", $profile->getFirstName(), 20);
}

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtLastName"])) {
        echo textInputEmptyError(true, "Last Name", "txtLastName", "errEmptyLName", "Please enter your last name", 60);
    } else {
        echo textInputPostback(true, "Last Name", "txtLastName", $_POST["txtLastName"], 60);
    }
} else {
    echo textInputSetup(true, "Last Name", "txtLastName", $profile->getLastName(), 60);
}


if (isset($_POST["btnSubmit"])) {
    echo textInputPostback(false, "Link", "txtLink", $_POST["txtLink"], 255);
} else {
    echo textInputSetup(false, "Link", "txtLink", $profile->getLink(), 255);
}


if (isset($_POST["btnSubmit"])) {
    echo textareaInputPostback(false, "Bio", "txtBio", $_POST["txtBio"], 600, 8);
} else {
    echo textareaInputSetup(false, "Bio", "txtBio", $profile->getBio(), 600, 8);
}

if (isset($_POST["btnSubmit"])) {
    echo textareaInputPostback(false, "Interests", "txtInterests", $_POST["txtInterests"], 100, 2);
} else {
    echo textareaInputSetup(false, "Interests", "txtInterests", $profile->getInterests(), 100, 2);
}


if (isset($_POST["btnSubmit"])) {
    echo textareaInputPostback(false, "Certifications", "txtCertifications", $_POST["txtCertifications"], 500, 2);
} else {
    echo textareaInputSetup(false, "Certifications", "txtCertifications", $profile->getCertifications(), 500, 2);
}


if ($limitedEdit) { ?>

    <input id="chkDriver" type="checkbox" name="chkDriver" value="1"
        <?php echo($profile->getDriver() == 1 ? 'checked' : ''); ?>/><label
            for="Driver"><b>Driver</b></label>
    <?php

//Admin stuff
} else if (!$limitedEdit) {


echo '<fieldset class="fieldset">
                <legend>Admin Stuff</legend>';


//if (isset($_POST["btnSubmit"])) {
//    echo textInputPostback(false, "Role", "txtRole", $_POST["txtLink"], 200);
//} else {
//    echo textInputSetup(false, "Role", "txtRole", $profile->getRole(), 200);
//}

    if (isset($_POST["btnSubmit"])) {
        echo comboInputPostback(true, "Role", "sltRole", $_POST["sltRole"], $roleList);
    } else {
        if (!is_null($profile->getGroupID())) {
            echo comboInputSetup(true, "Role", "sltRole", $profile->getRole(), $roleList);
        } else {
            echo comboInputBlank(true, "Role", "sltRole", "Please select...", $roleList);
        }
    }

//    echo comboInputBlank(true, "Role", "sltRole", "Please select...", $roleList);




    if (isset($_POST["btnSubmit"])) {
        echo comboInputPostback(true, "Group", "sltGroup", $_POST["sltGroup"], $group->listAllGroups($conn));
    } else {
        if (!is_null($profile->getGroupID())) {
            echo comboInputSetup(true, "Group", "sltGroup", $profile->getGroupID(), $group->listAllGroups($conn));
        } else {
            echo comboInputBlank(true, "Group", "sltGroup", "Please select...", $group->listAllGroups($conn));
        }
    }

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
        <input id="chkBanned" type="checkbox" name="chkBanned" value="1"
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
</div>
</div>