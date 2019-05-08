<?php
/**
 * Created by PhpStorm.
 * User: Kyle.henson
 * Date: 4/11/2019
 * Time: 6:02 PM
 */

include('../server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Create Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href="../style/Nav.css" type="text/css" media= "all" />
    <link rel = "stylesheet" href="../style/footer.css" type="text/css" media= "all" />
    <script src="../js/formScript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("admin_navigation.php");</script>
    <?php
    $admin_logged_in = $_SESSION['admin_logged_in'] ?? '';
    if ($admin_logged_in == true) {
        echo "<script type='text/javascript'>
                setTimeout(function(){showAdminSec();}, .0002);
            </script>";
    }
    ?>
</div>
<div class="content">
    <form method="post" action="create_admin.php" id="n-ad" style="display: none">
            <?php include('../errors.php'); ?>
            <fieldset >
            <h3>Create an Admin Account</h3>
                <div class="container-fluid" id="backGround"></div>
            <div class="input-group">
                <input type="email" name="email"
                       placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'">
            </div>
                <br>
                <div class="input-group">
                    <input type="password" name="password_1"
                           placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
                </div>
                <br>
                <div class="input-group">
                    <input type="password" name="password_2"
                           placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
                </div>
            <div class="input-group">
                <div  id="cont3">
                    <button class="btn btn-primary btn-lg active btn" role="button"
                            type="submit"  name="create_admin" id="btn1">login</button>
                </div>
            </div>
            </fieldset>
    </form>
</div>
<div class="footer">
    <div id="footer-text"></div>
    <script>$("#footer-text").load("../footer.html");</script>
</div>
</body>
</html>