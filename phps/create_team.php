<?php
include "../includes/db_connect.php";

$teamName = $_POST['teamName'];
$teamLid = $_POST['teamLid'];
$soldiers = $_POST['soldiers'];
$soldiers   =    json_decode("$soldiers",true);
if (count($soldiers)==0){
    echo "Soldiers bilgisi gelmiyor $teamLid $teamName";
    foreach ($soldiers as $soldier)
        echo "$soldier";
}
 

if($teamName != null && $teamLid != null && $soldiers != null){
$stmt = $mysqli->prepare("INSERT INTO team (name,leaderID) VALUES (?,?)"); 
$stmt->bind_param('si', $teamName, $teamLid);

//$stmT= $mysqli->prepare("select MAX(id) from team");

$stmT = $mysqli->query("select MAX(id) from team");

while($max = $stmT->fetch_assoc()){
    $maxid= max($max);
}
echo $maxid;
foreach ($soldiers as $soldier){
        
}
if($stmt->execute()){
    foreach ($soldiers as $soldier){
        echo "soldier editing";
       $stmti = $mysqli->prepare("INSERT INTO teammember (teamID,soldierID) VALUES (?,?)"); 
        $stmti->bind_param('ii', $maxid, $soldier); 
        $stmti->execute();
}
    
    
?>
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong> <?php echo "Soldier $teamName"; ?> has been Created Successfuly</strong> 
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
