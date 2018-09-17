<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 24/03/2018
 * Time: 19:24
 */

?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>climbing_log" role="link">Climbing</a></li>
    <li class="current">Edit a Climbing Logbook</li>
</ul>

<h1 class="pageTitle">Edit Logbook ID: <?= $logID; ?> </h1>

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
    echo comboInputPostback(true, "Location", "sltLocation", $_POST["sltLocation"], $locationList);
} else {
    if (!is_null($logbook->getLocationID())) {
        echo comboInputSetup(true, "Location", "sltLocation", $logbook->getLocationID(), $locationList);
    } else {
        echo comboInputBlank(true, "Location", "sltLocation", "Please select...", $locationList);
    }
}



if (isset($_POST["btnSubmit"])) {
    echo comboInputPostback(true, "Logbook Type", "sltType", $_POST["sltLocation"], $logbookTypes);
} else {
    if (!is_null($logbook->getLogType())) {
        echo comboInputSetup(true, "Logbook Type", "sltType", $logbook->getLogType(), $logbookTypes);
    } else {
        echo comboInputBlank(true, "Logbook Type", "sltType", "Please select...",  $logbookTypes);
    }
}



if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtDate"])) {
        echo dateInputEmptyError(true, "Logbook Date", "txtDate", "errEmptyDOB", "Please enter a Logbook Date", null, date("Y-m-d"));
    } else {
        echo dateInputPostback(true, "Logbook Date", "txtDate", $_POST["txtDate"], null, date("Y-m-d"));
    }
} else {
     echo dateInputSetup(true, "Logbook Date", "txtDate", $logbook->getDate(), null, date("Y-m-d"));
}


if (isset($_POST["btnSubmit"])) {
    echo textareaInputPostback(false, "Notes", "txtNotes", $_POST["txtNotes"], 250, 4);
} else {
    echo textareaInputSetup(false, "Notes", "txtNotes", $logbook->getNotes(), 250, 4);
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


