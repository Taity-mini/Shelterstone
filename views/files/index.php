<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 05/08/2017
 * Time: 21:11
 * Files index
 */
?>

<div class="row" id="content">
    <div class="row-12 columns">

        <ul class="breadcrumbs">
            <li><a href="../" role="link">Home</a></li>
            <li class="current">Files</li>
        </ul>

        <h2>Files List</h2>

        <?php

        if (isset($_SESSION['delete'])) {
            echo '<p class="alert-box success radius centre">File deleted successfully!</p>';
            unset($_SESSION['delete']);
        }

        if (isset($_SESSION['update'])) {
            echo '<p class="alert-box success radius centre">Changes saved!</p>';
            unset($_SESSION['update']);
        }

        if (isset($_SESSION['upload'])) {
            echo '<p class="alert-box success radius centre">File uploaded successfully!</p>';
            unset($_SESSION['upload']);
        }

        ?>

        <table class="large-12 medium-12 small-12 columns">
            <tr>
                <th>File Title</th>
                <th>File Description</th>
                <th>Uploader</th>
                <th>Type</th>
                <th>Visibility</th>
                <th>View</th>
                <th>Edit</th>
            </tr>
            <?php

            foreach ($fileList as $fileItem) {

                $files->setFileID($fileItem['fileID']);
                $files->getAllDetails($conn);
                $users->setUserID($files->getUserID());
                $users->getAllDetails($conn);

                $fileAuthorLink = "../profile/view/" . $files->getUserID();
                $fileViewLink = "/files/view/" . $files->getFileID();
                $fileEditLink = "/files/edit/" .  $files->getFileID();

                echo "<tr>";

                echo '<td data-th="File Title">' . $files->getTitle() . '</td>';
                echo '<td data-th="Description">' . $files->getDescription() . '</td>';
                echo '<td data-th="Uploader"><a href="' . $fileAuthorLink . '">' . $users->getFullName() . '</a></td>';
                echo '<td data-th="Type">' . $files->displayType() . '</td>';
                echo '<td data-th="Visibility">' . $files->displayVisibility() . '</td>';
                echo '<td data-th="View"><a href="' . $fileViewLink . '">View</a></td>';
                echo '<td data-th="Edit"><a href="' . $fileEditLink . '">Edit</a></td>';

                echo "</tr>";
            }

            echo '</table>';

            //dbClose($conn);

            echo '<div class="large-2 large-centered medium-6 medium-centered small-12 small-centered columns">';
            echo '<div class ="row">
            <a href="' . $domain . '/files/upload" class="button">Upload File</a>
            </div>
            </div>';
            ?>

    </div>
</div>
