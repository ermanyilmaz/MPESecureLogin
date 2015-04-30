<?php
include_once './db_connect.php';
include_once './functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['un'], $_POST['pw'])) {
    $username = $_POST['un'];
    $password = $_POST['pw']; // The hashed password.
 
    if (login($username, $password, $mysqli) == true) {
        // Login success 
        header('Location: ../protected_page.php'); // bu pathler sıkıntı cıkarır mı ?
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');  // bu Pathler Sıkıntı Cıkarır mı ?
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}
        
        ?>
