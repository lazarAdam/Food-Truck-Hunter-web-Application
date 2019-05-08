<?php

function updateFoodTruckLocation($foodTruckID, $oldLat, $oldLong, $newLat, $newLong){
    // connect to the database, probably should not be hardcoded
    include('../db.php');
    $query = "SELECT * FROM food_truck WHERE foodtruckid=$foodTruckID AND latitude=$oldLat AND longitude=$oldLong";
    $results = $db->query($query);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, test query failed.";
        exit();
    }
    $num_query_results = $results->num_rows;
    if ($num_query_results == 0){
        printf("Error, No matching food trucks found. From query: id: %s oldLat: %s oldLong: %s",
                $foodTruckID, $oldLat, $oldLong);
        exit();
    }
    // food truck info is valid, update it with the new lat and long values
    $updateQuery = "UPDATE food_truck SET latitude=$newLat, longitude=$newLong WHERE foodtruckid=$foodTruckID";
    $results = $db->query($updateQuery);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, update query failed.";
        exit();
    }
    $json[] = [
        'message' => "Food Truck location successfully updated.",
    ];
    header('Content-Type: application/json');
    echo json_encode($json, JSON_PRETTY_PRINT);
    $db->close();
}

// REST API stuff -- call example: /update_food_truck_location.php?id=1&oldLat=123&oldLong=456&newLat=111&newLong=222
if (isset($_GET['id'])
    && isset($_GET['oldLat'])
    && isset($_GET['oldLong'])
    && isset ($_GET['newLat'])
    && isset ($_GET['newLong'])){
    updateFoodTruckLocation($_GET['id'], $_GET['oldLat'], $_GET['oldLong'], $_GET['newLat'], $_GET['newLong']);
} else{
    echo "Error, unable to update food truck location. Missing one or more parameters. 
          Example: /update_food_truck_location.php?id=[ID]&oldLat=[OldLat]&oldLong=[OldLong]&newLat=[NewLat]&newLong=[NewLong]";
}
?>