<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/03/2017
 * Time: 14:32
 * Climbing Logbook - View
 */
?>

<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>climbing_log" role="link">Climbing</a></li>
    <li class="current">View Logbook</li>
</ul>
<?php
echo '<h1 class="pageTitle" >Climbing | View Logbook</h1>';

if (!empty($routeList)) {
    echo '<table style="border 1px;" class="responsive" style=" border:1px; overflow-y: scroll;">
        <tr>

            <th>ID#</th>
            <th>Route Name<br></th>
            <th>Style</th>
            <th>Grade</th>
            <th>View</th>
            <th>Edit</th>
        </tr>';

    foreach ($routeList as $row) {

        $routeItem = new climbing_routes();

        $routeItem->setRouteID($row['routeID']);
        $routeItem->getAllDetails($conn);

        $viewLink = $_SESSION['domain'] . "climbing_log/route/" . $routeItem->getRouteID();
        $editLink = $_SESSION['domain'] . "climbing_log/route/edit/" . $routeItem->getRouteID();
        echo '<tr>';
        echo '<td>' . $routeItem->getLogID() . '</td>';
        echo '<td>' . $routeItem->getRouteName() . '</td>';
        echo '<td>' . $routeItem->displayStyle() . '</td>';
        echo '<td>' . $routeItem->getRouteGrade() . '</td>';
        echo '<td><a href="' . $viewLink . '">View</a></td>';
        echo '<td><a href="' . $editLink . '">Edit</a></td></tr>';
    }
    echo "</table><hr>";
} else {
    echo "No Routes added - add one in the form below. <hr>";
}
?>


<h4 class="pageTitle">Add Route</h4>
<div class="small-12 small-centered large-8 large-centered columns">
    <?php

    if (isset($_SESSION['error'])) {
        echo '<br/>';
        echo '<div class="callout warning">
          <h5>Create Route error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
        unset($_SESSION['error']);
    }

    if (isset($_SESSION['create'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Route Successfully Added!</h5>
          </div>';
        unset($_SESSION['create']);
    }


    if (isset($_SESSION['update'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Route Successfully Updated!</h5>
          </div>';
        unset($_SESSION['update']);
    }


    if (isset($_SESSION['delete'])) {
        echo '<br/>';
        echo '<div class="callout alert">
          <h5>Route Successfully Deleted!</h5>
          </div>';
        unset($_SESSION['delete']);
    }

    echo '<div class="large-12 medium-8 small-12 columns">';
    echo formStart();


    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtTitle"])) {
            echo textInputEmptyError(true, "Route Name", "txtName", "errEmptyName", "Please enter a Route Name", 500);
        } else {
            echo textInputPostback(true, "Route Name", "txtName", $_POST["txtName"], 500);
        }
    } else {
        echo textInputBlank(true, "Route Name", "txtName", 500);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["sltType"])) {
            echo comboInputEmptyError(true, "Route Type", "sltType", "Please select...", "errRouteType", "Please select a Route type", $routeTypes);
        } else {
            echo comboInputPostback(true, "Route Type", "sltType", $_POST["sltType"], $routeTypes);
        }
    } else {
        echo comboInputBlank(true, "Route Type", "sltType", "Please select...", $routeTypes);
    }


    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtTitle"])) {
            echo textInputEmptyError(true, "Route Grade", "txtGrade", "errEmptyGrade", "Please enter a Route Grade", 25);
        } else {
            echo textInputPostback(true, "Route Grade", "txtGrade", $_POST["txtName"], 25);
        }
    } else {
        echo textInputBlank(true, "Route Grade", "txtGrade", 25);
    }

//
//    if (isset($_POST["btnSubmit"])) {
//        echo comboInputPostback(false, "Climbing Partner", "sltPartner", $_POST["sltPartner"], $partnerList);
//    } else {
//        echo comboInputBlank(false, "Role", "sltPartner", "Please select...", $partnerList);
//    }
//

    if (isset($_POST["btnSubmit"])) {
        echo comboInputPostback(false, "Climbing Partner", "sltPartner", $_POST["sltPartner"], $partnerList);
    } else {
        echo comboInputBlank(false, "Climbing Partner", "sltPartner", "Please select...", $partnerList);
    }

    ?>
    <div class="large-8 large-centered medium-8 medium-centered small-12 small-centered columns">
        <input class="button" type="submit" name="btnSubmit" value="Add new Route">
        <input class="button" type="reset" value="Reset">
    </div>
    </form>
</div>
</div>
</div>
</div>
