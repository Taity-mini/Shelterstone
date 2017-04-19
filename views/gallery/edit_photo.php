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

?>
<h1 class="pageTitle">Gallery | Edit Photo ID: <?=$photos->getPhotoID()?></h1>

<form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post" style="text-align: center"
      enctype="multipart/form-data">
    <div class="small-6 small-centered large-10 large-centered columns">
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Photo Title</b></span>
                    <input type="text" id="txtTitle" name="txtTitle" maxlength="20" value="<?=$photos->getTitle()?>"/>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Photo Description</b></span>
                    <textarea id="txtDescription" name="txtDescription" rows="2" maxlength="250"><?=$photos->getDescription()?></textarea>
                </label>
            </div>
        </div>
        <div class="large-12 medium-12 small-12 columns">
            <div class="row">
                <input class="success button" type="submit" name="btnSubmit" value="Update Photo">
                <input type="submit" name="btnDelete" class="alert button" value="Delete Photo"
                       onclick="return confirm('Are you sure? This WILL delete this photo')">
                <input class="button" type="reset" value="Reset">
            </div>
        </div>
</form>

</div>
<div class="row ">
    <div class ="small-centered columns">
        <a href="/gallery/photo/<?=$photos->getPhotoID()?>" class="button">Return to photo</a>
    </div>
</div>

