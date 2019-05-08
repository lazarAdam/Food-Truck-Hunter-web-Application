<?php
session_start();
?>
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
    <fieldset id="apvList">
        <h3>Vendor Requests</h3>
        <div id="vendor-request-list"></div>
        <div class="container-fluid" id="bk2"></div>
        <button class="btn btn-primary btn-lg active btn" role="button"
                type="submit" name="approve_vend" id="btn1" onclick="passNewVendorStatus()">Submit</button>
    </fieldset>
        <script>
            var status_count = 0; //count needed for select id's
            function returnVendorsRequests(vendor_request){
                $html = "";
                $html += ("<div style='text-align:center; font-family: arial'><b>"
                    + vendor_request.email + "</b><br>"
                    + "Vendor ID: " + "<p class=\"vendorid\">" + vendor_request.id + "</p>"
                    + "First Name: " + vendor_request.first_name + "<br>"
                    + "Last Name: " + vendor_request.last_name + "<br>"
                    + "Phone Number: " + vendor_request.phone_number + "<br>"
                    + "City: " + vendor_request.city + "<br>"
                    + "Status: " + vendor_request.status + "<br>"
                    + "Creation Date: " + vendor_request.creation_date + "<br><br>"
                    + "<select id=\"status\">"
                    + "<option value=\"pending\">" + " Pending" + "</option>"
                    + "<option value=\"denied\">" + " Denied" + "</option>"
                    + "<option value=\"approved\">" + " Approved" + "</option>"
                    + "</select>"
                    + "<hr><br></div>");
                $("#vendor-request-list").append($html);
                document.getElementById('status').id = "status" + status_count;
                status_count++;
            }

            // append no food trucks found error message to food-tuck-list div
            function notifyNovendor_requestsFound(){
                $("#vendor-request-list").append("<div class='vendor-request'>"
                    + "<b style=\"color: red\">Error, you must be logged in as an administrator!</b><br></div>");
            }

            function passNewVendorStatus() {
                var vendor_count = 0; //count needed to select which vendor id
                jsonObj = [];
                $(".vendorid").each(function() {
                    var vendorid = $(".vendorid")[vendor_count].innerHTML;
                    var statusid = "#status" + vendor_count;
                    var status = $(statusid).val();
                    vendor_count++;
                    item = {};
                    item ["vendorid"] = vendorid;
                    item ["status"] = status;
                    jsonObj.push(item);
                });
                $.ajax({
                    type: 'POST',
                    url: 'process_vendor_requests.php',
                    data: {vendor_json: JSON.stringify(jsonObj)},
                    success: function() {
                        location.reload();
                    }
                });
            }
            /*
             * load the contents from teh get_all_food_trucks.php json api and parse the returned data into individual
             * food truck objects. Call addvendor_requestToPage on each food truck object to append them to the page's list
             */
            var request = $.ajax({
                url: "../api/get_vendor_requests.php",
                method: "get",
                dataType: "json",
                cache: false
            });

            // request.done called when the request is fulfilled
            request.done(function(data){
                var numRequests = 0;
                $(data).each(function(index, value){
                    returnVendorsRequests(value);
                    numRequests++;
                    console.log(value); // log the individual json object to the console
                });
                console.log(data); // log out the whole json array contents to console
                // update the blur background size depending on number of trucks added
                var size = 450*numRequests;
                $("#bk2").css("height", size);
            });

            // request.fail called if the request fails (ie wrong data type; html instead of json)
            request.fail(function(){
                notifyNovendor_requestsFound();
                //alert("Failed to fetch list of food trucks from json api");
            });
        </script>
</div>
<div class="footer">
    <div id="footer-text"></div>
    <script>$("#footer-text").load("../footer.html");</script>
</div>
</body>
</html>