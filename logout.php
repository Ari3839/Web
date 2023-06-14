<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

    /*Session initialization for login*/
    ini_set("session.save_path", "/home/unn_w22034009/sessionData");
    session_start();

    /*Deleting data of the session*/
    $_SESSION=array();
    session_destroy();

    /*Creating the HTML page with functions*/
    require_once("functions.php");
    echo makePageStart("Loggin out", "review.css");
    echo makeHeader("Task 2");
    echo makeNavMenu("Options", array("home.php" => "Home Page","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), true);

    /*Redirecting user to records to login*/
    echo startMain();
    echo "Session logged out, you are going to be redirected, if not, please click here: <br> <a href='index.php'>Go back</a>\n";
    header("refresh:6;url=index.php");
    echo endMain();

    /*Functions to finalize the page*/   
    echo makeFooter("KF5002 Assignment");
    echo makePageEnd();
?>
