<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

    /*Session initialization for login*/
    ini_set("session.save_path", "/home/unn_w22034009/sessionData");
    session_start();

    /*Creating the HTML page with functions*/
    require_once('functions.php');
    echo makePageStart("Home", "review.css");
    echo makeHeader("Welcome");

    /*Displaying the login form or log out option in nav menu*/
    if(checkLogin()){
        echo makeNavMenu("Options", array("home.php" => "Home Page", "logout.php" => "Log out","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), true);   
    }else{
        echo makeNavMenu("Options", array("home.php" => "Home Page","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), false);
    }

    /*Main body using functions*/
    echo startMain();
    echo "<div><h2 style='color:Violet;'> Special offers </h2></div>";
    echo "<div id='offers'> Offers </div>";
    echo endMain();

    /*Javascript source to query random records every 5 sec.*/
    echo "<script type='text/javascript' src='offers.js'></script>"; 

    /*Functions to finalize the page*/   
    echo makeFooter("KF5002 Assignment");
    echo makePageEnd();
?>