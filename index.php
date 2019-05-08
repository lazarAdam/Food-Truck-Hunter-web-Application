<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Food Truck Hunters - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/index.css" type="text/css" media= "all">
    <link rel="stylesheet" href="style/Nav.css" type="text/css">
    <link rel="stylesheet" href="style/overlay.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/map.js"></script>
    <script src="js/formScript.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbAxJGrLanCMmCCXsfRc-cqRWsPUCCn94&callback=initMap&&libraries=geometry,places">
	</script>
</head>
<body>
	</div>
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("navigation.php");</script>
    <div class="content">
        <h5 id="error-message" style="color:red"></h5>
		<div id="map"></div>
	</div>
    <!-- dynamic code, makes controls (ie filter checkboxes) dynamically via api call-->
    <div id="toggle_box">
        <div id="controls" align="left">
        </div>
    </div>

   <div id="myNav" class="overlay">
    <div class="overlay-content">
        <p>Sorry you can't use the service, your location is outside our operating area  </p>
    </div>
    </div>

    <div id="footer-text"></div>
		<script>$("#footer-text").load("footer.html");</script>
	</div>
</body>
</html>

