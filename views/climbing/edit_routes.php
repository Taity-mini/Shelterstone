<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:10
 * Climbing Logbook - Edit Routes
 */
?>

<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>climbing_log" role="link">Climbing</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>climbing_log/logbook/<?php echo $logbook->getLogID() ?>" role="link">Logbook</a></li>
    <li class="current">Edit a Climbing Route</li>
</ul>

<h1 class="pageTitle">Climbing:| Edit Route ID: <?= $routeID; ?> </h1>

<?php
if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Update news error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
    unset($_SESSION['error']);
}
echo '<div class="large-12 medium-12 small-12 columns">';
echo formStart();

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtTitle"])) {
        echo textInputEmptyError(true, "Route Name", "txtName", "errEmptyName", "Please enter a Route Name", 500);
    } else {
        echo textInputPostback(true, "Route Name", "txtName", $_POST["txtName"], 500);
    }
} else {
    echo textInputSetup(true, "Route Name", "txtName",$route->getRouteName(), 500);
}





if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["sltStyle"])) {
        echo comboInputEmptyError(true, "Route Style", "sltStyle", "Please select...", "errRouteStyle", "Please select a Route Style", $routeStyles);
    } else {
        echo comboInputPostback(true, "Route Style", "sltStyle", $_POST["sltStyle"], $routeStyles);
    }
} else {

    echo comboInputSetup(true, "Route Style", "sltStyle", $route->getRouteStyle(), $route->listStyles());
}




if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtName"])) {
        echo textInputEmptyError(true, "Route Grade", "txtGrade", "errEmptyTitle", "Please enter a Route Grade", 25);
    } else {
        echo textInputPostback(true, "Route Grade", "txtGrade", $_POST["txtGrade"], 25);
    }
} else {
    echo textInputSetup(true, "Route Grade", "txtGrade", $route->getRouteGrade(), 25);
}



if (isset($_POST["btnSubmit"])) {
    echo comboInputPostback(false, "Climbing Partner", "sltPartner", $_POST["sltPartner"], $partnerList);
} else {
    if (!is_null($route->getPartnerID())) {
        echo comboInputSetup(false, "Climbing Partner", "sltPartner", $route->getPartnerID(), $partnerList);
    } else {
        echo comboInputBlank(false, "Climbing Partner", "sltPartner", "Please select...", $partnerList);
    }
}



?>
<div class="large-8 text-center medium-8 medium-centered small-12 small-centered columns">
    <input class="button success" type="submit" name="btnSubmit" value="Update Logbook">
    <input type="submit" name="btnDelete" class="alert button" value="Delete Location"
           onclick="return confirm('Are you sure? This WILL delete this climbing location.')">
    <input class="button" type="reset" value="Reset">
</div>
<a href="javascript: history.go(-1)" class="button">Go Back</a>
</form>
</div>
</div>
</div>


