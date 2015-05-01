<?php
include "../includes/db_connect.php";
$missionN = $_POST['missionN'];
$teamId = $_POST['teamid'];
$missionD = $_POST['missionD'];
$mLat = $_POST['mLat'];
$mLong = $_POST['mLong'];
if($missionN != null && $teamId != null && $missionD != null && $mLat != null&& $mLong != null){
$stmt = $mysqli->prepare("INSERT INTO mission (name,teamID,latitude,longitude,details) VALUES (?,?,?,?,?)"); 
$stmt->bind_param('sidds', $missionN, $teamId, $mLat, $mLong,$missionD);

if($stmt->execute()){
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> <?php echo "$missionN"; ?> has been Created</strong> 
</div>
<?php
} else{
?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>There is a Problem</strong> 
</div>
<?php
}
} else{
?> 
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong>
<?php
}
?>
