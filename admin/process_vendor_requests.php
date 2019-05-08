<?php
/**
 * Created by PhpStorm.
 * User: kyle.henson
 * Date: 4/26/2019
 * Time: 1:00 PM
 */
include "../db.php";
// Takes raw data from the request
# Get as an object
$json_obj = json_decode($_POST['vendor_json']);
$array = json_decode(json_encode($json_obj), true);
$admin_logged_in = $_SESSION['admin_logged_in'] ?? ''; //suppress index error
// check for admin not working
if (isset($admin_logged_in)) {
    $last = count($array) - 1;
// foreach array in multidimensional array update status in row
    foreach ($array as $i => $row){
        $isFirst = ($i == 0);
        $isLast = ($i == $last);
        $status = $row['status'];
        $vendorid = $row['vendorid'];
        if($status === 'approved'){
            $query = "UPDATE VENDOR_REQUEST SET status='approved' where vendorid=".$vendorid;
            mysqli_query($db, $query);
        }
        if($status === 'denied'){
            $query = "UPDATE VENDOR_REQUEST SET status='denied' where vendorid=".$vendorid;
            mysqli_query($db, $query);
        }
    }
}
