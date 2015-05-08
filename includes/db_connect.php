<?php

       include_once 'psl-config.php';   // As functions.php is not included
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    header("Location:error.php");
}
mysqli_set_charset($mysqli,"utf8");

        ?>
