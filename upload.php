<?php
$ft_name = $_POST["name"]."_";
$target_dir = "uploads/vendor_food_trucks/";
$target_file = $target_dir . $ft_name . basename($_FILES["fileToUpload"]["name"]);
echo "$target_file";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// This file looks for POST's to act on like creating a user in the database.
session_start();
// guide followed http://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
// initializing variables
$email = "";
$errors = array();

require 'server.php';
// VENDOR ADD FOOD TRUCK
// Check if vendor is logged in before executing. NEED TO ADD ERROR CATCHING.
$vendor_logged_in = $_SESSION['vendor_logged_in'] ?? ''; //suppress index error
if (isset($_POST['request_FT']) && $_SESSION['vendor_logged_in'] == true) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($description)) {
        array_push($errors, "Description is required");
    }
    if (count($errors) == 0) {
        $query = "INSERT INTO FOOD_TRUCK (name, FT_main_pic_path, description, approval_status) 
  			  VALUES('$name', '$target_file', '$description', 'pending')";
        mysqli_query($db, $query);
        header('location: index.php');
    }
}

?>