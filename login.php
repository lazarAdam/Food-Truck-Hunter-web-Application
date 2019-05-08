<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/Nav.css" type="text/css">
    <link rel="stylesheet" href="style/footer.css" type="text/css" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/formScript.js"></script>
</head>
<body>
<div class="header">
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("navigation.php");</script>
</div>

<div class="content">
    <div id="cont1">
        <h5 style="color: red"><?php include('errors.php'); ?></h5>
    </div>
    <div id="user-login" style="display: none">
        <form method="post" action="login.php?user=true">
        <fieldset>
            <div class="container-fluid" id="backGround"></div>
            <h3>User Login</h3>
            <div class="input-group">
                <input type="text" name="email"
                       placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'">
            </div>
            <br>
            <div class="input-group">
                <input type="password" name="password"
                       placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
            </div>
            <br>
            <div class="input-group">
                <div id="cont3">
                    <button class="btn btn-primary btn-lg active btn" role="button"
                            type="submit" name="login_user" id="btn1">login</button>
                </div>
            </div>
            <p>Not yet a user? <a href="register.php?user=true">User Sign up</a></p>
        </fieldset>
        </form>
    </div>


    <div id="vendor-login" style="display: none">
        <form method="post" action="login.php?vendor=true">
            <fieldset>
                <div class="container-fluid" id="backGround"></div>
                <h3>Vendor Login</h3>
                <div class="input-group">
                    <input type="text" name="email"
                           placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'">
                </div>
                <br>
                <div class="input-group">
                    <input type="password" name="password"
                           placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
                </div>
                <br>
                <div class="input-group">
                    <div id="cont3">
                        <button class="btn btn-primary btn-lg active btn" role="button"
                                type="submit" name="login_vendor" id="btn1">login</button>
                    </div>
                </div>
                <p>Not yet a vendor? <a href="register.php?vendor=true">Vendor Sign up</a></p>
            </fieldset>
        </form>
    </div>


    <form id="admin-login" method="post" action="login.php?admin=true" style="display: none">
        <fieldset>
            <h3>Admin Login</h3>
            <div class="container-fluid" id="backGround"></div>
            <div class="input-group">
                <input type="text" name="email"
                       placeholder="Email" onfocus="this.placeholder=''" onblur="this.placeholder='Email'">
            </div>
            <br>
            <div class="input-group">
                <input type="password" name="password"
                       placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'">
            </div>
            <br>
            <div class="input-group">
                <div  id="cont3">
                    <button class="btn btn-primary btn-lg active btn" role="button"
                            type="submit" name="login_admin" id="btn1">login</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

<div class="footer">
    <div id="footer-text"></div>
    <script>$("#footer-text").load("footer.html");</script>
</div>
</body>
</html>