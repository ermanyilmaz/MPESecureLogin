<?php
include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/dbFunctions.php';

sec_session_start();
$id	= $_POST["id"];
$result	= array();

$situationSQL = $mysqli->query("select * from location where missionID=$id and status='END'");
    if ((mysqli_num_rows($situationSQL) > 0)) {
        die("finished");
    } else {
        $situationSQL = $mysqli->query("select * from location where missionID=$id and status='START'");
        if (mysqli_num_rows($situationSQL) > 0) {
            //olay burda
            $locationSQL = $mysqli->query("select * from location l,soldier s where soldierID=s.id and l.id in (select max(id) from location where missionID=$id group by soldierID)");
            while($row1 = $locationSQL->fetch_assoc()) {
				$result[]	= $row1;
				// die($row1[latitude] . "&" . $row1[soldierID] . "&" . $row1[longitude] . "&" . $row1[name]);
            }
			echo json_encode($result);
        } else {
			die("notStarted");
        }
    }
    $mysqli->close();