<?php
include_once '../includes/db_connect.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
$stmt = "select soldier.id as id,soldier.name as soldierName, rank.name as rankName from teammember,soldier,rank where rank.id= soldier.rankID and soldier.id=teammember.soldierID and teammember.teamID=$id";
$tableRows = $mysqli->query($stmt);






if (!$tableRows) {
    echo 'There is a problem in your query my friend!';
} else {
    
    echo '<h2>Team Details</h2>'
    . '<table class="table table-hover table-condensed">';

    echo '<thead><tr>';

    echo ' <th>Soldier Name</th>'
    . '<th> Rank </th>';

    echo '</tr></thead>';




    //Editas
}
echo '<tbody>';
$t = 0;
while ($row = $tableRows->fetch_assoc()) {
    $rankimg= $row['rankName'];
    if ($t % 2) {
        echo "<tr class=\"success\">";
    } else {
        echo"<tr class=\"warning\">";
    }

 
    echo "<td>" . $row['soldierName'] . "  </td>";
 echo "<td> <img src='ranks/$rankimg.png' /> " . $row['rankName'] . "  </td>";


    echo '</tr>';

    $t++;
}
echo '</tbody></table>';
}
?>

