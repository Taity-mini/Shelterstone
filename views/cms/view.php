<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 03/08/2017
 * Time: 21:16
 * View page template
 */


?>



            <?php
//            if (isset($_SESSION["username"]) && (pagesFullAccess($connection, $currentUser, $memberValidation))) {
//                echo '<li><a href="../pages/" role="link">Pages</a></li>';
//            } else {
//                echo ' <li>Pages</li>';
//            }
            echo ' <ul class="breadcrumbs">
            <li><a href="../index.php" role="link">Home</a></li>
            <li>Pages</li>';
            ?>


                <?php
                $conn = dbConnect();
                $pages = new pages();
                $pages->setPageID(($pageID));
                $pages->getAllDetails($conn);

                $user = new users($pages->getUserID());
                $user->getAllDetails($conn);

                echo '<li class="current">';

                echo $pages->getPageTitle();
                echo '</li></ul>';

                if (isset($_SESSION['create'])) {
                    echo '<p class="alert-box success radius centre">Pages added successfully!</p>';
                    unset($_SESSION['create']);
                }
                if (isset($_SESSION['update'])) {
                    echo '<p class="alert-box success radius centre">Changes saved successfully!</p>';
                    unset($_SESSION['update']);
                }

                echo ' <div>
                <article>

                <h2>' . $pages->getPageTitle() . '</h2>';

                echo '<p>' . $pages->getPageContent() . '</p>
                <h4 class="h4 italic">By ' . $user->getFullName() . ' on ' . $pages->getCreatedDate() . ' <br>
                Last Updated: ' . $pages->getModifiedDate() . '</h4>
                </article>
                
                ';
                if (isset($_SESSION["userID"])){

                    echo linkButton("Edit this Page", '../edit/' . $pages->getPageID(), false);
                }
                ?>
    </div>

