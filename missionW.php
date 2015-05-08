<?php
include 'includes/db_connect.php';
include 'includes/functions.php';
include 'includes/dbFunctions.php';

sec_session_start();
$id=$_GET['id'];
$sql="select * from mission where id=$id";
$tableRows = $mysqli->query($sql);
$row = $tableRows->fetch_assoc();

?> <!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row['name'];?></title>
  <meta charset="utf-8">
  <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAnFhZog7gFgXBi79GWVops8broQb6Hovw"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
        <?php if (login_check($mysqli) == true) : ?>
    <div class="container-fluid">
                <div class="row enterancebar">
                    <div align="left" class="col-sm-3"><p>Welcome <?php echo $_SESSION['username']; ?>!</p></div>
                    <div align="center" class="col-sm-6">Mission Planner and Executer</div>
                    <div align="right" class="col-sm-3">
                        <p>Do you want to change user? <a href="./includes/logout.php">Log out</a>.</p></div>
                </div>

            </div>
<div class="container-fluid">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3>
				<?php echo $row['name'];?>
			</h3>
			<div class="row clearfix">
                            
			</div>
		</div>
	</div><div  style="width:100%;height:777px " id="mapw">
				</div>
</div>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
</body>
<script>
var markers = new Array();    
    var map;
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(30,30),
    zoom:3,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  map=new google.maps.Map(document.getElementById("mapw"),mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);

var myVar=setInterval(function () {myTimer();}, 1500);
var i=0;
function myTimer() {
    console.log(++i+". turn");
    // AJAX POST
	$.post("responder.php", { id: <?PHP echo $id; ?> }, function( data ) {
		if (data == "finished") {
			alert("Misson Finished");
			clearTimeout(myVar);
		} 
		else if (data == "notStarted") {
			alert("Misson Finished");
			clearTimeout(myVar);
		}
		else {
			$.each(JSON.parse(data), function(idx, obj) {
				// alert(obj.latitude);
				console.log(obj.latitude);
				if(markers[obj.soldierID]==null)
					addPoint(map,obj.latitude,obj.longitude,obj.name,obj.soldierID);
				else
					movePoint(obj.latitude,obj.longitude,obj.soldierID);
			});
		}
	});
}


        function movePoint(lat, lng, id) {
     //       console.log(id+" moved to "+lat);

            var thisLatlng = new google.maps.LatLng(lat, lng);
            markers[id].setPosition(thisLatlng);
        }

        function addPoint(thismap, lat, lng, name,id) {   
            console.log(name+" added to "+lat);
            var thisLatlng = new google.maps.LatLng(lat, lng);
            var marker = new google.maps.Marker({
                position: thisLatlng
            });
            var infowindow = new google.maps.InfoWindow({
                    content: name
                });
                google.maps.event.addListener(marker, 'click', function () {

                    infowindow.open(thismap, marker);

                    setTimeout(function () {
                        infowindow.close();
                    }, 4000);

                });
            marker.setMap(thismap);
            markers[id] = marker;
        }
		
		
</script>
</html>
