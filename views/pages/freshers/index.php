<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 20/09/2017
 * Time: 21:38
 */

?>


<ul class="breadcrumbs">
    <li><a href="../" role="link">Home</a></li>
    <li class="current">Freshers</li>
</ul>

<div class="small-12 small-centered large-12 large-centered columns">
    <h2>Freshers List</h2>

    <?php


    if ($freshersList != null)
    {

    ?>

    <table class="responsive-card-table unstriped">
        <thead>
        <tr>
            <th>Fresher ID #</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Student ID</th>
            <th>Climbing XP</th>
            <th>Mailing List</th>
            <th>GPDR Consent Date</th>
        </tr>
        </thead>
        <?php


        foreach ($freshersList as $freshersItem) {

            $freshers->setFreshersID($freshersItem['freshersID']);
            $freshers->getAllDetails($conn);


            echo "<tr>";

            echo '<td data-label="Freshers ID">' . $freshers->getFreshersID() . '</td>';
            echo '<td data-label="First Name">' . $freshers->getFirstName() . '</td>';
            echo '<td data-label="Last Name">' . $freshers->getLastName() . '</td>';
            echo '<td data-label="Email">' . $freshers->getEmail() . '</td>';
            echo '<td data-label="Student ID">' . $freshers->getStudentID() . '</td>';
            echo '<td data-label="Climbing XP">' . $freshers->displayLevel() . '</td>';
            echo '<td data-label="Mailing List">' . $freshers->displayMailingList() . '</td>';
            echo '<td data-label="GDPR Consent Date">' . $freshers->getGDPRDate() . '</td>';
            echo "</tr>";
        }

        echo '</table>';

        } else {
            echo 'No freshers added yet!';
        }


        echo linkButton("Add new fresher", '../freshers/add', false, true);

        ?>

</div>
</div>
