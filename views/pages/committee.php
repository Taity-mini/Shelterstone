<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:16
 * List current committee members of shelterstone
 */
?>

<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>about/club_information" role="link">About</a></li>
    <li class="current">Club Committee</li>
</ul>
<div class="small-12 small-centered large-12 large-centered columns">
<h1 class="pageTitle" >Committee</h1>

<p>The committee for the current session: <br/>
<div class="small-6 small-centered text-center columns">
    <input id="revealEmails" class="button text-center" type="button" value="Reveal Emails"/>
</div>
</p>

<?php

//foreach ($committeeList as $item=>$value) {
//
//    $userID = (int)$value['userID'];
//    $members = new users();
//    $members->setUserID($userID);
//    $members->getallDetails($conn);
//
//    for($i = 0; $i <3; $i++){
//        echo '<div class="large-4 medium-6 small-12 columns text-left">';
//        echo '<div class ="row">';
//        echo '  <img width=160px; height="160px"; src="'.$members->getPicture().'"/></br>';
//        echo "<b>Name:</b> " . $members->getFullName() . "</br>";
//        echo "<b>Role:</b> " . $members->getRole() . "</br>";
//        echo '</div></br>';
//        echo '</div>';
//    }
//
//
//}

$role = new roles();
$member = new users();

foreach ($committeeList as $item =>$value) {
    $role->setRoleID($item);
    $role->getAllDetails($conn);

    echo '<div class="large-4 medium-6 small-12 columns centre">';
    echo '<h4>' . $role->getRole() . '</h4>';
    foreach ($value as $thing) {
        $member->setUserID($thing);
        $member->getAllDetails($conn);

        //Set to default picture if null
        if($member->getPicture() == null)
        {
            $member->setPicture($_SESSION['domain'].'/img/profile.png');
        }

        echo '<img width=160px; height="160px"; src="'.$member->getPicture().'"/></br>';
        echo "<span class='h3'><b>Name:</b> " . $member->getFullName() . "</span></br>";
    }

    if (!empty($role->getEmail())) {
        echo '<div class="emailHider"><a href="mailto:' . myobfiscate($role->getEmail()) . '"/>' . myobfiscate($role->getEmail()) . '</a></div>';
    }
    echo '</div>';
}

?>
<script type="text/javascript" async src="<?php echo $_SESSION['domain'] ?>js/functions.js"></script>
</div>

