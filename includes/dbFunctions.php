<?php

include_once 'psl-config.php';
header('Content-Type: text/html; charset=utf-8');

function displaytable($mysq, $tableName) {
    $query1 = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME ='" . $tableName . "'";
    $query2 = "SELECT * FROM $tableName ORDER BY ID DESC";
    $results = $mysq->query($query1);
    $tableRows = $mysq->query($query2);
    $array = array();
    $i = 0;

    if (!$results) {
        echo 'resultta sıkıntıvar';
    } else {

        echo '<thead><tr>';
        while ($row = $results->fetch_assoc()) {


            echo ' <th>' . $row["COLUMN_NAME"] . '</th>';
            $array[] = $row["COLUMN_NAME"];
        }
        //Editas
        echo ' <th>Editables</th>';

        echo '</tr></thead>';
    }
    echo '<tbody>';
    $t = 0;
    while ($row = $tableRows->fetch_assoc()) {
        if ($t % 2) {
            echo "<tr class=\"success\">";
        } else {
            echo"<tr class=\"warning\">";
        }
        while ($i < sizeof($array)) {
            echo "<td>" .$row[$array[$i]] . "</td>";
            $i++;
        }
        echo "<td><a href='" . $tableName . ".php?delete=" . $row['id'] . "'>X</a> - <a href='" . $tableName . ".php?edit=" . $row['id'] . "'>M</a></td>";
        echo '</tr>';
        $i = 0;
        $t++;
    }
    echo '</tbody>';
}


function displaySoldierList($mysq) {

    $query1 = "select soldier.id as id, soldier.name as SoldierName, rank.name as Rank from soldier,rank where rank.id= soldier.rankID";
    $tableRows = $mysq->query($query1);


    if (!$tableRows) {
        echo 'There is a problem in your query my friend!';
    } else {

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
        $rankimg=$row['Rank'] ;
        echo "<td>" . $row['SoldierName'] ."  </td>";
        echo "<td> <img src='ranks/$rankimg.png' /> " . $row['Rank'] . "  </td>";
        //echo "<img src='$content' />";

        echo "<td><a href='soldier.php?delete=" . $row['id'] . "'>X</a> - <a href='mission.php?edit=" . $row['id'] . "'>M</a></td>";
        echo '</tr>';

        $t++;
    }
    echo '</tbody>';
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>