<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Food Truck Hunters - Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/Nav.css">
    <link rel="stylesheet" type="text/css" href="style/footer.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<div class="header">
    <div id="navigation-text"></div>
    <script>$("#navigation-text").load("navigation.php");</script>
</div>
<div class="content">
    <script>
        function showUserRegister(){
            $("#user-register").fadeToggle(1000);
            if ($("#vendor-register").css("display") != "none"){
                $("#vendor-register").hide();
            }
        }
        function showVendorRegister(){
            $("#vendor-register").fadeToggle(1000);
            if ($("#user-register").css("display") != "none"){
                $("#user-register").hide();
            }
        }
    </script>

    <br>
    <?php include('errors.php'); ?>
    <div id="user-register" style="display: none">
        <form method="post" action="register.php?user=true">
            <fieldset>
                <h3>User Registration</h3>
                <div class="container-fluid" id="backGround" style="height:500px"></div>
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
                <br>
                <div class="input-group">
                    <div id="cont3">
                        <button class="btn btn-primary btn-lg active btn" role="button"
                                type="submit"  name="reg_user" id="btn1">Register</button>
                    </div>
                </div>
                <p>Already a member? <a href="login.php?user=true">Sign in</a></p>
            </fieldset>
        </form>
    </div>
    <div id="vendor-register" style="display: none">
        <form method="post" action="register.php?vendor=true">
            <fieldset>
                <h3>Request A Vendor Account</h3>
                <div class="container-fluid" id="backGround" style="height:800px"></div>
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
                <br>
                <div class="input-group">
                    <input type="text" name="first_name"
                           placeholder="First Name" onfocus="this.placeholder=''" onblur="this.placeholder='First Name'">
                </div>
                <br>
                <div class="input-group">
                    <input type="text" name="last_name"
                           placeholder="Last Name" onfocus="this.placeholder=''" onblur="this.placeholder='Last Name'">
                </div>
                <br>
                <div class="input-group">
                    <input type="text" name="company_name"
                           placeholder="Company Name" onfocus="this.placeholder=''" onblur="this.placeholder='Company Name'">
                </div>
                <br>
                <div class="input-group">
                    <label></label>
                    <input type="tel" name="phone_number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                           placeholder="Phone Number (000-000-0000)" onfocus="this.placeholder=''"
                           onblur="this.placeholder='Phone Number (000-000-0000)'">
                </div>
                <br>
                <div class="input-group">
                    <input type="text" name="city"
                           placeholder="City" onfocus="this.placeholder=''" onblur="this.placeholder='City'">
                </div>
                <br>
                <div class="input-group">
                    <label style="font-size:18pt">State </label>
                    <select name="state"
                            placeholder=State" onfocus="this.placeholder=''" onblur="this.placeholder='State'">>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <div id="cont3">
                        <button class="btn btn-primary btn-lg active btn" role="button"
                                type="submit"  name="reg_vendor" id="btn1">Register</button>
                    </div>
                </div>
                <p>Already a Vendor? <a href="login.php?vendor=true">Sign in</a></p>
            </fieldset>
        </form>
    </div>
</div>
<script>
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    // get the parameters from the url and check if user, vendor, or admin is set to true (eg. /?user=true)
    // this tells us to open up the user pane automatically. This is done last as so the div's elements have time to load on the page
    var userDivDisplayed = getUrlParameter("user");
    var vendorDivDisplayed = getUrlParameter("vendor");
    if (userDivDisplayed != null)
      showUserRegister();
    if (vendorDivDisplayed != null)
        showVendorRegister();
</script>

<br>
<div class="footer">
    <div id="footer-text"></div>
    <script>$("#footer-text").load("footer.html");</script>
</div>
</body>
</html>