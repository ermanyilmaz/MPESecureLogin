<?php
include_once '../includes/db_connect.php';
if(isset($_GET['id'])){
$mn = $_POST['mn']; // mission name ->> name in table (string)
$teid = $_POST['teid']; // teamID in table (int)  // mission is de integer zaten
$msd = $_POST['msd']; // details (string)
$lat = $_POST['lat']; // latitude (double)
$long = $_POST['long']; // longitude (double)
$id = $_GET['id'];    
    
    
$stmt = $mysqli->prepare("update mission set name=?, teamID=?, latitude=?, longitude=?, details=? where id=?");
$stmt->bind_param('siddsi', $mn, $teid, $lat, $long,$msd, $id);



if($stmt->execute()){
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong><?php echo "$mn has updated successfully" ?></strong> 
</div>
<?php
} else{
?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Error!</strong> Maaf terjadi kesalahan, data error.
</div>
<?php
}
} else{
?> 
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Warning!</strong> Maaf anda salah alamat.
</div>
<?php
}
?>
