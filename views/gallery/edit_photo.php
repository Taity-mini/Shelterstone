<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:37
 * Edit Photo page
 */

if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Photo Update Failed</h5>
          <p>Form incomplete, errors are highlighted below.</p>
          </div>';
    unset($_SESSION['error']);
}

echo '<h1 class="pageTitle">Gallery | Edit Photo ID: '.$photos->getPhotoID().'</h1>';

echo '<div class="small-6 small-centered large-10 large-centered columns">';
echo formStart();



if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtTitle"])) {
        echo textInputEmptyError(true, "Photo Title", "txtTitle", "errEmptyTitle", "Please enter a Photo Title", 20);
    } else {
        echo textInputPostback(true, "Photo Title", "txtTitle", $_POST["txtName"], 20);
    }
} else {
    echo textInputSetup(true, "Photo Title", "txtName",$photos->getTitle(), 20);
}

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtDescription"])) {
        echo textareaInputEmptyError(false, "Photo Description", "txtDescription", "errEmptyDescription", "Please enter a Main Body", 250, 2);
    } else {
        echo textareaInputPostback(false, "Photo Description", "txtDescription", $_POST["txtDescription"], 250, 2);
    }
} else {
    echo textareaInputSetup(false, "Photo Description", "txtDescription", $photos->getDescription(), 250, 2);
}



?>
        <div class="large-12 medium-12 small-12 columns">
                <input class="success button" type="submit" name="btnSubmit" value="Update Photo">
                <input type="submit" name="btnDelete" class="alert button" value="Delete Photo"
                       onclick="return confirm('Are you sure? This WILL delete this photo')">
                <input class="button" type="reset" value="Reset">
        </div>
</form>

</div>
</div>

</div>
</div>
<div class="row ">
    <div class ="small-centered columns">
        <a href="/gallery/photo/<?=$photos->getPhotoID()?>" class="button">Return to photo</a>
    </div>
</div>

