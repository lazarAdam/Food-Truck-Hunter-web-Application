<?php
//I KNOW ISSUE -- YOUR INPUT WAS WRONG UGHH
//wrong: localhost:8080/api/get_food_trucks_with_filter_data.php?a=Vegan.php
//Example right: localhost:8080/api/get_food_trucks_with_filter_data.php?a=Vegan

//$userAnswer = $_POST['name'];
//echo "####get_food_trucks_with_filter_data: userAnswer = ",  $userAnswer;
function get_food_trucks_with_filter_data($inputFilterAttribute){
    // connect to the database, probably should not be hardcoded
    include('../db.php');
    //gets food trucks and their special-food-truck-type info based on intermediate table
    //$query = "SELECT * FROM food_truck";
    $query =
        "select f.*, s.* 
        from FoodTruckHunter.FOOD_TRUCK f
        inner join FoodTruckHunter.TRUCK_SPECIAL_FOOD_TYPE i on i.foodtruckid = f.foodtruckid
        inner join FoodTruckHunter.SPECIAL_FOOD_TYPE s on i.foodtypeid = s.foodtypeid
        where  food_type_name = '$inputFilterAttribute'";
    $results = $db->query($query);
    if ($results === false){
        // db query returns false if the call failed
        echo "Error, query failed.";
        exit();
    }

    $num_query_results = $results->num_rows;
    if ($num_query_results == 0){
        echo "get_food_trucks_with_filter_data　Error, Food Truck Request table appears to be empty";
        exit();
    }

    while($row = $results->fetch_array()) {
        $rows[] = [
            'id' => $row['foodtruckid'],
            "name" => $row['name'],
            "description" => $row['description'],
            "latitude" => $row['latitude'],
            "longitude" => $row['longitude'],
            "main_pic_path" => $row['FT_main_pic_path'],
            "foodtypeid" => $row['foodtypeid'],
            "foodtypename" => $row['food_type_name']

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
/*
 *
// REST API stuff -- call example: /get_nearby_food_trucks.php?lat=123&long456&radius=5
if (isset($_GET['lat'])
    && isset($_GET['long'])
    && isset ($_GET['radius'])){
    get_nearby_food_trucks($_GET['lat'], $_GET['long'], $_GET['radius']);
} else{
    echo "Error, unable to query database. Missing one or more parameters.
          Example: /get_nearby_food_trucks.php?lat=[lat]&long=[long]&radius=[radius]";
}
*/
//// REST API stuff -- call example: /get_food_trucks_with_filter_data.php?lat=123&long456&radius=5
if (isset($_GET['filter'])){
    get_food_trucks_with_filter_data($_GET['filter']);
} /*else if (isset($_POST['filter'])) {

    get_food_trucks_with_filter_data($_POST['filter'];);

}*/
else{
    echo "Error, unable to query database. Missing one or more parameters. 
          Example: /get_food_trucks_with_filter_data.php?filter=[filter]";
}

/*if(isset($_POST['filter']))
{
    $inputFilterAttribute = $_POST['filter'];
}*/

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
class FoodTruckWithFilterData{
    private $id;
    private $name;
    private $description;
    private $latitude;
    private $longitude;
    private $main_pic_path;
    private $foodtypeid;
    private $foodtypename;


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

    public function getFoodTypeId()
    {
        return $this->$foodtypeid;
    }

    public function setFoodTypeId($id)
    {
        $this->$foodtypeid = $id;
    }

    public function getFoodTypeName()
    {
        return $this->$foodtypename;
    }

    public function setFoodTypeName($name)
    {
        $this->$foodtypename = $name;
    }
}
?>