<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Food Truck List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href ="style/Nav.css" type="text/css" media= "all" />
    <link rel = "stylesheet" href ="style/footer.css" type="text/css" media= "all" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <br>
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("navigation.php");</script>
</div>
<div class="content">
    <fieldset style="margin-bottom: 70px;">
    <h3>Food Truck List</h3>
    <div id="food-truck-list"></div>
    <div class="container-fluid" id="bk2"></div>
    <script>
        var pos = null;

        // append the passed food truck to the page's food-truck-list div
        function addFoodTruckToPage(foodTruck){
            var html = "<div style='text-align:center; font-family: arial' class='food-truck'>";
            if (foodTruck.main_pic_path == null || foodTruck.main_pic_path === "NULL"){
                html += "<img style=\"height:200px\" src=\"/images/logo_small.png\"><br>";
            } else{
                html += "<img style=\"height:200px\" src=\"/images/" + foodTruck.main_pic_path + "\"><br>";
            }

            html += ("<b>" + foodTruck.name + "</b><br>"
                + foodTruck.description + "<br>"
                + "Latitude: " + foodTruck.latitude + "<br>"
                + "Longitude: " + foodTruck.longitude + "<br>"
                + "Id: " + foodTruck.id + "<br>"
                + "<button id=\"btn1\" onclick=\"updateFoodTruckLocation(" + foodTruck.id + ", " + foodTruck.latitude
                + ", " + foodTruck.longitude + ", \'" + foodTruck.name.replace(/['"]+/g, '') + "\')\">Update Location</button>"
                + "<hr><br></div>");

            $("#food-truck-list").append(html);
        }

        // append no food trucks found error message to food-tuck-list div
        function notifyNoFoodTrucksFound(){
            $("#food-truck-list").append("<div class='food-truck'>"
                + "<b style=\"color: red\">Error, No Food Trucks found in database!</b><br></div>");
        }

        function updateFoodTruckLocation(foodTruckID, oldLat, oldLong, foodTruckName){
            // confirm message
            if (!confirm("Are you sure you want to update " + foodTruckName + "'s Location to your current location?")){
                return;
            }
            if (pos == null){
                alert("You must allow access to your browser location to use this feature!");
                return;
            }

            /*
             * Update a food truck's location with the user's current location
             */
            // example url: /update_food_truck_location.php?id=1&oldLat=123&oldLong=456&newLat=111&newLong=222
            // add a little variance to the new lat and long (in case multiple locations are updated to the same location)
            // this way the different pins can still be clicked when zoomed in far enough
            var newLat = pos.lat + Math.random()*0.001-0.0005;
            var newLong = pos.lng + Math.random()*0.001-0.0005;
            var urlBase = "/api/update_food_truck_location.php";
            var urlExtension = "?id=" + foodTruckID + "&oldLat=" + oldLat + "&oldLong=" + oldLong + "&newLat=" + newLat + "&newLong=" + newLong;
            var queryUrl = urlBase + urlExtension;
            var request = $.ajax({
                url: queryUrl,
                method: "get",
                dataType: "json",
                cache: false
            });

            // request.done called when the request is fulfilled
            request.done(function(){
                document.location.reload(true); // force the page to reload so the map updates
                console.log("Updated food truck location");
            });

            // request.fail called if the request fails (ie wrong data type; html instead of json)
            request.fail(function(){
                alert("Failed to update food truck location");
            });
        }

        /*
         * load the contents from teh get_all_food_trucks.php json api and parse the returned data into individual
         * food truck objects. Call addFoodTruckToPage on each food truck object to append them to the page's list
         */
        var request = $.ajax({
            url: "/api/get_all_food_trucks.php",
            method: "get",
            dataType: "json",
            cache: false
        });

        // request.done called when the request is fulfilled
        request.done(function(data){
            var numTrucks = 0;
            $(data).each(function(index, value){
                numTrucks++;
                addFoodTruckToPage(value);
                console.log(value); // log out the individual json object to the console
            });
            console.log(data); // log out the whole json array contents to console
            // update the blur background size depending on number of trucks added
            var size = 450*numTrucks;
            $("#bk2").css("height", size);
        });

        // request.fail called if the request fails (ie wrong data type; html instead of json)
        request.fail(function(){
            notifyNoFoodTrucksFound();
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function updatePosition(position){
                pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                }
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }


        /*
        * old way of fetching data from json file:
        $.getJSON('/api/get_all_food_trucks.php', function(data){
            $(data).each(function(index, value){
                addFoodTruckToPage(value);
                console.log(value); // log out the individual json object to the console
            });
            console.log(data); // log out the whole json array contents to console
        });
         */
    </script>
    </fieldset>
</div>
<div class="footer">
    <div id="footer-text"></div>
    <script>$("#footer-text").load("footer.html");</script>
</div>
</body>
</html>