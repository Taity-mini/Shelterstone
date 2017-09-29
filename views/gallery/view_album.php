<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:33
 * View individual album based on ID
 */

if (isset($_SESSION['upload'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Photo Successfully uploaded!</h5>
          </div>';
    unset($_SESSION['upload']);
}

if (isset($_SESSION['delete'])) {
    echo '<br/>';
    echo '<div class="callout alert">
          <h5>Photo Successfully Deleted!</h5>
          </div>';
    unset($_SESSION['delete']);
}

if (isset($_SESSION['update'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Album Successfully Updated!</h5>
          </div>';
    unset($_SESSION['update']);
}


echo '<h1 class="pageTitle" >Gallery | ' . $albums->getAlbumName() . ' </h1>';

if ($photoList == null) {
    echo "<p>Sorry no photos are added to this album at the moment. Please come back later.</p>";
} else {

    echo '<div class="row small-12 medium-up-4 large-up-4 highslide">';

    foreach ($photoList as $photos) {
        $photo = new gallery_photos();
        $photo->setPhotoID($photos["photoID"]);
        $photo->getAllDetails($conn);
        $author->setUserID($photo->getUserID());
        $author->getAllDetails($conn);
        $photosLink = $_SESSION['domain'] . "gallery/photo/" . $photo->getPhotoID();
        $photosEditLink = $_SESSION['domain'] . "gallery/photo/edit/" . $photo->getPhotoID();
        $photoFileLink = $_SESSION['domain'] . $photo->getFullFilePath();

        echo '
        <div class="column">
        <a href="' . $photo->getFullFilePath() . '" class="highslide" onclick="return hs.expand(this)">
                <img style="width:260px; height:260px;" class="thumbnail" src="' . $photo->getFullFilePath() . '" alt="Highslide JS"
                     title="Click to enlarge" />
            </a>
            
            <div class="highslide-caption float-center">
            <b>Title:</b> ' . $photo->getTitle() . '<br>
            <b>Description:</b> ' . $photo->getDescription() . '<br>
             <b>By:</b>' . $author->getFullName() . ' <br>
             <a href="'. $photosLink . '" class="button">View</a>
             <a href="'. $photosEditLink . '" class=" success button">Edit</a>
            </div>
            
             <div class="text-center">
                <a href="'. $photosLink . '" class="button">View</a>';
                if($edit)
                {
                    echo ' <a href="'.$photosEditLink.'" class="success button">Edit</a>';
                }
                echo '
            
            </div>

        </div>
    ';
    }
    echo '</div>';
}

if ($edit) {
    echo '<div class="large-2 large-centered medium-6 medium-centered small-12 small-centered columns">
    <div class="row">
        <a href="/gallery/upload/" class="button">Upload Photos</a>
    </div>
    </div>';
    $_SESSION['albumUpload'] = $albums->getAlbumID();
}

?>
<div class="row">
    <h4 align="center"> Album Details:
        <?php
        if ($edit) {
            echo ' <a href="/gallery/edit/' . $albums->getAlbumID() . '" class="button">[Edit]</a>';
        }
        ?>
    </h4>
    <table>
        <tr>
            <th>Album Title:</th>
            <td><?= $albums->getAlbumName() ?></td>
        </tr>
        <tr>
            <th>Album Description:</th>
            <td><?= $albums->getAlbumDescription() ?></td>
        </tr>
        <tr>
            <th>Album Type:</th>
            <td><?= $albums->displayType() ?></td>
        </tr>
        <tr>
            <th>Author:</th>
            <td><?= $author->getFullName() ?></td>
        </tr>
        <tr>
            <th>Created Date:</th>
            <td><?= $albums->getCreatedDate() ?></td>
        </tr>
        <tr>
            <th>Last Modified Date</th>
            <td><?= $albums->getModifiedDate() ?></td>
        </tr>
    </table>
</div>

<div class="row ">
    <div class="separator"></div>
    <div class="small-centered columns">
        <a href="/gallery/" class="button">Return to gallery</a>
    </div>
</div>



