<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
$mission_id = $_REQUEST['delete'];
?>

<?php if (login_check($mysqli) == true) : ?>
    <?php
   
        if(isset($mission_id)){
        echo 'hala içerideyim';
        $sql = "DELETE FROM mission WHERE id = '$mission_id'";
        $results = $mysqli->query($sql);
        
        }
    ?>

  <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
  <?php endif; ?>



