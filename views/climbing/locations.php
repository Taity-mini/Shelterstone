<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:08
 * Climbing Logbook - Locations
 */
?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>climbing_log" role="link">Climbing</a></li>
    <li class="current">Locations</li>
</ul>
<div class="small-6 small-centered large-10 large-centered columns">
<h1 class="pageTitle" >Climbing |Locations</h1>

<h3>List</h3>
    <?php

    if (isset($_SESSION['update'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Location Successfully Updated!</h5>
          </div>';
        unset($_SESSION['update']);
    }

    if (isset($_SESSION['create'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Location Successfully Added!</h5>
          </div>';
        unset($_SESSION['create']);
    }

    if (isset($_SESSION['delete'])) {
        echo '<br/>';
        echo '<div class="callout alert">
          <h5>Location Successfully Deleted!</h5>
          </div>';
        unset($_SESSION['delete']);
    }



    if ($locationsList !=null) {
        echo '<table style="border 1px;" class="fileTable" style=" border:1px; overflow-y: scroll;">
        <tr>

            <th>ID#</th>
            <th>Location Name<br></th>
            <th>Location Description</th>
            <th>Edit</th>
        </tr>';

        foreach ($locationsList as $row) {
            $locationItem = new climbing_locations();
            $locationItem->setLocationID($row['locationID']);
            $locationItem->getAllDetails($conn);
            $editLink = $_SESSION['domain'] . "climbing_log/locations/edit/" . $locationItem->getLocationID();
            echo '<tr>';
            echo '<td>'.$locationItem->getLocationID().'</td>';
            echo '<td>'.$locationItem->getLocationName().'</td>';
            echo '<td>'.$locationItem->getLocationDescription().'</td>';
            echo '<td><a href="'.$editLink.'">Edit</a></td></tr>';
        }
        echo "</table><hr>";
    } else {
        echo "No locations added - add one in the form below. <hr>" ;
    }


echo '<h3>Create Location</h3>';



    if (isset($_SESSION['error'])) {
        echo '<br/>';
        echo '<div class="callout warning">
          <h5>Create location error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
        unset($_SESSION['error']);
    }

    echo '<div class="large-12 medium-12 small-12 columns">';
    echo formStart();
    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtTitle"])) {
            echo textInputEmptyError(true, "Location Name", "txtName", "errEmptyTitle", "Please enter a Location Name", 100);
        } else {
            echo textInputPostback(true, "Location Name", "txtName", $_POST["txtName"], 500);
        }
    } else {
        echo textInputBlank(true, "Location Name", "txtName", 500);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtMainBody"])) {
            echo textareaInputEmptyError(true, "Location Description", "txtDescription", "errEmptyBody", "Please enter a Location Description", 600, 5);
        } else {
            echo textareaInputPostback(true, "Location Description", "txtDescription", $_POST["txtMainBody"], 600, 5);
        }
    } else {
        echo textareaInputBlank(true, "Location Description", "txtDescription", 600, 5);
    }

    ?>

    <div class="large-8 large-centered medium-8 medium-centered small-12 small-centered columns">
        <input class="button success" type="submit" name="btnSubmit" value="Add Location">
        <input class="button" type="reset" value="Reset">
    </div>
    <a href="javascript: history.go(-1)" class="button">Go Back</a>
    </form>
</div>
</div>
</div>
</div>
</div>
