<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href="../style/Main.css" type="text/css" media= "all" />
    <link rel = "stylesheet" href="../style/Nav.css" type="text/css" media= "all" />
    <script src="../js/formScript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <title>Food truck Hunter</title>
</head>
<body>
<?php
$vendor_logged_in=$_SESSION['vendor_logged_in'] ?? '';
$admin_logged_in = $_SESSION['admin_logged_in'] ?? '';
if (isset($_SESSION['email'])){
    echo "Hello! " . $_SESSION["email"] . "<br>";}
if($vendor_logged_in || $admin_logged_in == true) {
    echo "<script type='text/javascript'>
                setTimeout(function(){showVendorSec();}, .0002);
            </script>";}
    if ($admin_logged_in == true) {
        echo "<script type='text/javascript'>
                setTimeout(function(){showAdminSec();}, .0002);
            </script>";
}
?>
<!-- nav bar-->
<div class="container-fluid" id="cont1">
    <a href="../about.html" id="cont4"> <img class="mx-auto d-block img-fluid" src="../images/logo.png" alt="logo"> </a>
    <div class="row" id="row1">
        <div class="col"></div>
        <a class="col-auto" href="../index.php">
            <img class="mx-auto img-fluid d-block"  src="../images/icon1.png" >Go Hunting!</a>
        <a class="col-auto" data-toggle="modal" data-target="#myModal2" href=#myModal2" >
            <img class="mx-auto img-fluid d-block" src="../images/icon2.png">Join Us</a>
        <a class="col-auto" href="../food_truck_list.php">
            <img class="mx-auto img-fluid d-block" src="../images/f-truck-list-small.png">Food Truck List</a>
        <a class="col-auto"  data-toggle="modal" data-target="#myModal" href="#myModal">
            <img class="mx-auto img-fluid d-block" src="../images/icon3.png">Login</a>
        <a class="col-auto" data-toggle="modal" data-target="#myModal3" href="#myModal3" id="adminSec" style="display: none">
            <img class="mx-auto img-fluid d-block" src="../images/admin_s.png">Admin Portal</a>
        <div class="col"></div>
    </div>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog" id="md1">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Pick a login method</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <a class="col" href="../login.php?vendor=true">
                            <img src="../images/vendorLogo.png" class=" mx-auto  d-block" >Vendor login</a>
                        <a class="col" href="../login.php?user=true">
                            <img src="../images/user.png" class=" mx-auto  d-block">User login</a>
                        <a class="col" href="/login.php?admin=true">
                            <img src="../images/admin.png" class=" mx-auto  d-block">Admin login</a>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal2 -->
    <div class="modal" id="myModal2">
        <div class="modal-dialog" id="md2">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Pick a login method</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <a class="col" href="/register.php?vendor=true">
                            <img src="../images/vendor++.png" class=" mx-auto  d-block">Vendor signup</a>
                        <a class="col" href="../register.php?user=true">
                            <img src="../images/newUser.png" class=" mx-auto  d-block">User signup</a>
                        <a class="col" href="../vendor_add_FT.php?rft=true" id="rqFt"  style="display: none">
                            <img src="../images/newVendor+.png" class=" mx-auto  d-block">request food truck</a>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal3 -->
    <div class="modal" id="myModal3">
        <div class="modal-dialog" id="md3">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Administration</h4>
                    <button type="button" class="close" data-dismiss="modal">x</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <a class="col" href="../admin/create_admin.php?admP=true">
                            <img src="../images/admin+.png" class=" mx-auto  d-block">Create Admin</a>
                        <a class="col" href="../admin/approve_vendor.php">
                            <img src="../images/approveVendor.png" class=" mx-auto  d-block">Approve Vendor Request</a>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- nav bar end-->
</div>
</body>
</html>