<?php

function createLotsOfFoodTrucks($prefix, $numTrucks){
    include('db.php');
    $baseLat = 44.977;
    $baseLong = -93.265;

    for ($i = 1; $i <= $numTrucks; $i++){
        $truckName = $prefix . "-" . $i;
        $lat = $baseLat + rand(0, 100)*0.01 - 0.5; // baselat + random number -0.5 to 0.5
        $long = $baseLong + rand(0, 100)*0.01 - 0.5;
        $query = "INSERT INTO food_truck (name, description, latitude, longitude, FT_main_pic_path) 
                            VALUES('$truckName', 'Description', '$lat', '$long', 'NULL')";
        $result = $db->query($query);
        if ($result == false){
            echo "Failed to create food truck " . $truckName . '<br>';
        } else {
            echo "Created " . $truckName . " at " . $lat . " " . $long . '<br>';
        }
    }
}

createLotsOfFoodTrucks("DemoTruck", 100);
?>