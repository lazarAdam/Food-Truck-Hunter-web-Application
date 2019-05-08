<?php
/**
 * Created by PhpStorm.
 * User: Kyle.henson
 * Date: 4/11/2019
 * Time: 8:03 PM
 */

$db = mysqli_connect('127.0.0.1', 'root', 'Notaproblem@', 'FoodTruckHunter');
if (mysqli_connect_errno()){
    echo "Error, Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}