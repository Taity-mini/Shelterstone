<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:09
 * Climbing Logbook List
 */
?>

<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li class="current">Climbing</li>
</ul>
<?php
echo '<h1 class="pageTitle" >Climbing |Logbook List</h1>';

if ($logbookList !=null) {
    echo '<table style="border 1px;" class="fileTable" style=" border:1px; overflow-y: scroll;">
        <tr>

            <th>ID#</th>
            <th>Location<br></th>
            <th>Type</th>
            <th>Date</th>
            <th>View</th>
            <th>Edit</th>
        </tr>';

    foreach ($logbookList as $row) {

        $logbookItem = new climbing_logbooks();

        $logbookItem->setLogID($row['logID']);
        $logbookItem->getAllDetails($conn);

        $locationItem = new climbing_locations();
        $locationItem->setLocationID($row['locationID']);
        $locationItem->getAllDetails($conn);
        $viewLink = $_SESSION['domain'] . "climbing_log/logbook/" . $logbookItem->getLogID();
        $editLink = $_SESSION['domain'] . "climbing_log/logbook/edit/" . $logbookItem->getLogID();
        echo '<tr>';
        echo '<td>'.$logbookItem->getLogID().'</td>';
        echo '<td>'.$locationItem->getLocationName().'</td>';
        echo '<td>'.$logbookItem->displayType().'</td>';
        echo '<td>'.$logbookItem->getFormattedDate().'</td>';
        echo '<td><a href="'.$viewLink.'">View</a></td>';
        echo '<td><a href="'.$editLink.'">Edit</a></td></tr>';
    }
    echo "</table><hr>";
} else {
    echo "No lo added - add one in the form below. <hr>" ;
}
?>



<h4 class="pageTitle">Create Logbook</h4>
<div class="small-6 small-centered large-10 large-centered columns">
    <?php

    if (isset($_SESSION['error'])) {
        echo '<br/>';
        echo '<div class="callout warning">
          <h5>Create logbook error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['create'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Logbook Successfully Added!</h5>
          </div>';
        unset($_SESSION['create']);
    }


    if (isset($_SESSION['update'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Logbook Successfully Updated!</h5>
          </div>';
        unset($_SESSION['update']);
    }


    if (isset($_SESSION['delete'])) {
        echo '<br/>';
        echo '<div class="callout alert">
          <h5>Logbook Successfully Deleted!</h5>
          </div>';
        unset($_SESSION['delete']);
    }

    echo '<div class="large-12 medium-12 small-12 columns">';
    echo formStart();

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["sltLocation"])) {
            echo comboInputEmptyError(true, "Location", "sltLocation", "Please select...", "errEmptVisibility", "Please select a Climbing Location", $locationList);
        } else {
            echo comboInputPostback(true, "Location", "sltLocation", $_POST["sltLocation"],$locationList);
        }
    } else {
        echo comboInputBlank(true, "Location", "sltLocation", "Please select...", $locationList);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["sltType"])) {
            echo comboInputEmptyError(true, "Logbook Type", "sltType", "Please select...", "errEmptVisibility", "Please select a Logbook type",  $logbookTypes);
        } else {
            echo comboInputPostback(true, "Logbook Type", "sltType", $_POST["sltLocation"], $logbookTypes);
        }
    } else {
        echo comboInputBlank(true, "Logbook Type", "sltType", "Please select...",  $logbookTypes);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtDate"])) {
            echo dateInputEmptyError(true, "Logbook Date", "txtDate", "errEmptyDOB", "Please enter a Logbook Date", null, date("Y-m-d"));
        } else {
            echo dateInputPostback(true, "Logbook Date", "txtDate", $_POST["txtDate"], null, date("Y-m-d"));
        }
    } else {
        echo dateInputBlank(true, "Logbook Date", "txtDate", null, date("Y-m-d"));
    }

    if (isset($_POST["btnSubmit"])) {
            echo textareaInputPostback(false, "Notes", "txtNotes", $_POST["txtNotes"], 250, 4);
    } else {
        echo textareaInputBlank(false, "Notes", "txtNotes", 250, 4);
    }


    ?>
    <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
        <input class="button" type="submit" name="btnSubmit" value="Create new Logbook">
        <input class="button" type="reset" value="Reset">
    </div>
    </form>
</div>
</div>
</div>
</div>