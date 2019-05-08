<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Add Food Truck</title>
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
            <h3>Add Food Truck</h3>
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
                <button type="submit" class="btn" name="request_FT">Submit</button>
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