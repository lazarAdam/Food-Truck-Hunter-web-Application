<?php

function get_food_truck_info($id){
    // connect to the database, probably should not be hardcoded
    include('../db.php');
    $query = "SELECT * FROM food_truck where foodtruckid='$id'";
    $results = $db->query($query);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, query failed.";
        exit();
    }
    $num_query_results = $results->num_rows;
    if ($num_query_results == 0){
        // no results from the successful search
        printf("Error, No matching food trucks found. From query where id: %s", $id);
        exit();
    }

    // fetch first row from query. From the first row, ignore all key value pairs that are simply integers/numeric values
    // ie: 1: food-truck-name, 2: food-truck-id
    $output = array();
    $row = $results->fetch_array();
    foreach ($row as $key => $value){
        if (is_numeric($key) == false){
            $output[$key] = $value;
        }
    }

    //$output[] = $row; // to printout the entire contents of the row

//    foreach($rows as $row) {
//        printf("%s - %s - %s - %s - %s<br>", $row['foodtruckid'], $row['name'], $row['description'], $row['latitude'], $row['longitude']);
//    }

    header('Content-Type: application/json');
    echo json_encode($output, JSON_PRETTY_PRINT);
    $db->close();
}

// REST API stuff -- call example: /get_food_truck_info.php?id=[id]
if (isset($_GET['id'])){
    get_food_truck_info($_GET['id']);
} else {
    echo "Error, unable to query database. Missing parameter. Example: /get_food_truck_info.php?id=[id]";
}
?>