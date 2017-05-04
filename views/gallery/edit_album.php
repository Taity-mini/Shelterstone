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

?>
<h1 class="pageTitle" >Gallery | Edit album: <?=$albums->getAlbumName()?></h1>

<div class="small-6 small-centered large-10 large-centered columns">
    <form action="" method="post">
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Album Name</b></span>
                    <input type="text" id="txtName" name="txtName" maxlength="20" value="<?=$albums->getAlbumName()?>"/>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Album Description</b></span>
                    <textarea id="txtDescription" name="txtDescription" rows="4" maxlength="250"><?=$albums->getAlbumDescription()?></textarea>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Type</b>
                    <select id="sltType" name="sltType">
                        <option value="1" <?= ($albums->getType() == 1) ? "selected" : ""; ?> >Standard</option>
                        <option value="2" <?= ($albums->getType() == 2) ? "selected" : ""; ?>  >Personal</option>
                        <option value="3" <?= ($albums->getType() == 3) ? "selected" : ""; ?> >Competitions</option>
                        <option value="4" <?= ($albums->getType() == 4) ? "selected" : ""; ?> >Events</option>
                    </select>
                </label>
            </div>
        </div>


        <?php
            if(!$limitedAccess)
            {
        ?>
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Visibility (Publicly accessible?)</b>
                    <input type='hidden' value='0' name='chkVisibility'/>
                    <input id="chkVisibility" type="checkbox" name="chkVisibility" value="1"  <?php echo($albums->getVisibility() == 1 ? 'checked' : ''); ?>/>

                </label>
            </div>
        </div>
        <?php }?>

        <div class="large-12 medium-12 small-12 columns">
            <div class="row">
                <input class="success button" type="submit" name="btnSubmit" value="Update Album">
                <input type="submit" name="btnDelete" class="alert button" value="Delete Album"
                       onclick="return confirm('Are you sure? This WILL delete this album and all the photos in it.')">
            </div>
            <div class="row">
                <input class="button" type="reset" value="Reset">
            </div>
        </div>
</div>
</form>
</div>