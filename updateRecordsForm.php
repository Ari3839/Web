<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

    /*Session initialization for login*/
    ini_set("session.save_path", "/home/unn_w22034009/sessionData");
    session_start();

    /*Creating the HTML page with functions*/
    require_once("functions.php");
    echo makePageStart("Edit records", "review.css");
    echo makeHeader("Task 1");

    /*Displaying the login form or log out option in nav menu*/
    if(checkLogin()){
        echo makeNavMenu("Options", array("home.php" => "Home Page", "logout.php" => "Log out","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), true);

        echo startMain();
        /*Showing form to edit the record previously selected*/
        try{
            $dbConn = getConnection();
            $input=array();
            $FormItems=displayForm($input,$dbConn);
            foreach($FormItems as $item){
                echo $item;
                echo "\n";
            }
        }catch(Exception $e){
            /*Catching error if query to database not possible*/
            //Variable defined in 'setEnv.php' to control the information displayed for the user when error ocurred
            if (defined("DEVELOPMENT") && DEVELOPMENT===true) {
                echo "<p>Query failed: ".$e->getMessage()."</p>\n";
            } else {
                echo "<p>A problem occurred. Please try again.</p>\n";
                log_error($e);
            }
        }
        echo endMain();    
    }else{
        //Hiding form if the admin has not logged in.
        echo startMain();
        echo "<p> Please Log in to enter this content </p>";
        echo endMain();
        echo makeNavMenu("Options", array("home.php" => "Home Page","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), false);
    }
    
    echo makeFooter("KF5002 Assignment");
    echo makePageEnd();
?>