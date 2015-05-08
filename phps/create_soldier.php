<?php
include "../includes/db_connect.php";
//var datas="soldiername="+soldierns+"&ranks="+rankS+"&serial="+serial;
$soldierN = $_POST['soldiername'];
$rankS = $_POST['ranks'];
$serialS = $_POST['serial'];

if($soldierN != null && $rankS != null && $serialS != null){
$stmt = $mysqli->prepare("INSERT INTO soldier (name,rankID,serial) VALUES (?,?,?)"); 
$stmt->bind_param('sis', $soldierN, $rankS, $serialS);

if($stmt->execute()){
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> <?php echo "Soldier $soldierN"; ?> has been Created Successfuly</strong> 
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
