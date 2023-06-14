<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/
    
    /*Session initialization for login*/
    ini_set("session.save_path", "/home/unn_w22034009/sessionData");
    session_start();

    /*Creating the HTML page with functions*/
    require_once('functions.php');
    echo makePageStart("Edit records", "review.css");
    echo makeHeader("Task 1");

    /*Displaying the login form or log out option in nav menu*/
    if(checkLogin()){
        echo makeNavMenu("Options", array("home.php" => "Home Page", "logout.php" => "Log out","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), true);
        
        //First Task: querying and displaying records to edit
        //ONLY if the admin has already logged in
        echo startMain();
        $input=array();
        try{
            $dbConn = getConnection();
            $records=displayRecords($dbConn);
            //output of the HTML lines generated
            foreach($records as $record){
                echo $record;
                echo "\n";
            }
        //Control of exceptions if query to database not realized
        }catch(Exception $e){
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
        //Hiding records if the admin has not logged in.
        echo startMain();
        echo "<p> Please Log in to enter this content </p>";
        echo endMain();
        echo makeNavMenu("Options", array("home.php" => "Home Page","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), false);
    }
     
    /*Functions to finalize the page*/   
    echo makeFooter("KF5002 Assignment");
    echo makePageEnd();
?>
