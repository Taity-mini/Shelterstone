<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 01:05
 * Upload Photo to gallery page
 */
?>
<ul class="breadcrumbs">
    <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
    <li><a href="<?php echo $_SESSION['domain'] ?>gallery/" role="link">Gallery</a></li>
    <li class="current">Upload</li>
</ul>

<h1 class="pageTitle">Gallery | Upload</h1>


<form action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post"
      enctype="multipart/form-data">
<?php
echo '<div class="small-12 small-centered large-10 large-centered columns">';
echo ' <div class="row">
                    <div class="large-12 medium-12 small-12 columns"> 
                            <p class="required">* indicates a required field</p>
                            <div class="row">
       
             <div class="row">
                <label><b>Choose an album to upload to:</b></span>';


echo '<select id="sltAlbum" name="sltAlbum">';
foreach ($albumList as $key => $value) {

    if (isset($_SESSION['albumUpload']) && $key == $_SESSION['albumUpload']) {
        echo '<option selected  value="' . $key . '">' . $value . '</option>';
    } else {
        echo '<option value="' . $key . '">' . $value . '</option>';
    }
}
echo '</select>
                            </label>
                            
                            ';

echo '<div class="row">';
if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtTitle"])) {
        echo textInputEmptyError(true, "Photo Title", "txtTitle", "errEmptyTitle", "Please enter a Album Name", 50);
    } else {
        echo textInputPostback(true, "Photo Title", "txtTitle", $_POST["txtTitle"], 50);
    }
} else {
    echo textInputBlank(true, "Photo Title", "txtTitle", 50);
}
echo'</div>
 <div class="row">';


if (isset($_POST["btnSubmit"])) {
    if (empty($_POST["txtDescription"])) {
        echo textareaInputEmptyError(true, "Album Description", "txtDescription", "errEmptyDescription", "Please enter a album description", 250, 4);
    } else {
        echo textareaInputPostback(true, "Album Description", "txtDescription", $_POST["txtDescription"], 250, 4);
    }
} else {
    echo textareaInputBlank(true, "Album Description", "txtDescription", 250, 4);
}

    echo '<div class="large-12 medium-12 small-12 columns">
                <label>
                    <span><b>Choose a photo</b></span>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </label>
            </div>';

echo formEndWithButton("Upload Photo", false, "../album/" . $_SESSION['albumUpload'] . "");
?>

</div>
</div>
</div>