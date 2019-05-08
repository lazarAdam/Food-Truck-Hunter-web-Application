<?php

function get_nearby_food_trucks($latitude, $longitude, $radius){
    // connect to the database, probably should not be hardcoded
    include('../db.php');
    $query = "SELECT *, ("
        . "3959 * acos ("
        . "cos ( radians($latitude) ) "
        . "* cos( radians( latitude ) ) "
        . "* cos( radians( longitude ) - radians($longitude) ) "
        . "+ sin ( radians($latitude) ) "
        . "* sin( radians( latitude ) ) ) "
        . ") AS distance FROM food_truck HAVING distance < $radius ORDER BY distance LIMIT 20";
    $results = $db->query($query);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, query failed.";
        exit();
    }
    $num_query_results = $results->num_rows;
    if ($num_query_results == 0){
        printf("Error, No matching food trucks found. From query: Latitude: %s Longitude: %s Radius: %s",
                $latitude, $longitude, $radius);
        exit();
    }

    while($row = $results->fetch_array()) {
        $rows[] = [
            'id' => $row['foodtruckid'],
            "name" => $row['name'],
            "description" => $row['description'],
            "latitude" => $row['latitude'],
            "longitude" => $row['longitude'],
            "main_pic_path" => $row['FT_main_pic_path']
        ];
        //$rows[] = $row; // to printout the entire contents of the row
    }

//    foreach($rows as $row) {
//        printf("%s - %s - %s - %s - %s<br>", $row['foodtruckid'], $row['name'], $row['description'], $row['latitude'], $row['longitude']);
//    }

    header('Content-Type: application/json');
    echo json_encode($rows, JSON_PRETTY_PRINT);
    $db->close();
}

// REST API stuff -- call example: /get_nearby_food_trucks.php?lat=123&long456&radius=5
if (isset($_GET['lat'])
    && isset($_GET['long'])
    && isset ($_GET['radius'])){
    get_nearby_food_trucks($_GET['lat'], $_GET['long'], $_GET['radius']);
} else{
    echo "Error, unable to query database. Missing one or more parameters. 
          Example: /get_nearby_food_trucks.php?lat=[lat]&long=[long]&radius=[radius]";
}
?>