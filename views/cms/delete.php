<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 03/08/2017
 * Time: 21:16
 */


?>


<div class="row" id="content">
    <div class="large-12 medium-12 small-12 columns">

        <ul class="breadcrumbs">
            <li><a href="../index.php" role="link">Home</a></li>
            <li><a href="/pages/view/<?php echo $pages->getPageID();?>" role="link">Page</a></li>
            <li class="current">Delete a Page</li>
        </ul>

        <h2>Delete a Page Item</h2>

        <?php

        $conn = dbConnect();

        if (isset($_SESSION['error'])) {
            echo '<p class="alert-box error radius centre">There was an error deleting the pages item. Please try again.</p>';
            unset($_SESSION['error']);
        }

        $pages = new pages($pageID);
        $pages->getAllDetails($conn);

        echo formStart(false);

        echo '<div class="panel"><p class="centre middle">Are you sure you want to delete the page: <b>' . $pages->getPageTitle() . '</b>?</p></div>';

        echo formEndWithDeleteButton("Delete");

        dbClose($conn);
        ?>

    </div>
</div>

