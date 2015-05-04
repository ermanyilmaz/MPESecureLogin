<?php
include_once '../includes/db_connect.php';

$query1 = "select team.id as teamID,mission.name as MissionName,soldier.name as Leader,rank.name as Rank, team.name as TeamName,mission.details as details from mission,team,soldier,rank where mission.teamID = team.id and soldier.id = team.leaderID and soldier.rankID = rank.id";
$tableRows = $mysqli->query($query1);


if (!$tableRows) {
    echo 'There is a problem in your query my friend!';
} else {
    echo '<table class="table table-hover table-condensed">';

    echo '<thead><tr>';

    echo ' <th>Team Name</th>'
    . '<th> Team Leader </th>';
    echo ' <th>Team Leader Rank</th>';
    echo ' <th>Mission Name</th>';
    echo ' <th>Detailed Mission Information</th>';
    echo '<th> Team Functions </th>';

    echo '</tr></thead>';




    //Editas
}
echo '<tbody>';
$t = 0;
while ($row = $tableRows->fetch_assoc()) {
    $teamID= "" . $row['teamID'];
    if ($t % 2) {
        echo "<tr onmouseover=\"teammatelist($teamID)\" class=\"success\">";
    } else {
        echo"<tr onmouseover=\"teammatelist($teamID)\" class=\"warning\">";
    }

    $teamID= "" . $row['teamID'];
    $teamname=$row['TeamName'];
    $leader= $row['Leader'];
    $rankimg = $row['Rank'];
    $mName = $row['MissionName'] ;
    $Mdts=$row['details'];
    echo "<td>" . $row['TeamName'] . "  </td>";
    echo "<td>" . $row['Leader'] . "  </td>";
    echo "<td> <img src='ranks/$rankimg.png' /> " . $row['Rank'] . "  </td>";
    echo "<td>" . $row['MissionName'] . "  </td>";
    echo "<td>" . $row['details'] . "  </td>";

    echo "<td><button type='button' onclick='deleteTeam(\"$teamID\")' class='btn btn-danger btn-xs'>Delete</button> &nbsp"; ?>
<button type='button' <?php echo "onclick= 'updateTeamfill(\"$teamID\",\"$teamname\",\"$leader\")'"; ?> class='btn btn-warning btn-xs' data-toggle="modal" data-target="#myMissionUModal">Update</button> 
    <?php
    ?>

    <?php
    echo '</tr>';

    $t++;
}
echo '</tbody></table>';
echo ' <div class="btn-group">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#teamCreatePop">Create Team</button>
                                
                            </div>';
                           

?>