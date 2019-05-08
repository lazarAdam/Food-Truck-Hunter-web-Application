

<?php

// This file looks for POST's to act on like creating a user in the database.
session_start();
// guide followed http://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database
// initializing variables
$email = "";
$errors = array();

// connect to the database, probably should not be hardcoded
// command to setup mysql user in server ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'Notaproblem@';
include('db.php');
// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database
        $query = "INSERT INTO users (email, password) 
  			  VALUES('$email', '$password')";
        mysqli_query($db, $query);
        $_SESSION['email'] = $email;
        $_SESSION['user_logged_in'] = true;
        header('location: index.php');
    }
}
// USER LOGIN
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['email'] = $email;
            $_SESSION['user_logged_in'] = true;
            header('location: index.php');
        }else {
            array_push($errors, "Wrong email/password combination");
        }
    }
}

// VENDOR LOGIN
if (isset($_POST['login_vendor'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM vendors WHERE email='$email' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['email'] = $email;
            $_SESSION['vendor_logged_in'] = true;
            header('location: index.php');
        }else {
            array_push($errors, "Wrong email/password combination");
        }
    }
}

// REGISTER VENDOR
if (isset($_POST['reg_vendor'])) {
    // receive all input values from the form
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $company_name = mysqli_real_escape_string($db, $_POST['company_name']);
    $phone_number = mysqli_real_escape_string($db, $_POST['phone_number']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (empty($first_name)) { array_push($errors, "First Name is required"); }
    if (empty($last_name)) { array_push($errors, "Last Name is required"); }
    if (empty($company_name)) { array_push($errors, "Company Name is required"); }
    if (empty($phone_number)) {array_push($errors, "Phone Number is required");}
    if (empty($city)) {array_push($errors, "City is required");}
    if (empty($state)) { array_push($errors, "State is required");}
    // validate phone number
    if(!(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phone_number))) {
        array_push($errors, "Your phone number must match this format 000-000-0000");
    }
        // first check the database to make sure
            // a vendor does not already exist with the same username and/or email
            $vendor_check_query = "SELECT * FROM vendor_request WHERE email='$email' LIMIT 1";
            $result = mysqli_query($db, $vendor_check_query);
            $vendor = mysqli_fetch_assoc($result);

            if ($vendor) { // if vendor exists
                if ($vendor['email'] === $email) {
                    array_push($errors, "Email already exists");
                }
            }

            // Finally, register vendors if there are no errors in the form
            if (count($errors) == 0) {
                $password = md5($password_1);//encrypt the password before saving in the database
                $query = "INSERT INTO vendor_request (email, first_name, last_name, company_name, password, phone_number, city, state, status) 
  			  VALUES('$email', '$first_name', '$last_name', '$company_name', '$password', '$phone_number', '$city', '$state', 'pending')";
                mysqli_query($db, $query);
                array_push($errors, "Your vendor account request has been submitted");
                header('login.php?vendor=true');
            }
        }

// ADMIN LOGIN
        if (isset($_POST['login_admin'])) {
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $password = mysqli_real_escape_string($db, $_POST['password']);
            if (empty($email)) {
                array_push($errors, "Email is required");
            }
            if (empty($password)) {
                array_push($errors, "Password is required");
            }
            if (count($errors) == 0) {
                $password = md5($password);
                $query = "SELECT * FROM admins WHERE email='$email' AND password='$password'";
                $results = mysqli_query($db, $query);
                if (mysqli_num_rows($results) == 1) {
                    $_SESSION['email'] = $email;
                    $_SESSION['admin_logged_in'] = true;
                    header('location: ../index.php');
                } else {
                    array_push($errors, "Wrong email/password combination");
                }
            }
        }

// CREATE ADMIN AS AN ADMIN, Needs error catching for if admin is not signed in
        $admin_logged_in = $_SESSION['admin_logged_in'] ?? ''; //suppress index error
        if (isset($_POST['create_admin']) && $admin_logged_in == true) {
            // receive all input values from the form
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
            $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
            // form validation: ensure that the form is correctly filled ...
            // by adding (array_push()) corresponding error unto $errors array
            if (empty($email)) {
                array_push($errors, "Email is required");
            }
            if (empty($password_1)) {
                array_push($errors, "Password is required");
            }
            if ($password_1 != $password_2) {
                array_push($errors, "The two passwords do not match");
            }

            // first check the database to make sure
            // a user does not already exist with the same username and/or email
            $admin_check_query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
            $result = mysqli_query($db, $admin_check_query);
            $admin = mysqli_fetch_assoc($result);

            if ($admin) { // if admin exists
                if ($admin['email'] === $email) {
                    array_push($errors, "email already exists");
                }
            }

            // Finally, register user if there are no errors in the form
            if (count($errors) == 0) {
                $password = md5($password_1);//encrypt the password before saving in the database
                $query = "INSERT INTO admins (email, password) 
                  VALUES('$email', '$password')";
                mysqli_query($db, $query);
                array_push($errors, "The admin $email has been created.");
            }
            if (isset($_POST['create_admin']) && $admin_logged_in == false) {
                array_push($errors, "You must be logged in as an admin!");
            }
        }
?>

