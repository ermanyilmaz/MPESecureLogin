<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/dbFunctions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Secure Login: Protected Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link href="./css/protected.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAnFhZog7gFgXBi79GWVops8broQb6Hovw"></script>
        
        <script>
            function initialize() {
                var mapProp = {
                    center: new google.maps.LatLng(39.9333, 32.8667),
                    zoom: 5,
                    mapTypeId: google.maps.MapTypeId.SATELLITE

                };
                var mapCreate = {
                    center: new google.maps.LatLng(39.9333, 32.8667),
                    zoom: 5,
                    mapTypeId: google.maps.MapTypeId.SATELLITE


                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                var mapC = new google.maps.Map(document.getElementById("Cmap"), mapCreate);
                
                $("#misionCreatePop").on("shown.bs.modal", function () {
                    var currentCenter = mapC.getCenter();

                    google.maps.event.trigger(mapC, "resize");
                    mapC.setCenter(currentCenter);
                });
                //clicking the Create Mission Map
                var marker;
                //listener to drad

                google.maps.event.addListener(mapC, "click", function (e) {

                    //lat and lng is available in e object
                    var latLng = e.latLng;

                    document.getElementById("mLat").value = latLng.lat();
                    document.getElementById("mLong").value = latLng.lng();
                    if (marker) {
                        marker.setPosition(latLng);
                        google.maps.event.addListener(marker, 'dragend', function (event) {
                            document.getElementById("mLat").value = this.getPosition().lat();
                            document.getElementById("mLong").value = this.getPosition().lng();
                        });
                    }
                    else {
                        marker = new google.maps.Marker({
                            map: mapC,
                            position: latLng,
                            draggable: true

                        });
                    }

                });

<?php
// uncomment the 2 lines below to get real data from the db
$sql = "SELECT * FROM mission";
$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    $i = $row['id'];

    echo "addMarker(new google.maps.LatLng(" . $row['latitude'] . ", " . $row['longitude'] . "), map," . (string) $i . ");";
}
?>

            }
            function addMarker(latLng, maps, missid) {
                //define an image
                var image = 'http://maps.google.com/mapfiles/kml/pal5/icon44.png';
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: maps,
                    draggable: false, // enables drag & drop
                    animation: google.maps.Animation.DROP,
                    title: "Mission id : " + missid,
                    icon: image

                });
                var infowindow = new google.maps.InfoWindow({
                    content: "contentString"
                });


                google.maps.event.addListener(marker, 'click', function () {

                    infowindow.open(maps, marker);

                    setTimeout(function () {
                        infowindow.close();
                    }, 4000);


                });









                return marker;

            }
//            $('#misionCreatePop').on('show.bs.modal', function () {
//                $('.modal-content').css('height', $(window).height() * 0.8);
//            });
        </script>
    </head>

    <body onload="initialize(); viewdata();" style="height: 100%;">
        <?php if (login_check($mysqli) == true) : ?>

            <div class="container-fluid">
                <div class="row enterancebar">
                    <div align="left" class="col-sm-3"><p>Welcome <?php echo $_SESSION['username']; ?>!</p></div>
                    <div align="center" class="col-sm-6">Mission Planner and Executer</div>
                    <div align="right" class="col-sm-3">
                        <p>Do you want to change user? <a href="./includes/logout.php">Log out</a>.</p></div>
                </div>

            </div>
            <div class="tabbable" id="tabs-755234">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#panel-missions" data-toggle="tab">Missions</a>
                    </li>
                    <li>
                        <a href="#panel-teams" data-toggle="tab">Teams</a>
                    </li>
                    <li>
                        <a href="#panel-soldier" data-toggle="tab">Soldiers</a>
                    </li>
                </ul>

            </div>  


            <div class="tab-content"  style="height: 80%;">
                <div class="tab-pane active" id="panel-missions">
                    <div class="container-fluid" style="height: 80%;">
                        <div id="info"></div>
                        <div id="missiondiplayer" class="col-md-12 column" style="background-color:lavender;height: 80%;" > 
                        </div>
                        <div class="col-md-12 column" >
                            <h2>Listed Missions</h2>
                            <div id="googleMap" style="width:100%;height:500px;"></div>
                        </div>
                    </div>
                </div>
                <!--                Create Button then after commings-->
                <div class="modal fade " id="misionCreatePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
                    <div class="modal-dialog">
                        <div class="modal-content" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Create Mission</h4>
                            </div>
                            <div class="modal-body">

                                <form>
                                    <div class="form-group">
                                        <label for="nm">Mission Name</label>
                                        <input type="text" class="form-control" id="missionN" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="sel1">Select a Team For the Mission</label>
                                        <select class="form-control" id="teamid" required >
                                            <?php
                                            $query1 = "select * from team";
                                            $tableRows = $mysqli->query($query1);

                                            while ($row = $tableRows->fetch_assoc()) {

                                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="pn">Mission Details</label>
                                        <input type="text" class="form-control" id="missionDt" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alL">Latitude</label>
                                        <input type="text" class="form-control" id="mLat" required disabled>
                                        <label for="alLg">Longitude</label>
                                        <input type="text" class="form-control" id="mLong" required disabled>
                                        <label for="alM">Select Location</label>
                                        <div id="Cmap" style="width: 100%; height: 300px"></div>



                                    </div>
                                      <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="CreateMission" class="btn btn-primary">Save changes</button>
                            </div>

                                </form>

                            </div>
                          
                        </div>
                    </div>
                </div>   


<!--               myMissionModalUpdate -->
                    <div class="modal fade" id="myMissionUModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
        <div class="modal-dialog" id="mapuid">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit Mission</h4>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="form-group">
                            <label for="nm">Mission Name :</label>
                            <input type="hidden" class="form-control" id="Uid" value="">
                            <input type="text" class="form-control" id="UMissionN" value="">
                        </div>
                        <div class="form-group">
                                        <label for="sel1">Change Team For the Mission</label>
                                        <select class="form-control" id="teamid" required >
                                            <?php
                                            
                                            $queryt = "select * from team";// where name !='". $row['TeamName']."'";
                                            $tableRowst = $mysqli->query($queryt);

                                            while ($rowT = $tableRowst->fetch_assoc()) {
                                                if($teamnameU== $rowT['name']){
                                                echo '<option class="blueText" value="' . $rowT['id'] . '">' . $rowT['name'] . ' (Mission is assigned that team already)</option>';
                                                }
                                                else
                                                    echo '<option value="' . $rowT['id'] . '">' . $rowT['name'] . '</option>';
                                            }
                                
                                            ?>
                                        </select>

                                    </div>
                        <div class="form-group">
                            <label for="gd">Mission Details</label>
                            <input type="text" class="form-control" id="UmissionDt" value="">
                        </div>
                        <div class="form-group">
                            <label for="pn">Latitude</label>
                            <input type="text" class="form-control" id="Ulat" value="" disabled="">
                        
                            <label for="al">Longitude</label>
                            <input type="text" class="form-control" id="Ulong" value="" disabled="">
                            <div id="Umap" style="width: 100%; height: 300px"></div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="updatedata('')" class="btn btn-primary">Update Mission</button>
                </div>
            </div>
        </div>
    </div>






                <div class="tab-pane" id="panel-teams">
                    <div class="container-fluid" style="height: 80%;">
                        <div class="col-md-12 column" style="background-color:lavender;height: 80%;" >



                            <table class="table table-hover table-condensed">
                                <?php
                                displaytable($mysqli, "team");
                                ?>
                            </table>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info">Create</button>
                                <button type="button" class="btn btn-warning">Update</button>

                                <button type="button" class="btn btn-primary">Display</button>


                                <button type="button" class="btn btn-danger">Delete</button>  
                                <button type="button" class="btn btn-success">Success</button>
                            </div>
                        </div>
                        <div class="col-md-12 column" >
                            <h2>Team Details</h2>


                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="panel-soldier">
                    <div class="container-fluid" style="height: 80%;">
                        <div class="col-md-12 column" style="background-color:lavender;height: 80%;" >



                            <table class="table table-hover table-condensed">
                                <?php
                                displaySoldierList($mysqli);
                                ?>
                            </table>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info">Create</button>
                                <button type="button" class="btn btn-warning">Update</button>

                                <button type="button" class="btn btn-primary">Display</button>


                                <button type="button" class="btn btn-danger">Delete</button>  
                                <button type="button" class="btn btn-success">Success</button>
                            </div>
                        </div>
                        <div class="col-md-12 column" >
                            <h2>Soldier</h2>


                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    <script type="text/javascript">
        // AJAXs
    function viewdata(){
       $.ajax({
	   type: "GET",
	   url: "./phps/displayMission.php"
      }).done(function( data ) {
	  $('#missiondiplayer').html(data);
         
      });
    }
    $('#CreateMission').click(function(){
	
	var missionName = $('#missionN').val();
	var teamID = $('#teamid').val();
	var missionDetails = $('#missionDt').val();
	var latitude = $('#mLat').val();
        var longitude = $('#mLong').val(); 
	
	var datas="missionN="+missionName+"&teamid="+teamID+"&missionD="+missionDetails+"&mLat="+latitude+"&mLong="+longitude;
      
	$.ajax({
	   type: "POST",
	   url: "./phps/create_mission.php",
	   data: datas
	}).done(function( data ) {
	  $('#info').html(data);
          viewdata();
	});
    });
    function updatedata(){

	var id = $('#Uid').val();
	var mn = $('#UMissionN').val();
	var teid = $('#teamid').val();
	var msd = $('#UmissionDt').val();
	var lat = $('#Ulat').val();
        var long = $('#Ulong').val();
	
	var datas="mn="+mn+"&teid="+teid+"&msd="+msd+"&long="+long+"&lat="+lat;
      
	$.ajax({
	   type: "POST",
	   url: "./phps/updateMission.php?id="+id,
	   data: datas
	}).done(function( data ) {
	  $('#info').html(data);
	  viewdata();
          
	});
    }
    function updatefill(str,miname,lat,long,dts){ //,miname,lat,long,dts
        
         document.getElementById("Uid").value = str;
         document.getElementById("UMissionN").value = miname;
         document.getElementById("UmissionDt").value = dts;
         document.getElementById("Ulat").value = lat;
         document.getElementById("Ulong").value = long;
           var mapUpdate = {
                    center: new google.maps.LatLng(lat,long),
                    zoom: 5,
                    mapTypeId: google.maps.MapTypeId.SATELLITE


                };
                latn=google.maps.LatLng(lat,long);
                var mapU = new google.maps.Map(document.getElementById("Umap"), mapUpdate);
                    $("#myMissionUModal").on("shown.bs.modal", function () {
                    var currentCenter = mapU.getCenter();

                    google.maps.event.trigger(mapU, "resize");
                    mapU.setCenter(currentCenter);
                });
                //clicking the Create Mission Map
                var marker;
                //listener to drad
                 

                google.maps.event.addListener(mapU, "click", function (e) {

                    //lat and lng is available in e object
                    var latLng = e.latLng;

                    document.getElementById("Ulat").value = latLng.lat();
                    document.getElementById("Ulong").value = latLng.lng();
                    if (marker) {
                        marker.setPosition(latLng);
                        google.maps.event.addListener(marker, 'dragend', function (event) {
                            document.getElementById("Ulat").value = this.getPosition().lat();
                            document.getElementById("Ulong").value = this.getPosition().lng();
                        });
                    }
                    else {
                        marker = new google.maps.Marker({
                            map: mapU,
                            position: latLng,
                            draggable: true

                        });
                    }

                });
                    
    }
    function deletedata(str){
	
	var id = str;
      
	$.ajax({
	   type: "GET",
	   url: "./phps/deleteMission.php?id="+id
	}).done(function( data ) {
	  $('#info').html(data);
	  viewdata();
	});
    }
    </script>

    
    
    
    
    
    
    
    
    </body>
</html>
