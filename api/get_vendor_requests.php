<?php
/**
 * Created by PhpStorm.
 * User: Kyle.henson
 * Date: 4/11/2019
 * Time: 8:02 PM
 */
function get_vendor_requests(){
    // connect to the database, probably should not be hardcoded
        include('../db.php');
        $query = "SELECT * FROM vendor_request WHERE status='pending'";
        $results = $db->query($query);
        if ($results === false){
            // db query returns false if the call failed
            echo "Error, query failed.";
            exit();
        }
        $num_query_results = $results->num_rows;
        if ($num_query_results == 0){
            echo "Error, Food Truck table appears to be empty";
            exit();
        }

        while($row = $results->fetch_array()) {
            $rows[] = [
                'id' => $row['vendorid'],
                "email" => $row['email'],
                "first_name" => $row['first_name'],
                "last_name" => $row['last_name'],
                "company_name" => $row['company_name'],
                "phone_number" => $row['phone_number'],
                "city" => $row['state'],
                "status" => $row['status'],
                "creation_date" => $row['creation_date']
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($rows, JSON_PRETTY_PRINT);
        $db->close();
}

get_vendor_requests();

?>