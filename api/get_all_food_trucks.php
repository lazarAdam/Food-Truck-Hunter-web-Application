<?php
function get_all_food_trucks(){
    // connect to the database, probably should not be hardcoded
    include('../db.php');
    $query = "SELECT * FROM food_truck";
    $results = $db->query($query);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, query failed.";
        exit();
    }

    $num_query_results = $results->num_rows;
    if ($num_query_results == 0){
        echo "Error, Food Truck Request table appears to be empty";
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

get_all_food_trucks();

// REST API stuff -- not done -- not needed for this api -- call example: /get_all_food_trucks.php?lat=123&long456
/*
if (isset($_GET['lat'])
    && isset($_GET['long'])){
    $lat = $_GET['lat'];
    $long = $_GET['long'];
    echo "lat:" . $lat . " long:" . $long;
} else{
    echo "Error, unable to query database. Incomplete data specified.";
}
*/
// food truck php class -- didn't end up needing this for this api -- here in case we need it later
class FoodTruck{
    private $id;
    private $name;
    private $description;
    private $latitude;
    private $longitude;
    private $main_pic_path;

    public function __construct(){
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function getMainPicPath()
    {
        return $this->main_pic_path;
    }

    public function setMainPicPath($main_pic_path)
    {
        $this->main_pic_path = $main_pic_path;
    }
}
?>