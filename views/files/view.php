<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 05/08/2017
 * Time: 21:11
 * File view/download script
 */
?>

<div class="row" id="content">
    <div class="large-12 medium-12 small-12 columns">

        <ul class="breadcrumbs">
            <li><a href="<?php echo $_SESSION['domain'] ?>" role="link">Home</a></li>
            <li>Files</li>
            <li class="current">Download File</li>
        </ul>


        <?php

        $conn = dbConnect();

        $fileLink = $domain .$files->getFilePath();
        $downloadLink =$domain. '/files/download/'.$files->getFileID();

        echo'<h2>Downloading File: '.$files->getTitle().'...</h2>';

        echo '<p>'.$files->getDescription().'</p>';

        echo'<p>If file fails to download after 5 seconds then click <a href="'.$fileLink.'">Here</a></p>';


        echo '<META HTTP-EQUIV="Refresh" CONTENT="5; URL='.$downloadLink.'">';

        echo '<a href="javascript: history.go(-1)" class="button">Go Back</a>';
        dbClose($conn);
        ?>
    </div>
</div>
