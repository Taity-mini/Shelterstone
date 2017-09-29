<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 05/08/2017
 * Time: 21:11
 * File upload page
 */
?>

<div class="row" id="content">
    <div class="large-12 medium-12 small-12 columns">

        <ul class="breadcrumbs">
            <li><a href="../index.php" role="link">Home</a></li>
            <li><a href="../files/" role="link">Files</a></li>
            <li class="current">Upload File</li>
        </ul>
        <h2 class="text-center">Upload File</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<br/>';
            echo '<div class="callout alert">
          <h5>Upload file error!</h5>
          <p>One or more fields was not filled in, please try again!</p>
          </div>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post" style="text-align: center"
              enctype="multipart/form-data">
            <div class="small-6 small-centered large-10 large-centered columns">
                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label>
                            <span><b>File Title</b></span>
                            <input type="text" id="txtTitle" name="txtTitle" maxlength="20"/>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label>
                            <span><b>File Description</b></span>
                            <textarea id="txtDescription" name="txtDescription" rows="2" maxlength="250"></textarea>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label>
                            <span><b>Choose a file</b></span>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </label>
                    </div>
                </div>


                <div class="row">
                    <div class="large-12 medium-12 small-12 columns">
                        <label><b>
                                <span class="required">* </span>Visibility (Publicly accessible?)</b>
                            <input type='hidden' value='0' name='chkVisibility'/>
                            <input id="chkApproved" type="checkbox" name="chkVisibility" value="1"/>
                        </label>
                    </div>
                </div>

                <div class="large-12 medium-12 small-12 columns">
                    <div class="row">
                        <input class="success button" type="submit" name="btnSubmit" value="Add File">
                        <input class="button" type="reset" value="Reset">
                    </div>
                </div>

        </form>
    </div>