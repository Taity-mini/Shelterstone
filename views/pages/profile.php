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



<h1 class="pageTitle" >Profile</h1>

<h3>Profile Details</h3>
<p>User's profile: <?=$profile->getUsername()?></p>

<label>
    <img src="<?= $_SESSION['domain']?>/img/profile.png"/>
   <b> <?= $profile->getFullName(); ?></b>
</label>
<label>
    Bio:
    <?= $profile->getBio(); ?>
</label>
<label>
    Interests:
    <?= $profile->getInterests(); ?>
</label>
<label>
    Role:
    <?= $profile->getRole(); ?>
</label>

<h3>Competition Results</h3>

<h3>Climbing Log Details</h3>

<a href="/profile/edit/<?=$profile->getUserID()?>" class="button">Edit Profile</a>



