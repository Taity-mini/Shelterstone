<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 11/03/2017
 * Time: 00:34
 * View Individual photo based on ID
 */


?>
<h1 class="pageTitle" >Gallery | View photo: <?=$photos->getTitle()?> </h1>
<div class="small-6 small-centered large-10 large-centered columns">
    <div class="row ">
        <div class="separator"></div>
        <div class ="highslide-gallery small-6 small-centered columns">
            <a id="thumb1" href="<?=$photos->getFilePath()?>" class ="highslide" onclick="return hs.expand(this)">
                <img class="displayed" src="<?=$photos->getFilePath()?>" alt="Highslide JS"
                     title="Click to enlarge" />
            </a>
            <div class="highslide-caption">
                Title: <?=$photos->getTitle()?> <br/>
                Description: <?=$photos->getDescription()?> <br/>
                <b><a href="<?=$photos->getFilePath()?>">View the Photo</a></b>
            </div>
        </div>
    </div>

<div class="row">
    <h4 align="center"> Photo details:
        <?php
        if ($edit) {
            echo ' <a href="/gallery/photo/edit/' . $photos->getPhotoID() . '" class="button">[Edit]</a>';
        }
        ?>
    </h4>
    <table>
        <tr>
            <th>Photo Description:</th>
            <td><?=$photos->getDescription()?></td>
        </tr>
        <tr>
            <th>Album Title:</th>
            <td><?=$albums->getAlbumName()?></td>

        </tr>
        <tr>
            <th>Album Description:</th>
            <td><?=$albums->getAlbumDescription()?></td>

        </tr>
        <tr>
            <th>Author:</th>
            <td><?=$author->getFullName()?></td>
        </tr>
        <tr>
            <th>Created Date:</th>
            <td><?=$photos->getCreatedDate()?></td>
        </tr>
        <tr>
            <th>Last Modified Date</th>
            <td><?=$photos->getModifiedDate()?></td>
        </tr>
    </table>
</div>

    <div class="row ">
        <div class="separator"></div>
        <div class ="small-centered columns">
          <a href="/gallery/album/<?=$albums->getAlbumID()?>" class="button">Return to album</a>
        </div>
    </div>

</div>



