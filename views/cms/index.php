<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 03/08/2017
 * Time: 22:07
 * Pages index view
 */

?>


        <ul class="breadcrumbs">
            <li><a href="index.php" role="link">Home</a></li>
            <li class="current">Pages</li>
        </ul>

        <h2>Pages List</h2>

        <?php
        if (isset($_SESSION['delete'])) {
            echo '<p class="alert-box success radius centre">Page deleted successfully!</p>';
            unset($_SESSION['delete']);
        }
        ?>

        <table class="large-12 medium-12 small-12 columns">
            <tr>
                <th>Page Title</th>
                <th>Page Description</th>
                <th>Author</th>
                <th>Created</th>
                <th>Modified</th>
                <th>Visibility</th>
                <th>View</th>
                <th>Edit</th>
            </tr>
            <?php

            foreach ($pageList as $pageItem) {

                $pages->setPageID($pageItem['pageID']);
                $pages->getAllDetails($conn);
                $users->setUserID($pages->getUserID());
                $users->getAllDetails($conn);

                $pageAuthorLink = "../profile/view/" . $pages->getUserID();
                $pageViewLink = $domain."pages/view/" . $pages->getPageID();
                $pageEditLink = $domain."pages/edit/" . $pages->getPageID();

                echo "<tr>";

                echo '<td data-th="Page Title">' . $pages->getPageTitle() . '</td>';
                echo '<td data-th="Description">' . $pages->getPageDescription() . '</td>';
                echo '<td data-th="Author"><a href="' . $pageAuthorLink . '">' . $users->getFullName() . '</a></td>';
                echo '<td data-th="Created">' . $pages->getCreatedDate() . '</td>';
                echo '<td data-th="Modified">' . $pages->getModifiedDate() . '</td>';
                echo '<td data-th="Visibility">' . $pages->displayVisibility() . '</td>';
                echo '<td data-th="View"><a href="' . $pageViewLink . '">View</a></td>';
                echo '<td data-th="Edit"><a href="' . $pageEditLink . '">Edit</a></td>';

                echo "</tr>";
            }

            echo '</table>';

            dbClose($conn);

            echo '<div class="large-2 large-centered medium-6 medium-centered small-12 small-centered columns">';
            echo '<div class ="row">
            <a href="' . $domain . 'pages/add" class="button">Add new Page</a>
            </div>
            </div>';
            ?>


    </div>
</div>
