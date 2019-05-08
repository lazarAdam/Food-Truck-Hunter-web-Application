<?php

function get_special_filter_data(){
    // connect to the database, probably should not be hardcoded
    include('../db.php');
    $query = "SELECT * FROM FoodTruckHunter.SPECIAL_FOOD_TYPE";
    $results = $db->query($query);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, query failed.";
        exit();
    }
    $num_query_results = $results->num_rows;
    if ($num_query_results == 0){
        // no results from the successful search
        echo "Error, Special Food Type table appears to be empty";
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


    while($row = $results->fetch_array()) {
        $rows[] = [
            'id' => $row['foodtypeid'],
            "food_type_name" => $row['food_type_name'],
            "creation_date" => $row['creation_date'], //last_update_date
            "last_update_date" => $row['last_update_date']
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($rows, JSON_PRETTY_PRINT);
    $db->close();
}

get_special_filter_data();
?>