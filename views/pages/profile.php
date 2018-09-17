<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li class="current">Profile</li>
</ul>
<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 17:37
 *
 * View Profile page
 */


if (isset($_SESSION['update'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Profile Successfully Updated!</h5>
          </div>';
    unset($_SESSION['update']);
}

?>
<div class="small-12 small-centered large-10 large-centered columns">

    <h1 class="pageTitle">Profile</h1>

    <h3>Profile Details</h3>

    <div class="row collapse large-centered">

        <img width=160px; height="160px" ; src="<?= $profile->getPicture(); ?>"/>
    </div>
    <div class="row collapse large-centered">
        <b> <?= $profile->getFullName(); ?></b>
    </div>


    <?php
    //Display Profile fields

    echo($profile->displayField($profile->getUsername(), "Username:"));
    echo($profile->displayField($profile->getCreatedDate(), "Registered Date:"));
    echo($profile->displayField($profile->getModifiedDate(), "Last Modified Date:"));
    echo($profile->displayField($profile->getBio(), "Bio:"));
    echo($profile->displayField($profile->getInterests(), "Interests:"));
    echo($profile->displayLinkField($profile->getLink(), "Facebook/Website:"));
    echo($profile->displayField($roles->displayRole($conn, $profile->getRole()), "Role"));
    echo($profile->displayField($profile->getCertifications(), "Certifications"));

    //Profile Flags
    echo($profile->displayField($profile->displayFlag($profile->isDriver($conn)), "Driver"));
    echo($profile->displayField($profile->displayFlag($profile->isApproved($conn)), "Approved"));
    echo($profile->displayField($profile->displayFlag($profile->isAccredited($conn)), "Accredited"));
    echo($profile->displayField($profile->displayFlag($profile->isBanned($conn)), "Banned:"));
    ?>

    <br/>

    <h3>Competition Results</h3>

    <p>Coming soon...</p>
    <br/>


    <h3>Climbing Log Details</h3>

    <p>Coming soon...</p>

    <a href="/profile/edit/<?= $profile->getUserID() ?>" class="button">Edit Profile</a>



