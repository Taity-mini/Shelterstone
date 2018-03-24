<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 15:53
 * Climbing Locations - Edit
 */
?>
<h1 class="pageTitle" >Climbing |Location Edit</h1>


<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>climbing_log" role="link">Climbing</a></li>
    <li class="current">Edit a Climbing Location</li>
</ul>

<h1 class="pageTitle">Edit Climbing ID: <?= $location->getLocationID(); ?> </h1>

<?php
echo formStart();
if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Update location error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
    unset($_SESSION['error']);
}


if (isset($_SESSION['inUse'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Delete Error - Location in Use!</h5>
          <p>This location is used by at least one logbook, so it can not be deleted.</p>
          </div>';
    unset($_SESSION['inUse']);
}

echo '<div class="large-12 medium-12 small-12 columns">';

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtName"])) {
        echo textInputEmptyError(true, "Location Name", "txtName", "errEmptyTitle", "Please enter a Location Name", 100);
    } else {
        echo textInputPostback(true, "Location Name", "txtName", $_POST["txtName"], 100);
    }
} else {
    echo textInputSetup(true, "Location Name", "txtName", $location->getLocationName(), 100);
}

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtDescription"])) {
        echo textareaInputEmptyError(true, "Location Description", "txtDescription", "errEmptyBody", "Please enter a Location Description", 600, 5);
    } else {
        echo textareaInputPostback(true, "Location Description", "txtDescription", $_POST["txtDescription"], 600, 5);
    }
} else {
    echo textareaInputSetup(true, "Location Description", "txtDescription", $location->getLocationDescription(), 600, 5);
}


?>
<div class="large-5 large-centered medium-8 medium-centered small-12 small-centered columns">
    <div class="row">
        <input class="success button" type="submit" name="btnUpdate" value="Update Location">
        <input type="submit" name="btnDelete" class="alert button" value="Delete Location"
               onclick="return confirm('Are you sure? This WILL delete this climbing location.')">
        <input class="button" type="reset" value="Reset">
    </div>
    </form>
</div>
<a href="javascript: history.go(-1)" class="button">Go Back</a>

</div>