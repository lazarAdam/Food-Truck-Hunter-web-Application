var map, infoWindow;
var infoWindowArray = Array();
var markerArray = Array();
var activeInfoWindows = Array();

//options for routing purposes
//advanced options - used for routing purposes
const modes={
    walk:'WALKING',
    bike:'BICYCLING',
    car:'DRIVING',
    pub:'TRANSIT'
};
const advReqOptions={
    provideRouteAlternatives:true,
    avoidFerries:true,
    avoidHighways:true,
    avoidTolls:true
};


//additional options
let options= null ;
let routeoptions=null;
var userPos = null;
var pos = null;


function initMap() {
    var metroloc = {lat: 44.977, lng: -93.265};

    map = new google.maps.Map(document.getElementById('map'), {
        center: metroloc,
        zoom: 12
    });
    infoWindow = new google.maps.InfoWindow;

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            var userPos = google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            infoWindow.setPosition(pos);
            infoWindow.setContent("<div id='info-window'>Location found.</div>");
            infoWindow.open(map);
            //map.setCenter(pos);
            //if user is not within range -- output error! if user is not within 10 miles of city limits
            if (validateUserInMetroRegion(pos.lat, pos.lng, 30)) {
                console.log('You are within 5 mile range!');
                //infoWindow.setContent('You are not within 5 mile range!');
                var marker = new google.maps.Marker({position: userPos, map: map});
            }
            else {
                document.getElementById("myNav").style.width = "100%";
                //console.log('You are not within 5 mile range!');
            }

        }, function () {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }

    // 1.5 seconds later load the food trucks from the api and begin plotting them on the map
    // needs to be done 1+ seconds later because otherwise the map has not fully loaded
    setTimeout(function(){
        loadNearbyFoodTrucks(pos.lat, pos.lng, 30);
    }, 1500);

    //function loads and creates filter controls dynamically after map loads
    loadSpecialFoodTypeFilters();

    //create the objects required for the directions calculations
    oDir=new google.maps.DirectionsService();
    oDisp=new google.maps.DirectionsRenderer( routeoptions );
    oTraf=new google.maps.TrafficLayer();

    options= {
        zoom: 16,
        center:metroloc,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    routeoptions={
        suppressMarkers:true,
        draggable:false,
        map:map
    };

}

function addFoodTrucksToMap(foodTruckArray){
    console.log("fetched " + foodTruckArray.length + " food trucks from api");
    console.log(foodTruckArray);
    if (foodTruckArray == null){
        return; // no food trucks were able to be loaded (food truck table may be empty)
    }

    for (var i = 0; i < foodTruckArray.length; i++) {
        var foodTruck = foodTruckArray[i];
        if (foodTruck.latitude == null || foodTruck.latitude === "NULL" || foodTruck.longitude == null
            || foodTruck.longitude === "NULL"){
            console.log("Food Truck " + foodTruck.name + " (" + i + ") has no latitude or longitude! Skipping...");
            continue;
        }

        var foodTruckString = "<p id='info-window' style='max-width:250px; word-wrap:break-word'>";
        if (foodTruck.main_pic_path == null || foodTruck.main_pic_path === "NULL"){
            foodTruckString += "<img style=\"height:75px\" src=\"/images/logo_small.png\"><br>";
        } else {
            foodTruckString += "<img style=\"height:75px\" src=\"/images/" + foodTruck.main_pic_path + "\"><br>";
        }
        foodTruckString += "<b>" + foodTruck.name + "</b><br>" + foodTruck.description + "<br>"
            + "<button id=\"btn1\""
            + " onclick=\"updateFoodTruckLocation(" + foodTruck.id + ", " + foodTruck.latitude + ", "
            + foodTruck.longitude + ", \'" + foodTruck.name.replace(/['"]+/g, '') + "\')\">Update Location</button></p>";
        var infoWindow = new google.maps.InfoWindow({
            content: foodTruckString
        });
        infoWindowArray.push(infoWindow);

        // create marker and location on the map
        var markerLocation = {lat: parseFloat(foodTruck.latitude), lng: parseFloat(foodTruck.longitude)};
        var marker = new google.maps.Marker({
            position: markerLocation,
            map: map,
            title: foodTruck.name
        });
        markerArray.push(marker);

        /*
          setup the info window to open when the marker is clicked or hovered. Works my keeping track of the
          windows that are currently open (pins that were clicked) so that they don't disappear when the user
          hovers over something else
         */
        google.maps.event.addListener(marker, "click", (function(marker, i){
            return function(){
                if (!activeInfoWindows.includes(infoWindowArray[i])) {
                    activeInfoWindows.push(infoWindowArray[i]); // add to displayed list
                }
                infoWindowArray[i].open(map, marker); // display this window
                //add event listener to execute routing to food truck location
                routeUserToFoodTruck(pos, marker.position, i);
            }
        })(marker, i));
        google.maps.event.addListener(infoWindow, "closeclick", (function(infoWindow, i){
            return function(){
                if (activeInfoWindows.includes(infoWindowArray[i])) {
                    removeElementFromArray(activeInfoWindows, infoWindowArray[i]); // remove from displayed list
                }
            }
        })(marker, i));
        google.maps.event.addListener(marker, "mouseover", (function(marker, i){
            return function(){
                infoWindowArray[i].open(map, marker); // display this window temporarily (don't add to list)
            }
        })(marker, i));
        google.maps.event.addListener(marker, "mouseout", (function(marker, i){
            return function(){
                if (!activeInfoWindows.includes(infoWindowArray[i])) {
                    infoWindowArray[i].close(map, marker);
                }
            }
        })(marker, i));

        // open the info windows by default (if less than 10 food trucks on the map)
        if (foodTruckArray.length <= 10){
            infoWindowArray[i].open(map, marker);
            activeInfoWindows.push(infoWindowArray[i]); // add to displayed list
        }

        // put the marker on the map
        marker.setMap(map);
    }
    console.log("loaded " + foodTruckArray.length + " food trucks onto the map");
}

function routeUserToFoodTruck(userloc, ftloc, idxOfInfoWindow) {
    //from code
    //first -- lets 'adapt' our var params to ones in the code from stack overflow:
    let location={
        lat: parseFloat( userloc.lat),//
        lng: parseFloat( userloc.lng )
    };
    //var userPos = google.maps.LatLng(position.coords.latitude, position.coords.longitude);

    let destination = ftloc

    /*options for the map -- to be done for routing processes*/
    // let options= {
    //     zoom: 16,
    //     center:location,
    //     mapTypeId: google.maps.MapTypeId.ROADMAP
    // };
    // let routeoptions={
    //     suppressMarkers:true,
    //     // draggable:true,
    //     map:map
    // };

    /* construct the initial request */
    oReq={
        origin:location,
        destination:destination,
        travelMode:modes.walk
    };

    /* go get the directions... */
    oDisp.setMap( map );
    oTraf.setMap( map );
    //infoWindowArray[idxOfInfoWindow].getContent().style.display='block';

    // oDisp.setPanel( infoWindowArray[idxOfInfoWindow].getContent() );// oDisp.setPanel( infoWindow.getContent() );
    oDir.route( Object.assign( oReq, advReqOptions ), callback );
}

/* process the route response */
const callback=function(r,s){
    if( s === 'OK' ) oDisp.setDirections( r );
    else evtGeoFailure( s );
}

const evtGeoFailure=function(e){ console.info( 'you broke the internets: %s', e ) };

function removeElementFromArray(array, element){
    array.splice(array.indexOf(element), 1);
}

function updateFoodTruckLocation(foodTruckID, oldLat, oldLong, foodTruckName){
    // confirm message
    if (!confirm("Are you sure you want to update " + foodTruckName + "'s Location to your current location?")){
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

function loadAllFoodTrucks(){
    /*
     * load the contents from the get_all_food_trucks.php json api and parse the returned data into individual
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
        foodTruckArray = Array();

        $(data).each(function(index, value){
            foodTruckArray.push(value); // push food truck object onto food truck array
        });

        addFoodTrucksToMap(foodTruckArray);
    });

    // request.fail called if the request fails (ie wrong data type; html instead of json)
    request.fail(function(){
        $("#error-message").text("Error: Failed to fetch list of food trucks from json api. Food Truck table may be empty...");
        return null;
    });
}

function loadNearbyFoodTrucks(latitude, longitude, radius){
    /*
     * load the contents from teh get_all_food_trucks.php json api and parse the returned data into individual
     * food truck objects. Call addFoodTruckToPage on each food truck object to append them to the page's list
     */
    // example url: http://localhost:8080/api/get_nearby_food_trucks.php?lat=44.977&long=-93.265&radius=5
    var urlBase = "/api/get_nearby_food_trucks.php";
    var urlExtension = "?lat=" + latitude + "&long=" + longitude + "&radius=" + radius;
    var queryUrl = urlBase + urlExtension;
    var request = $.ajax({
        url: queryUrl,
        method: "get",
        dataType: "json",
        cache: false
    });

    // request.done called when the request is fulfilled
    request.done(function(data){
        foodTruckArray = Array();

        $(data).each(function(index, value){
            foodTruckArray.push(value); // push food truck object onto food truck array
        });

        addFoodTrucksToMap(foodTruckArray);
    });

    // request.fail called if the request fails (ie wrong data type; html instead of json)
    request.fail(function(){
        $("#error-message").text("Error: Failed to fetch list of food trucks from json api. Food Truck table may be empty...");
        return null;
    });
}




function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

function validateUserInMetroRegion(lat, long, radius) {
    //console.log('validateUserInMetroRegion!');

    // src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbAxJGrLanCMmCCXsfRc-cqRWsPUCCn94&callback=initMap"
    //var point =
    //var userLoc = {lat: lat, lng: long};
    //center -- will be location of metro area -- hard coded for now
    //var metroloc = {lat: 44.977, lng: -93.265};
    var userLoc_goog = new google.maps.LatLng(lat, long);
    var metroLoc_goog = new google.maps.LatLng(44.977, -93.265);
    console.log('Distance = ' + google.maps.geometry.spherical.computeDistanceBetween(userLoc_goog, metroLoc_goog));

    //console.log("lat = " + lat + "long = " + long);
    //console.log("userLoc_goog = " + userLoc_goog);
    //console.log("metroLoc_goog = " + metroLoc_goog);

    //code below from: https://stackoverflow.com/questions/14598426/how-to-detect-if-a-point-is-in-a-circle
    return (google.maps.geometry.spherical.computeDistanceBetween(userLoc_goog, metroLoc_goog) <= radius * 1609.34);
    /*
    *
    * function calcDistance (fromLat, fromLng, toLat, toLng) {
          return google.maps.geometry.spherical.computeDistanceBetween(
          new google.maps.LatLng(fromLat, fromLng), new google.maps.LatLng(toLat, toLng));
    }
    * */
    // return (google.maps.geometry.spherical.computeDistanceBetween(point, center) <= radius)
}

//loading filters
function loadSpecialFoodTypeFilters(){
    /*
     * load the contents from teh get_all_food_trucks.php json api and parse the returned data into individual
     * food truck objects. Call addFoodTruckToPage on each food truck object to append them to the page's list
     */
    var request = $.ajax({
        url: "/api/get_special_filter_data.php",
        method: "get",
        dataType: "json",
        cache: false
    });

    // request.done called when the request is fulfilled
    request.done(function(data){
        specialFoodFilterArray = Array();//foodTruckArray = Array();

        $(data).each(function(index, value){
            specialFoodFilterArray.push(value); // push food truck object onto food truck array
        });

        //addFoodTrucksToMap(foodTruckArray);
        //return specialFoodFilterArray;
        //console.log("loadSpecialFoodTypeFilters SIZE =  "+ specialFoodFilterArray.length);

        console.log("loadSpecialFoodTypeFilters: filters =  "+ specialFoodFilterArray);

        createControls(specialFoodFilterArray);
    });

    // request.fail called if the request fails (ie wrong data type; html instead of json)
    request.fail(function(){
        $("#error-message").text("Error: Failed to fetch list of food trucks from json api. Food Truck table may be empty...");
        return null;
    });
}

function loadSpecialFoodTruckWithFilterData(){
    /*
     * load the contents from teh get_all_food_trucks.php json api and parse the returned data into individual
     * food truck objects. Call addFoodTruckToPage on each food truck object to append them to the page's list
     */
    var request = $.ajax({
        url: "/api/get_food_trucks_with_filter_data.php",
        method: "get",
        dataType: "json",
        cache: false
    });

    var foodTrucksWithFilterData = new Array();
    // request.done called when the request is fulfilled
    request.done(function(data){
        //var foodTrucksWithFilterData = new Array();//new Object();//Array();//foodTruckArray = Array();

        $(data).each(function(index, value){
            foodTrucksWithFilterData.push(value); // push food truck object onto food truck array
        });

        //addFoodTrucksToMap(foodTruckArray);
        console.log("loadSpecialFoodTruckWithFilterData: food trucks =  "+ foodTrucksWithFilterData);

        //return foodTrucksWithFilterData;
    });

    // request.fail called if the request fails (ie wrong data type; html instead of json)
    request.fail(function(){
        $("#error-message").text("Error: Failed to fetch list of food trucks from json api. Food Truck table may be empty...");
        return null;
    });

    //         return foodTrucksWithFilterData;
}

///from github tutorial: https://github.com/ericjames/google-maps/blob/master/marker-toggle/marker-multi-toggle.html
function createControls(specialFoodFilterArray) {
    // var specialFoodFilterArray =  Array();
    // specialFoodFilterArray  = loadSpecialFoodTypeFilters();

    console.log('createControls: specialFoodFilterArray length = ' + specialFoodFilterArray.length);

    var html = "";
    //console.log('createControls: specialfoodArray[0].food_type_name = ' + specialFoodFilterArray[0].food_type_name );

    for (var id in specialFoodFilterArray) {
        /*
        * IDs of filters:
        * 1 - Vegetarian
        * 2 - Vegan
        * 3 - Paleo
        * 4 - Keto
        * 5 - Dairy-free
        * 6 - Nut-free
        * */
        console.log('createControls: specialfoodArray id = ' + id);
        var filter = specialFoodFilterArray[id];
        //console.log('###createControls: filter  = ' + filter.food_type_name);

        //changed onclick to onchange -- so it doesnt call the togglecontorl command twice -- fixes the mulitple query call
        html += '<li style="list-style-type:none;"><a class="selected" href="#" id="' + id + '" onchange="toggleControl(this); return false /*false*/">' +
            '<input onchange="inputClick(this)" type="checkbox" checked id="' + id + '" value = " ' + filter.food_type_name + ' " />' + filter.food_type_name + '</a></li>';

        //  html += '<li><a class="selected" href="#" id="' + id + '"  onclick="toggleControl(this); return false">' +
        //      '<input onclick="inputClick(this)" type="checkbox" checked id="' + id + ' value=filter.food_type_name />' + filter.food_type_name + '</a></li>';
    }
    document.getElementById("controls").innerHTML = html;
};

// Toggle class, checkbox state, and marker visibility
function toggleControl(control) {
    var checkbox = control.getElementsByTagName("input")[0];
    /*console.log('toggleControl: MarkerArray.length = ' + markerArray.length);
    console.log('toggleControl: MarkerArray= ' + markerArray);
    console.log('toggleControl: checkbox = ' + checkbox);
    console.log('toggleControl: checkbox ID = ' + checkbox.id);*/

    //below checkbox.value gives value stored within checkbox
    console.log('toggleControl: checkbox VALUE = ' + checkbox.value);

    /*Based on checkbox -- make query to get list of food truck objects based on checkbox-filter-value*/
    var shop = markerArray[0];
    //console.log("marker name (ie food truck name) =  " + shop.title);

    // var preFilterValue = $.trim(checkbox.value)
    var filterValue =  $.trim(checkbox.value)//checkbox.value;

    var urlBase = "/api/get_food_trucks_with_filter_data.php?";
    var urlExtension = "filter=" + filterValue;
    var queryUrl = urlBase + urlExtension;
    /*Make function to get all the food trucks associated with the particular marker that was clicked*/
    /*Ie -- if VEGAN selected -- get list of food truck and associated marker (based on the nearby food truck list)*/
    var request2 = $.ajax({
        //get_food_trucks_with_filter_data($inputFilterAttribute)
        //url: "/api/get_special_filter_data.php",
        url: queryUrl,
        //data: ({filter: filterValue}),
        method: "get",
        dataType: "json",
        cache: false
    });

    foodTrucksWithFilterType = Array();//foodTruckArray = Array();


    // request.done called when the request is fulfilled
    request2.done(function(data){
        $(data).each(function(index, value){
            foodTrucksWithFilterType.push(value); // push food truck object onto food truck array
        });

        //addFoodTrucksToMap(foodTruckArray);
        //return specialFoodFilterArray;
        //console.log("loadSpecialFoodTypeFilters SIZE =  "+ specialFoodFilterArray.length);

        //debugging
        /* console.log("toggleControl: foodtrucks list =  "+ foodTrucksWithFilterType);
         for (i = 0; i < foodTrucksWithFilterType.length; i++) {
             var foodTruck = foodTrucksWithFilterType[i];

                 console.log("Food Truck " + foodTruck.name + " [" + i + "]=" + foodTruck.name + " filterValue =" + foodTruck.foodtypename);
                 continue;
         }*/
        //createControls(foodTrucksWithFilterType);
        if (checkbox.checked == true) {
            checkbox.checked = false;
            control.className = "normal";
            //shop.setVisible(false); // If you have hundreds of markers use setMap(map)


            //insert here
            for (i = 0; i < markerArray.length; i++) {//markerArray
                for (j = 0; j < foodTrucksWithFilterType.length; j++) {
                    if(markerArray[i].title == foodTrucksWithFilterType[j].name) {
                        //if the marker is selected under a different checkbox -- then keep the checkbox checked -- but how??
                        console.log("markerArray[i].title" + markerArray[i].title + " foodTrucksWithFilterType[j].name =" + foodTrucksWithFilterType[j].name);
                        markerArray[i].setVisible(false);
                        infoWindowArray[i].close(map, markerArray[i]);

                    }
                    //continue;
                    // else
                    //console.log("&&&&&& Skipped !&&&&&");
                }
            }//end

            //infoWindowArray[0].close(map, shop);
            // shop.set
        } else {
            checkbox.checked = true;
            control.className = "selected";
            for (i = 0; i < markerArray.length; i++) {//markerArray
                for (j = 0; j < foodTrucksWithFilterType.length; j++) {
                    if(markerArray[i].title == foodTrucksWithFilterType[j].name) {
                        // console.log("arkerArray[i].title" + markerArray[i].title + " foodTrucksWithFilterType[j].name =" + foodTrucksWithFilterType[j].name +);
                        markerArray[i].setVisible(true);
                        // infoWindowArray[0].close(map, markerArray[i]);
                        infoWindowArray[i].open(map, markerArray[i]);

                    }
                    //continue;
                    // else
                    //console.log("&&&&&& Skipped !&&&&&");
                }
            }
            // shop.setVisible(true); // Similarly use setMap(null)
            // infoWindowArray[0].open(map, shop);

        }


    });

    // request.fail called if the request fails (ie wrong data type; html instead of json)
    request2.fail(function(){
        console.log("inner toggle Error: Failed to fetch list of food trucks from json api. Food Truck table may be empty...");
        // $("#error-message").text("inner toggle Error: Failed to fetch list of food trucks from json api. Food Truck table may be empty...");
        return null;
    });
    //end of getting food trucks -- functionality


    // open the info windows by default
    //infoWindowArray[0].close(map, marker);

    //loop through all the markers -- if the marker is in foodTrucksWith FilterType -- set to true
    /*
    * for all markers:
    *   for all foodtruckswithfiltertype:
    *        if marker[k].title == foodtruckswithfiltertype[i].name
    *           { //marker[k].setVisible(false) }
    * */
    //PUT THE CHECK CODE HERE
    //  END HERE
};

//set from click to CHANGE rather than click
// In this case we are keeping the input box for accessibility purposes, so we bubble up the click event to the parent control
function inputClick(input) {
    input.parentElement.onchange();//click();
};