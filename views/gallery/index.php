<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:38
 * Gallery index page - Lists all albums
 */

if (isset($_SESSION['create'])) {
    echo '<br/>';
    echo '<div class="callout success">
          <h5>Album Successfully Added!</h5>
          </div>';
    unset($_SESSION['create']);
}

if (isset($_SESSION['delete'])) {
    echo '<br/>';
    echo '<div class="callout alert">
          <h5>Album Successfully Deleted!</h5>
          </div>';
    unset($_SESSION['delete']);
}


echo '<h1 class="pageTitle">' . $heading . '</h1>';
echo '<p>' . $description . '</p>';

if ($albumList == null) {
    echo "<p>Sorry there hasn't been any gallery albums added currently. Please come back later.</p>";
} else {
    echo '<div class="row small-12 medium-up-4 large-up-4">';


    foreach ($albumList as $albums) {
        $album->setAlbumID($albums["albumID"]);
        $album->getAllDetails($conn);
        $author->setUserID($album->getUserID());
        $author->getAllDetails($conn);
        $photos->setAlbumID($album->getAlbumID());
        $photos->getLatestPhoto($conn);

        $albumsLink = $_SESSION['domain'] . "gallery/album/" . $album->getAlbumID();

        echo '
        <div class="column img_wrap">
            <h3 class="albumTitle">' . $album->getAlbumName() . '</h3>
            <a href="'.$albumsLink.'"><img style="width:250px; height:250px;" class="thumbnail" src="'.$photos->getFullFilePath().'"></a>
            <p class="img__description"><b>Author:</b> '. $author->getFullName() . '
            </br><b>Description:</b> '. $album->getAlbumDescription() . ' 
            </br><b>Type:</b> '. $album->displayType() . '
            </p>
        </div>    
     
    ';
    }
    echo '</div>';
}

//If user has editing privileges then display create new album button
if ($create) {
    echo'<div class="large-2 large-centered medium-6 medium-centered small-12 small-centered columns">';
    echo '<div class ="row">
            <a href="/gallery/add" class="button">Create new Album</a>
    </div>
    </div>';
}


?>


</div>


