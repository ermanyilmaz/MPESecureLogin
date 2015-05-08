<?php
include_once '../includes/db_connect.php';

$query1 = "select soldier.id as id,soldier.serial as serial, soldier.name as SoldierName, rank.name as Rank from soldier,rank where rank.id= soldier.rankID";
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
        $sid=$row['id'];
        $sname=$row['SoldierName'];
        $serial =$row['serial'];
       

       echo "<td><button type='button' onclick='updateSoldier(\"$sid\",\"$sname\",\"$rankimg\",\"$serial\")' class='btn btn-warning btn-xs' data-toggle='modal' data-target='#SoldierupdatePop'>Update</button> &nbsp";
       
        echo '</td></tr>';

        $t++;
    }
    echo '</tbody></table>';
    echo ' <div class="btn-group">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#SoldierCreatePop">Create Soldier</button>
                                
                            </div>';
                           

?>