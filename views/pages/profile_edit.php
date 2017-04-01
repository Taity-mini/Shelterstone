<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 17:37
 * Edit user's profile
 */

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
        </fieldset>

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