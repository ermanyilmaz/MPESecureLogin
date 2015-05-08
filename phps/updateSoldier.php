<?php
include_once '../includes/db_connect.php';
if(isset($_GET['id'])){
    //var datas="sn="+sn+"&serial="+serials+"&ranku="+serials;
$soldierNS = $_POST['sn']; 
$serial = $_POST['serial']; 
$ranks = $_POST['ranku']; 
$id = $_GET['id'];    
    
    
$stmt = $mysqli->prepare("update soldier set name=?, rankID=?, serial=? where id=?");
$stmt->bind_param('sisi', $soldierNS,$ranks,$serial,$id);



if($stmt->execute()){
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo "$soldierNS has updated successfully" ?></strong> 
</div>
<?php
} else{
?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong> Thereis an errror
</div>
<?php
}
} else{
?> 
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Soldier id is not found</strong> .
</div>
<?php
}
?>
