<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 23:54
 * Edit news article
 */
?>
<h1 class="pageTitle">Edit News ID: <?= $newsArticle->getNewsID(); ?> </h1>

<div class="large-12 medium-12 small-12 columns">
    <form method="post">


        <p class="required">* indicates a required field</p>
        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>News Title</b>
                    <input type="text" id="txtTitle" name="txtTitle" maxlength="100"
                           value="<?= $newsArticle->getTitle(); ?>"/>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Main Body</b>
                    <textarea id="txtBody" name="txtBody" rows="10" maxlength="5000"><?= $newsArticle->getMainBody(); ?></textarea>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Visibility</b>
                    <select id="sltType" name="sltType">
                        <option value="1" <?= ($newsArticle->getType() == 1) ? "selected" : ""; ?>>Standard</option>
                        <option value="2" <?= ($newsArticle->getType() == 2) ? "selected" : ""; ?>>Announcements</option>
                        <option value="3" <?= ($newsArticle->getType() == 3) ? "selected" : ""; ?>>Competitions</option>
                        <option value="4" <?= ($newsArticle->getType() == 4) ? "selected" : ""; ?>>Events</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="large-12 medium-12 small-12 columns">
                <label><b>
                        <span class="required">* </span>Type</b>
                    <select id="sltVisibility" name="sltVisibility">
                        <option value="1" <?= ($newsArticle->getVisibility() == 1) ? "selected" : ""; ?>>Committee
                        </option>
                        <option value="2" <?= ($newsArticle->getVisibility() == 2) ? "selected" : ""; ?>>Members
                        </option>
                        <option value="3" <?= ($newsArticle->getVisibility() == 3) ? "selected" : ""; ?>>Public</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
            <div class="row">
                <input class="success button" type="submit" name="btnUpdate" value="Update News">
                <input type="submit" name="btnDelete" class="alert button" value="Delete News Article"
                       onclick="return confirm('Are you sure? This WILL delete this news article.')">
            </div>
            <div class="row">
                <input class="button" type="reset" value="Reset">
            </div>

        </div>
    </form>
</div>
