<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:34
 * Create new album
 */

if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout alert">
          <h5>Create album error!</h5>
          <p>One or more fields was not filled in, please try again!</p>
          </div>';
    unset($_SESSION['error']);
}

?>
<h1 class="pageTitle">Gallery | Create album</h1>

<div class="small-6 small-centered large-10 large-centered columns">
    <?php

    echo formStart();
    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtName"])) {
    echo textInputEmptyError(true, "Album Name", "txtName", "errEmptyTitle", "Please enter a Album Name", 50);
    } else {
        echo textInputPostback(true, "Album Name", "txtName", $_POST["txtName"], 50);
    }
    } else {
        echo textInputBlank(true, "Album Name", "txtName", 50);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtDescription"])) {
            echo textareaInputEmptyError(true, "Album Description", "txtDescription", "errEmptyBody", "Please enter a album description", 250, 4);
        } else {
            echo textareaInputPostback(true, "Album Description", "txtDescription", $_POST["txtDescription"], 250, 4);
        }
    } else {
        echo textareaInputBlank(true, "Album Description", "txtDescription", 250, 4);
    }


    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["sltType"])) {
            echo comboInputEmptyError(true, "Type", "sltType", "Please select...", "errEmptyType", "Please select a Type", $albums->listTypes());
        } else {
            echo comboInputPostback(true, "Type", "sltType", $_POST["sltType"], $albums->listTypes());
        }
    } else {
        echo comboInputBlank(true, "Type", "sltType", "Please select...",  $albums->listTypes());
    }

//    $types = array(
//        1  => "Publicly accessible?",
//    );
//
//    if (isset($_POST["btnSubmit"])) {
//            echo checkboxInputPostback(false, "Visibility", "chkVisibility", $_POST['chkVisibility'], $types);
//
//    } else {
//        echo checkboxInputBlank(false, "Visibility", "chkVisibility",$types);
//    }

    echo'   
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Visibility (Publicly accessible?)</b>
                    <input type=\'hidden\' value=\'0\' name=\'chkVisibility\'/>
                    <input id="chkApproved" type="checkbox" name="chkVisibility" value="1"/>
                </label>
            </div>';

    echo formEndWithButton("Add album", false , "../gallery/");

    ?>

</div>