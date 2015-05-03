

<?php
include_once '../includes/db_connect.php';

$query1 = "select mission.id as id,mission.name as MissionName,soldier.name as 
        Leader, team.name as TeamName, mission.latitude as latitude,longitude as longitude, mission.time as time ,mission.details as details from mission,team,soldier where mission.teamID = team.id and soldier.id = team.leaderID";
$tableRows = $mysqli->query($query1);


if (!$tableRows) {
    echo 'There is a problem in your query my friend!';
} else {
    echo '<table class="table table-hover table-condensed">';

    echo '<thead><tr>';

    echo ' <th>Mission Name</th>'
    . '<th> Leader Name </th>';
    echo ' <th>Team Name</th>';
    echo ' <th>Latitude</th>';
    echo ' <th>Longitude</th>';
    echo ' <th>Time Created</th>';
    echo '<th> Mission Details </th>';
    echo '<th> Mission Functions </th>';

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

    $idstr = "" . $row['id'];
    $miname=$row['MissionName'];
    $tname= $row['TeamName'];
    $lat = $row['latitude'];
    $long = $row['longitude'] ;
    $dts=$row['details'];
    echo "<td>" . $row['MissionName'] . "  </td>";
    echo "<td>" . $row['Leader'] . "  </td>";
    echo "<td>" . $row['TeamName'] . "  </td>";
    echo "<td>" . $row['latitude'] . "  </td>";
    echo "<td>" . $row['longitude'] . "  </td>";
    echo "<td>" . $row['time'] . "  </td>";
    echo "<td>" . $row['details'] . "  </td>";

    echo "<td><button type='button' onclick='deletedata(\"$idstr\")' class='btn btn-danger btn-xs'>Delete</button> &nbsp"; ?>
<button type='button' <?php echo "onclick= 'updatefill(\"$idstr\",\"$miname\",\"$lat\",\"$long\",\"$dts\")'"; //,$miname,$lat,$long,$dts?> class='btn btn-warning btn-xs' data-toggle="modal" data-target="#myMissionUModal">Update</button> 
    <?php
    echo "<button type='button' class='btn btn-primary btn-xs'>Display</button></td>";
    ?>

    <?php
    echo '</tr>';

    $t++;
}
echo '</tbody></table>';
echo ' <div class="btn-group">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#misionCreatePop">Create Mission</button>
                                
                            </div>';
                           

?>


