<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/09/2017
 * Time: 21:38
 * Add freshers
 */


?>

<div class="small-6 small-centered large-10 large-centered columns">

    <?php


    if(!isset($_SESSION['create'])) {
        echo ' <h1 class="pageTitle">Welcome Fresher!</h1>';

        if (isset($_SESSION['error'])) {
            echo '<br/>';
            echo '<div class="callout warning">
          <h5>Add fresher error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
            unset($_SESSION['error']);
        }

        echo '<div class="large-12 medium-12 small-12 columns">';
        echo formStart();
        if (isset($_POST["btnSubmit"])) {
            if (empty($_POST["txtFirstName"])) {
                echo textInputEmptyError(true, "First Name", "txtFirstName", "errEmptyTitle", "Please enter your first name", 60);
            } else {
                echo textInputPostback(true, "First Name", "txtFirstName", $_POST["txtFirstName"], 60);
            }
        } else {
            echo textInputBlank(true, "First Name", "txtFirstName", 60);
        }

        if (isset($_POST["btnSubmit"])) {
            if (empty($_POST["txtLastName"])) {
                echo textInputEmptyError(true, "Last Name", "txtLastName", "errEmptyLName", "Please enter your last name", 60);
            } else {
                echo textInputPostback(true, "Last Name", "txtLastName", $_POST["txtLastName"], 60);
            }
        } else {
            echo textInputBlank(true, "Last Name", "txtLastName", 60);
        }

        if (isset($_POST["btnSubmit"])) {
            if (empty($_POST["txtEmailName"])) {
                echo textInputEmptyError(true, "Email", "txtEmail", "errEmptyEmail", "Please enter your email address", 250);
            } else {
                echo textInputPostback(true, "Email", "txtEmail", $_POST["txtEmail"], 250);
            }
        } else {
            echo textInputBlank(true, "Email", "txtEmail", 250);
        }

        if (isset($_POST["btnSubmit"])) {
            echo textInputPostback(false, "Student ID", "txtStudentID", $_POST["txtStudentID"], 10);
        } else {
            echo textInputBlank(false, "Student ID", "txtStudentID", 10);
        }


        if (isset($_POST["btnSubmit"])) {
            if (empty($_POST["sltLevel"])) {
                echo comboInputEmptyError(true, "Climbing Experience/Level", "sltLevel", "Please select...", "errEmptyLevel", "Please select your climbing experience level ", $freshers->listClimbingLevels());
            } else {
                echo comboInputPostback(true, "Climbing Experience/Level", "sltLevel", $_POST["sltLevel"], $freshers->listClimbingLevels());
            }
        } else {
            echo comboInputBlank(true, "Climbing Experience/Level", "sltLevel", "Please select...", $freshers->listClimbingLevels());
        }


        ?>

        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
            <input class="button" type="submit" name="btnSubmit" value="Welcome Aboard!">
            <input class="button" type="reset" value="Reset">
        </div>
        </form>
        <?php
    }

    if (isset($_SESSION['create'])) {
        echo '<br/>';
        echo '<div class="callout success">
          <h5>Fresher successfully added!</h5>
          <p>We will see you on Monday 7pm @ RGU Sport - Climbing Wall!</p>
          </div>';
        echo linkButton("Add new fresher", '../freshers/add', false);
        unset($_SESSION['create']);
    }
    ?>
</div>
</div>
</div>




