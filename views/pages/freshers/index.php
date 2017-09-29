<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/09/2017
 * Time: 21:38
 */

?>

<div class="row" id="content">
    <div class="row-12 columns">

        <ul class="breadcrumbs">
            <li><a href="../" role="link">Home</a></li>
            <li class="current">Freshers</li>
        </ul>

        <h2>Freshers List</h2>

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

        if ($freshersList != null)
        {

        ?>

        <table class="large-12 medium-12 small-12 columns">
            <tr>
                <th>Fresher ID #</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Student ID</th>
                <th>Climbing XP</th>
            </tr>
            <?php


            foreach ($freshersList as $freshersItem) {

                $freshers->setFreshersID($freshersItem['freshersID']);
                $freshers->getAllDetails($conn);


                echo "<tr>";

                echo '<td data-th="Freshers ID">' . $freshers->getFreshersID() . '</td>';
                echo '<td data-th="First Name">' . $freshers->getFirstName() . '</td>';
                echo '<td data-th="Last Name">' . $freshers->getLastName() . '</td>';
                echo '<td data-th="Email">' . $freshers->getEmail() . '</td>';
                echo '<td data-th="Student ID">' . $freshers->getStudentID() . '</td>';
                echo '<td data-th="Climbing XP">' . $freshers->displayLevel() . '</td>';

                echo "</tr>";
            }

            echo '</table>';

            } else{
            echo 'No freshers added yet!';
            }

            //dbClose($conn);

            echo linkButton("Add new fresher", '../freshers/add', false);
            ?>

    </div>
</div>
