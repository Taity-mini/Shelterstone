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
    echo "Sorry there hasn't been any gallery albums added currently. Please come back later.";
} else {
    echo '<div class="row medium-up-3 large-up-4">';


    foreach ($albumList as $albums) {
        $album->setAlbumID($albums["albumID"]);
        $album->getAllDetails($conn);
        $author->setUserID($album->getUserID());
        $author->getAllDetails($conn);
        $photos->setAlbumID($album->getAlbumID());
        $photos->getLatestPhoto($conn);

        $albumsLink = $_SESSION['domain'] . "/gallery/album/" . $album->getAlbumID();

        echo '
        <div class="column">
            <h3>' . $album->getAlbumName() . '</h3>
       
            <p>Author:' . $author->getFullName() . '
            <a href="'.$albumsLink.'"><img style="max-width:250px; max-height:250px;" class="thumbnail" src="'.$photos->getFullFilePath().'"></a>
           ' . $album->getAlbumDescription() . '</p>
        </div>    
     
    ';
    }
    echo '</div>';
}

//If user has editing privileges then display create new album button
if ($create) {
    echo '<a href="/gallery/add" class="button">Create new Album</a>';
}


?>


</div>


