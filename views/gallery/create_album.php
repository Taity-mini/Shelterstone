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
    unset($_SESSION['Error']);
}

?>
<h1 class="pageTitle">Gallery | Create album</h1>

<div class="small-6 small-centered large-10 large-centered columns">
    <form action="" method="post">
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Album Name</b></span>
                    <input type="text" id="txtName" name="txtName" maxlength="20"/>
                </label>
            </div>
        </div>


        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Album Description</b></span>
                    <textarea id="txtDescription" name="txtDescription" rows="4" maxlength="250"></textarea>
                </label>
            </div>
        </div>


        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Type</b>
                    <select id="sltType" name="sltType">
                        <option value="" selected="selected">Please select...</option>
                        <option value="1">Standard</option>
                        <option value="2">Personal</option>
                        <option value="3">Competitions</option>
                        <option value="4">Events</option>
                    </select>
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
                    <input class="success button" type="submit" name="btnSubmit" value="Add Album">
                    <input class="button" type="reset" value="Reset">
                </div>
            </div>
        </div>
    </form>
</div>