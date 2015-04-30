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
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                  <?php
            // uncomment the 2 lines below to get real data from the db
                   $sql = "SELECT * FROM mission";
                    $result = $mysqli->query($sql);
             
            while($row = $result->fetch_assoc()){
                $i=$row['id'];
                
                echo "addMarker(new google.maps.LatLng(".$row['latitude'].", ".$row['longitude']."), map,".(string)$i.");";
               
            }
                ?>
                    
            }
            function addMarker(latLng, maps,missid) {
                //define an image
           var image = 'http://maps.google.com/mapfiles/kml/pal5/icon44.png';
            var marker = new google.maps.Marker({
                position: latLng,
                map: maps,
                draggable: false, // enables drag & drop
                animation: google.maps.Animation.DROP,
                title: "Mission id : "+missid,
                icon: image
                
            });
             var infowindow = new google.maps.InfoWindow({
                       
                        content: "contentString"
                });    
                
                    
            google.maps.event.addListener(marker, 'click', function() {
               
                infowindow.open(maps,marker);
                
                setTimeout(function () { infowindow.close(); }, 4000);
                
            
            });
           
           
            

                
            
            
            

            return marker;
            
        }
            
        </script>
    </head>

    <body onload="initialize()" style="height: 100%;">
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
                        <div class="col-md-12 column" style="background-color:lavender;height: 80%;" >



                            <table class="table table-hover table-condensed">
                                <?php
                                displaytable($mysqli, "mission");
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
                            <h2>Mission Details</h2>
                             <div id="googleMap" style="width:100%;height:500px;"></div>
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
    </body>
</html>
