<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 23:54
 * Edit news article
 */


?>
<script>
    tinymce.init({
        selector: '#txtMainBody',
        plugins: 'advlist, table, autolink, code, contextmenu, imagetools, fullscreen, hr,  colorpicker, preview, spellchecker, link, autosave, lists, visualblocks'
    });
</script>

<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>news" role="link">News</a></li>
    <li class="current">Edit a News Item</li>
</ul>

<h1 class="pageTitle">Edit News ID: <?= $newsArticle->getNewsID(); ?> </h1>

<?php
if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Update news error!</h5>
          <p>One or more fields are not filled in, please try again</p>
          </div>';
    unset($_SESSION['error']);
}

    echo '<div class="large-12 medium-12 small-12 columns">';
    echo formStart();
    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtTitle"])) {
            echo textInputEmptyError(true, "News Title", "txtTitle", "errEmptyTitle", "Please enter a News Title", 100);
        } else {
            echo textInputPostback(true, "News Title", "txtTitle", $_POST["txtTitle"], 100);
        }
    } else {
        echo textInputSetup(true, "News Title", "txtTitle", $newsArticle->getTitle(), 100);
    }

    if (isset($_POST["btnSubmit"])) {
        if (empty($_POST["txtMainBody"])) {
            echo textareaInputEmptyError(true, "Main Body", "txtMainBody", "errEmptyBody", "Please enter a Main Body", 5000, 15);
        } else {
            echo textareaInputPostback(true, "Main Body", "txtMainBody", $_POST["txtMainBody"], 5000, 15);
        }
    } else {
        echo textareaInputSetup(true, "Main Body", "txtMainBody", $newsArticle->getMainBody(), 5000, 15);
    }


    if (isset($_POST["btnSubmit"])) {
        echo comboInputPostback(true, "Type", "sltType", $_POST["sltType"], $newsArticle->listTypes());
    } else {
        if (!is_null($newsArticle->getType())) {
            echo comboInputSetup(true, "Type", "sltType", $newsArticle->getType(), $newsArticle->listTypes());
        } else {
            echo comboInputBlank(true, "Type", "sltType", "Please select...", $newsArticle->listTypes());
        }
    }

    if (isset($_POST["btnSubmit"])) {
        echo comboInputPostback(true, "Visibility", "sltVisibility", $_POST["sltVisibility"], $newsArticle->listVisibilities());
    } else {
        if (!is_null($newsArticle->getVisibility())) {
            echo comboInputSetup(true, "Visibility", "sltVisibility", $newsArticle->getVisibility(), $newsArticle->listVisibilities());
        } else {
            echo comboInputBlank(true, "Visibility", "sltVisibility", "Please select...", $newsArticle->listVisibilities());
        }
    }
    ?>
        <div class="large-5 large-centered medium-8 medium-centered small-12 small-centered columns">
            <div class="row">
                <input class="success button" type="submit" name="btnUpdate" value="Update News">
                <input type="submit" name="btnDelete" class="alert button" value="Delete News Article"
                       onclick="return confirm('Are you sure? This WILL delete this news article.')">

            </div>
            <div class="row">
                <input class="button" type="reset" value="Reset">
            </div>
        </div>
    <a href="javascript: history.go(-1)" class="button">Go Back</a>
    </form>
</div>
