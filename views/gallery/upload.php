<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:05
 * Upload Photo to gallery page
 */
?>
<h1 class="pageTitle">Gallery | Upload</h1>


<form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post" style="text-align: center"
      enctype="multipart/form-data">
    <div class="small-6 small-centered large-10 large-centered columns">
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>Choose an album to upload to:</b></span>
                    <?php

                    echo '<select id="sltAlbum" name="sltAlbum">';
                    foreach ($albumList as $key => $value) {

                        if (isset($_SESSION['albumUpload']) && $key == $_SESSION['albumUpload']) {
                            echo '<option selected  value="' . $key . '">' . $value . '</option>';
                            unset($_SESSION['albumUpload']);
                        } else {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                        }
                    }
                    echo '</select>';
                    ?>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Photo Title</b></span>
                    <input type="text" id="txtTitle" name="txtTitle" maxlength="20"/>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Photo Description</b></span>
                    <textarea id="txtDescription" name="txtDescription" rows="2" maxlength="250"></textarea>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Choose a photo</b></span>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </label>
            </div>
        </div>

        <div class="large-12 medium-12 small-12 columns">
            <div class="row">
                <input class="success button" type="submit" name="btnSubmit" value="Add Photo">
                <input class="button" type="reset" value="Reset">
            </div>
        </div>

</form>
</div>