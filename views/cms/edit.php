<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 03/08/2017
 * Time: 21:16
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
    <li><a href="<?php echo $_SESSION['domain'] ?>pages/view/<?php echo $pages->getPageID(); ?>" role="link">Page</a>
    </li>
    <li class="current">Edit a Page Item</li>
</ul>

<h2>Edit a Page Item</h2>


<?php


$conn = dbConnect();

if (isset($_SESSION['invalid'])) {
    echo '<p class="alert-box error radius centre">Some of the input you provided was invalid. Please correct the highlighted errors and try again.</p>';
    unset($_SESSION['invalid']);
}
if (isset($_SESSION['error'])) {
    echo '<p class="alert-box error radius centre">There was an error creating the page item. Please try again.</p>';
    unset($_SESSION['error']);
}

echo formStart();

$pages = new pages($pageID);
$pages->getAllDetails($conn);

if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtTitle"])) {
        echo textInputEmptyError(true, "Page Title", "txtTitle", "errEmptyTitle", "Please enter a Page Title", 250);
    } else {
        echo textInputPostback(true, "Page Title", "txtTitle", $_POST["txtTitle"], 250);
    }
} else {
    echo textInputSetup(true, "Page Title", "txtTitle", $pages->getPageTitle(), 250);
}

if (isset($_POST["btnSubmit"])) {
    echo textInputPostback(false, "Page Description", "txtDescription", $_POST["txtSubTitle"], 250);
} else {
    echo textInputSetup(false, "Page Description", "txtDescription", $pages->getPageDescription(), 250);
}
?>

<div class="large-12 medium-12 small-12 columns">
    <label><b>
            <span class="required">* </span>Visibility (Publicly accessible?)</b>
        <input type='hidden' value='0' name='chkVisibility'/>
        <input id="chkVisibility" type="checkbox" name="chkVisibility"
               value="1" <?php echo($pages->getVisibility() == 1 ? 'checked' : ''); ?>/>

    </label>
</div>

<?php
if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtMainBody"])) {
        echo textareaInputEmptyError(true, "Main Body", "txtMainBody", "errEmptyBody", "Please enter a Main Body", 100000, 20);
    } else {
        echo textareaInputPostback(true, "Main Body", "txtMainBody", $_POST["txtMainBody"], 100000, 20);
    }
} else {
    echo textareaInputSetup(true, "Main Body", "txtMainBody", $pages->getPageContent(), 100000, 20);
}
?>

<br/>
<br/>
<div class="row">
    <h3 class="centre">Add Files to page <input name="btnAddFiles" value="Upload File" class="button" type="submit">
    </h3>


    <div id="FileTable">
        <table class="large-12 medium-12 small-12 columns fileTable" style=" overflow-y: scroll;">
            <tr>
                <th>File Title</th>
                <th>File Description</th>
                <th>Uploader</th>
                <th>Type</th>
                <th>Visibility</th>
                <th>View</th>
                <th>Add</th>
            </tr>
            <?php


            $conn = dbConnect();

            $files = new files();
            $users = new users();
            $fileList = $files->listAllFiles($conn);

            foreach ($fileList as $fileItem) {

                $files->setFileID($fileItem['fileID']);
                $files->getAllDetails($conn);
                $users->setUserID($files->getUserID());
                $users->getAllDetails($conn);

                $fileAuthorLink = "../profile/view/" . $files->getUserID();
                $fileViewLink = $domain . "files/view/" . $files->getFileID();
                $fileDirectLink = $domain . $files->getFilePath();

                echo "<tr>";

                echo '<td data-th="File Title">' . $files->getTitle() . '</td>';
                echo '<td data-th="Description">' . $files->getDescription() . '</td>';
                echo '<td data-th="Uploader"><a href="' . $fileAuthorLink . '">' . $users->getFullName() . '</a></td>';
                echo '<td data-th="Type">' . $files->displayType() . '</td>';
                echo '<td data-th="Visibility">' . $files->displayVisibility() . '</td>';
                echo '<td data-th="View"><a href="' . $fileViewLink . '">View</a></td>';
                if ($files->getType() == 0) {
                    echo '<td data-th="View"><button type="button" class="button" data-value0="0" data-value1="' . $fileDirectLink . '">Add inline</button></td>';
                } else {
                    echo '<td data-th="View"><button type="button" class="button" data-value0="1"  data-value1="' . $fileViewLink . '">Add inline</button></td>';
                }


                echo "</tr>";
            }

            echo '</table>';
            echo '</div>';

            echo formEndWithButton("Save changes", "../delete/" . $pages->getPageID());


            ?>
    </div>
</div>
<script src="<?php echo $domain ?>js/files.js" type="text/javascript" charset="utf-8"></script>
