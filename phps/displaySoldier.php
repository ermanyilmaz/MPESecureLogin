<?php
include_once '../includes/db_connect.php';

$query1 = "select soldier.id as id, soldier.name as SoldierName, rank.name as Rank from soldier,rank where rank.id= soldier.rankID";
    $tableRows = $mysqli->query($query1);


    if (!$tableRows) {
        echo 'There is a problem in your query my friend!';
    } else {
        echo '<table class="table table-hover table-condensed">';
        echo '<thead><tr>';

        echo ' <th>Soldier Name</th>'
        . '<th> Rank </th>';
        echo ' <th>Functions</th>';

        echo '</tr></thead>';




        //Editas
    }
    echo '<tbody>';
    $t = 0;
    while ($row = $tableRows->fetch_assoc()) {
        if ($t % 2) {
            echo "<tr class=\"success\">";
        } else {
            echo"<tr class=\"warning\">";
        }
        $rankimg = $row['Rank'];
        echo "<td>" . $row['SoldierName'] . "  </td>";
        echo "<td> <img src='ranks/$rankimg.png' /> " . $row['Rank'] . "  </td>";
        //echo "<img src='$content' />";

        echo "<td><a href='soldier.php?delete=" . $row['id'] . "'><button type='button' class='btn btn-danger btn-xs'>Delete</button> </a> - <a href='mission.php?edit=" . $row['id'] . "'>  <button type='button' class='btn btn-warning btn-xs'>Update</button></a></td>";
        echo '</tr>';

        $t++;
    }
    echo '</tbody></table>';
                           

?>