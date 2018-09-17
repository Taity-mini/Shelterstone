<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 10/03/2017
 * Time: 23:53
 * Create news article
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
    <li class="current">Create News Item</li>
</ul>

<div class="small-6 small-centered large-10 large-centered columns">


<h1 class="pageTitle">Create news article</h1>
<?php
if (isset($_SESSION['error'])) {
    echo '<br/>';
    echo '<div class="callout warning">
          <h5>Create news error!</h5>
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
    echo textInputBlank(true, "News Title", "txtTitle", 100);
}

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtMainBody"])) {
        echo textareaInputEmptyError(true, "Main Body", "txtMainBody", "errEmptyBody", "Please enter a Main Body", 5000, 15);
    } else {
        echo textareaInputPostback(true, "Main Body", "txtMainBody", $_POST["txtMainBody"], 5000, 15);
    }
} else {
    echo textareaInputBlank(true, "Main Body", "txtMainBody", 5000, 15);
}


if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["sltType"])) {
        echo comboInputEmptyError(true, "Type", "sltType", "Please select...", "errEmptType", "Please select a Type", $newsArticle->listTypes());
    } else {
        echo comboInputPostback(true, "Type", "sltType", $_POST["sltType"], $newsArticle->listTypes());
    }
} else {
    echo comboInputBlank(true, "Type", "sltType", "Please select...", $newsArticle->listTypes());
}


if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["sltVisibility"])) {
        echo comboInputEmptyError(true, "Visibility", "sltVisibility", "Please select...", "errEmptVisibility", "Please select a Visibility level", $newsArticle->listVisibilities());
    } else {
        echo comboInputPostback(true, "Visibility", "sltVisibility", $_POST["sltVisibility"],$newsArticle->listVisibilities());
    }
} else {
    echo comboInputBlank(true, "Visibility", "sltVisibility", "Please select...", $newsArticle->listVisibilities());
}

?>

        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                <input class="button" type="submit" name="btnSubmit" value="Create news">
                <input class="button" type="reset" value="Reset">
        </div>
    <a href="javascript: history.go(-1)" class="button">Go Back</a>
    </form>
</div>
</div>
</div>
</div>