/**
 * here are all the functions that control displaying of forms and other navigation buttons
 */

function showUserLogin(){
    $("#user-login").fadeToggle(1000);
    if ($("#vendor-login").css("display") != "none"){
        $("#vendor-login").hide();
    }
    if ($("#admin-login").css("display") != "none"){
        $("#admin-login").hide();
    }
}

function showVendorLogin(){
    $("#vendor-login").fadeToggle(1000);
    if ($("#user-login").css("display") != "none"){
        $("#user-login").hide();
    }
    if ($("#admin-login").css("display") != "none"){
        $("#admin-login").hide();
    }
}
function showAdminLogin(){
    $("#admin-login").fadeToggle(1000);
    if ($("#user-login").css("display") != "none"){
        $("#user-login").hide();
    }
    if ($("#vendor-login").css("display") != "none"){
        $("#vendor-login").hide();
    }
}

function foodTruckRequest() {
    $("#ft-r").fadeToggle(1000);
}

function newAdmin() {
    $("#n-ad").fadeToggle(1000);
}

function showAdminSec(){
    document.getElementById("adminSec").style.display="block";
}

function showVendorSec() {
    document.getElementById("vendorSec").style.display="block";
}


function openNav() {
    document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}



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
var adminDivDisplayed = getUrlParameter("admin");
var ftrDisplayed = getUrlParameter("rft");
var adminPage = getUrlParameter("admP");

if (userDivDisplayed != null)
    showUserLogin();
if (vendorDivDisplayed != null)
    showVendorLogin();
if (adminDivDisplayed != null)
    showAdminLogin();
if(ftrDisplayed != null)
    foodTruckRequest();
if(adminPage != null)
    newAdmin();

