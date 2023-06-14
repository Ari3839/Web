<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

    /*Session initialization for login*/
    ini_set("session.save_path", "/home/unn_w22034009/sessionData");
    session_start();
    
    /*Creating the HTML page with functions*/
    require_once("functions.php");
    echo makePageStart("Loggin in", "review.css");
    echo makeHeader("Task 2");

    /*Validating user and password*/
    $dbConn = getConnection();
    list($input, $errors) = validateLogon($dbConn);

    /*Showing errors if logging incorrect*/
    if ($errors) {
        echo startMain();
        echo showErrors($errors);
        echo endMain();
        echo makeNavMenu("Options", array("home.php" => "Home Page","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), false);
    }else {
        /*Showing hided content to admin*/
        setSession('logged-in', 'true');
        echo startMain();
        echo "Thank you for login, you are going to be redirected, if not, please click here: <br> <a href='index.php'>Edit a record</a>\n";
        echo endMain();
        echo makeNavMenu("Options", array("home.php" => "Home Page", "logout.php" => "Log out","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), true);

        /*Redirecting user to records to update*/
        header("refresh:6;url=index.php");
    }
    
    /*Functions to finalize the page*/   
    echo makeFooter("KF5002 Assignment");
    echo makePageEnd();
?>