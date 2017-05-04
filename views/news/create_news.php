<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 23:53
 * Create news article
 */

if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Create news error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
    unset($_SESSION['error']);
}

?>
<h1 class="pageTitle">Create news article</h1>

<div class="small-6 small-centered large-10 large-centered columns">
    <form method="post">
        <p class="required">* indicates a required field</p>
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>News Title</b>
                    <input type="text" id="txtTitle" name="txtTitle" maxlength="100" placeholder="Enter a title"/>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Main Body</b>
                    <textarea id="txtBody" name="txtBody"  placeholder="Enter Content" rows="10" maxlength="5000"></textarea>
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
                        <option value="2">Announcements</option>
                        <option value="3">Competitions</option>
                        <option value="4">Events</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Visibility</b>
                    <select id="sltVisibility" name="sltVisibility">
                        <option value="" selected="selected">Please select...</option>
                        <option value="1">Committee</option>
                        <option value="2">Members</option>
                        <option value="3">Public</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                <input class="button" type="submit" name="btnSubmit" value="Create news">
                <input class="button" type="reset" value="Reset">
        </div>
    </form>
</div>
