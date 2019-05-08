<?php
/**
 * Created by PhpStorm.
 * User: Kyle.henson
 * Date: 3/31/2019
 * Time: 12:50 PM
 */
    session_start();
    session_unset(); // only destroys the session variables.
    setcookie(session_name(), '', 100); // kills cookie
    echo "Logout Successful";
    session_destroy();   // function that Destroys Session
    $_SESSION = array();
    header("Location: index.php");
?>