<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 05/08/2017
 * Time: 21:11
 */

?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href=".<?php echo $_SESSION['domain'] ?>files" role="link">Files</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>files/view/<?= $files->getFileID() ?>" role="link">View File</a></li>
    <li class="current">Edit File</li>
</ul>

<div class="row" id="content">
    <div class="large-12 medium-12 small-12 columns">

        <?php

        if (isset($_SESSION['error'])) {
            echo '<br/>';
            echo '<div class="callout warning">
          <h5>File Update Failed</h5>
          <p>Form incomplete, errors are highlighted below.</p>
          </div>';
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['errorDelete'])) {
            echo '<br/>';
            echo '<div class="callout warning">
          <h5>File deletion failed</h5>
          <p>Form incomplete, errors are highlighted below.</p>
          </div>';
            unset($_SESSION['errorDelete']);
        }

        if (isset($_SESSION['upload'])) {
            echo '<p class="alert-box success radius centre">File uploaded successfully!</p>';
            unset($_SESSION['upload']);
        }

        ?>
        <h2 class="pageTitle">Files | Edit file: <?= $files->getTitle() ?></h2>

        <div class="small-6 small-centered large-10 large-centered columns">
            <form action="" method="post">
                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label>
                            <span><b>File Title</b></span>
                            <input type="text" id="txtName" name="txtTitle" maxlength="20"
                                   value="<?= $files->getTitle() ?>"/>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label>
                            <span><b>Album Description</b></span>
                            <textarea id="txtDescription" name="txtDescription" rows="4"
                                      maxlength="250"><?= $files->getDescription() ?></textarea>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label><b>
                                <span class="required">* </span>Visibility (Publicly accessible?)</b>
                            <input type='hidden' value='0' name='chkVisibility'/>
                            <input id="chkVisibility" type="checkbox" name="chkVisibility"
                                   value="1" <?php echo($files->getVisibility() == 1 ? 'checked' : ''); ?>/>

                        </label>
                    </div>
                </div>

                <div class="large-12 medium-12 small-12 columns">
                    <div class="row">
                        <input class="success button" type="submit" name="btnSubmit" value="Update File">
                        <input type="submit" name="btnDelete" class="alert button" value="Delete File"
                               onclick="return confirm('Are you sure? This WILL delete this file from database and web server')">
                    </div>
                    <div class="row">
                        <input class="button" type="reset" value="Reset">
                    </div>
                </div>
        </div>
        </form>
    </div>
