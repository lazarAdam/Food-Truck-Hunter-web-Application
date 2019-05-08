<?php include('../server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href="../style/Main.css" type="text/css" media= "all" />
    <link rel = "stylesheet" href="../style/Nav.css" type="text/css" media= "all" />
    <link rel = "stylesheet" href="../style/footer.css" type="text/css" media= "all" />
    <script src="../js/formScript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("../navigation.php");</script>
</div>
<div class="content">
    <form id="admin-login" method="post" action="admin_login.php" style="display: none">
            <?php include('../errors.php'); ?>



            <fieldset style="width:400px;background-color:lightgray;margin:auto;text-align:left;border-radius:5px;
                             border:1px solid gray;">
            <h3>Admin Login</h3>
            <div class="input-group">
                <label>Email</label>
                <input type="text" name="email" >
            </div>
            <br>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <br>
            <div class="input-group">
                <button type="submit" class="btn" name="login_admin">Login</button>
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