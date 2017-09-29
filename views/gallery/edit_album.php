<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:35
 * Edit Album page
 */

if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Profile Update Failed</h5>
          <p>Form incomplete, errors are highlighted below.</p>
          </div>';
    unset($_SESSION['error']);
}

echo '<div class="small-6 small-centered large-10 large-centered columns">';

echo '<h1 class="pageTitle" >Gallery | Edit album: '.$albums->getAlbumName().'</h1>';

echo formStart();


    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtName"])) {
            echo textInputEmptyError(true, "Album Name", "txtName", "errEmptyTitle", "Please enter a Album Name", 100);
        } else {
            echo textInputPostback(true, "Album Name", "txtName", $_POST["txtName"], 100);
        }
    } else {
        echo textInputSetup(true, "Album Name", "txtName",$albums->getAlbumName(), 100);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtDescription"])) {
            echo textareaInputEmptyError(true, "Album Description", "txtDescription", "errEmptyDescription", "Please enter a Main Body", 250, 4);
        } else {
            echo textareaInputPostback(true, "Album Description", "txtDescription", $_POST["txtDescription"], 250, 4);
        }
    } else {
        echo textareaInputSetup(true, "Album Description", "txtDescription", $albums->getAlbumDescription(), 250, 4);
    }


    if (isset($_POST["btnSubmit"])) {
        echo comboInputPostback(true, "Type", "sltType", $_POST["sltType"], $albums->listTypes());
    } else {
        if (!is_null($albums->getType())) {
            echo comboInputSetup(true, "Type", "sltType", $albums->getType(), $albums->listTypes());
        } else {
            echo comboInputBlank(true, "Type", "sltType", "Please select...", $albums->listTypes());
        }
    }


?>
        <?php
            if(!$limitedAccess)
            {
        ?>

            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Visibility (Publicly accessible?)</b>
                    <input type='hidden' value='0' name='chkVisibility'/>
                    <input id="chkVisibility" type="checkbox" name="chkVisibility" value="1"  <?php echo($albums->getVisibility() == 1 ? 'checked' : ''); ?>/>

                </label>
            </div>
        <?php }?>
        <div class="large-12 medium-12 small-12 columns" style="margin-left: auto; margin-right: auto">

                <input class="success button" type="submit" name="btnSubmit" value="Update Album">
                <input type="submit" name="btnDelete" class="alert button" value="Delete Album"
                       onclick="return confirm('Are you sure? This WILL delete this album and all the photos in it.')">
            <input class="button" type="reset" value="Reset">
            </div>


</div>
</form>
</div>