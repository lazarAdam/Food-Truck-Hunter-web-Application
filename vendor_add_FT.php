<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Food Truck Request</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href ="style/Nav.css" type="text/css" media= "all" />
    <link rel = "stylesheet" href ="style/footer.css" type="text/css" media= "all" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("navigation.php");</script>
</div>
<div class="content">
    <form id="ft-r"  action="upload.php" method="post" enctype="multipart/form-data">
        <?php include('errors.php'); ?>
        <fieldset >
            <h3>Food Truck Request</h3>
            <div class="container-fluid" id="backGround"></div>
            <div class="input-group">
                <input type="text" name="name"
                       placeholder="Name of Food Truck" onfocus="this.placeholder=''" onblur="this.placeholder='Name of Food Truck'">
            </div>
            <br>
            <div class="input-group">
                <input type="text" name="description"
                       placeholder="Description" onfocus="this.placeholder=''" onblur="this.placeholder='Description'">
            </div>
            <br>
            <div class="input-group">
                <input type="file" name="fileToUpload" id="fileToUpload"
                       placeholder="Picture of Food Truck" onfocus="this.placeholder=''" onblur="this.placeholder='Picture of Food Truck'">
            </div>
            <br>
            <div class="input-group">
                <div  id="cont3">
                    <button class="btn btn-primary btn-lg active btn" role="button"
                            type="submit"  name="request_FT" id="btn1">Submit</button>
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