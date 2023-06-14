<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

    /*Session initialization for login*/
    ini_set("session.save_path", "/home/unn_w22034009/sessionData");
    session_start();

    /*Creating the HTML page with functions*/
    require_once('functions.php');
    echo makePageStart("Credits", "review.css");
    echo makeHeader("Credits");

    /*Displaying the login form or log out option in nav menu*/
    if(checkLogin()){
        echo makeNavMenu("Options", array("home.php" => "Home Page", "logout.php" => "Log out","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), true);   
    }else{
        echo makeNavMenu("Options", array("home.php" => "Home Page","index.php" => "Update","orderRecordsForm.php" => "Order Records", "credits.php" => "Credits"), false);
    }

    echo startMain();
    echo "<h2> Annette Ariadna Lázaro Martínez </h2>";
    echo "<h3> w22034009 </h3>";
    echo "<p> Module KF5002: Web Programming </p>";
    echo "<p> Deadline: 11/01/2023 </p>";
    echo "<h2> References: </h2>";
    echo "<ul>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP re-cap’ [Lecture], KF5002: Web Programming. Northumbria University. September 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14909204_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP exceptions and PDO’ [Lecture], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14909206_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP information retrieval and insert with PDO workshop’ [Workshop material], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14909208_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘Database Information Management Updating records using PDO in PHP’ [Lecture], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14974061_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP update records with PDO workshop’ [Workshop material], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14787026_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘Validating and sanitising data’ [Lecture], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_15004500_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP - validating and sanitising data workshop’ [Workshop material], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14787032_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘Hassing and sessions’ [Lecture], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_15027544_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP hashing and sessions workshop’ [Workshop material], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14787040_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘Further ways to use functions’ [Lecture], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14787043_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘review.css’ [Aditional material], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://alt-5b6bce0407d12.blackboard.com/bbcswebdav/pid-14787046-dt-content-rid-60870503_2/courses/2022SEM1_KF5002BNN01/2021SEM1_KF5002BNN01_ImportedContent_20210909083837/READ_ONLY/content/_9320771_1/review.css?one_hash=F372BA9CEF30DF48FCED26842CED67FE&f_hash=2558D63B3C8DFD1C2019CEAE60C6AB65 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP further ways to use functions workshop’ [Workshop material], KF5002: Web Programming. Northumbria University. October 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_14787045_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘Handling exceptions. Handling files’ [Lecture], KF5002: Web Programming. Northumbria University. November 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_15055032_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘PHP handling files and exceptions workshop’ [Workshop material], KF5002: Web Programming. Northumbria University. November 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/file/_15055079_1 (Accessed: 03 December 2022).</li>";
    echo "<li>Vasiliou, C., et. al (2022) ‘JavaScript – The Basics’ [Lecture], KF5002: Web Programming. Northumbria University. November 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/edit/document/_14787056_1?courseId=_726514_1&view=content (Accessed: 03 December 2022).</li>";
    echo "<li>Vasiliou, C., et. al (2022) ‘JavaScript 2.0 – Events, Forms & DOM’ [Lecture], KF5002: Web Programming. Northumbria University. November 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/edit/document/_14787059_1?courseId=_726514_1&view=content (Accessed: 03 December 2022).</li>";
     echo "<li>Vasiliou, C., et. al (2022) ‘Javascript tutors’ [Workshop material], KF5002: Web Programming. Northumbria University. November 2022. Available at: http://unn-izge1.newnumyspace.co.uk/KF5002/Javascript/01_Basics/pageA1.html (Accessed: 03 December 2022).</li>";
     echo "<li>Elvin, G., et. al (2022) ‘AJAX’ [Workshop material], KF5002: Web Programming. Northumbria University. November 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/edit/document/_15117346_1?courseId=_726514_1&view=content (Accessed: 03 December 2022).</li>";
    echo "<li>Elvin, G., et. al (2022) ‘Week 10 workshop: AJAX’ [Workshop material], KF5002: Web Programming. Northumbria University. November 2022. Available at: https://elp.northumbria.ac.uk/ultra/courses/_726514_1/outline/edit/document/_14787067_1?courseId=_726514_1&view=content (Accessed: 03 December 2022).</li>";
    echo "<li>www.w3schools.com. (n.d.). JavaScript toFixed() Method. [online] Available at: https://www.w3schools.com/jsref/jsref_tofixed.asp</li>";
    echo "<li>developer.mozilla.org. (n.d.). Window - Web APIs | MDN. [online] Available at: https://developer.mozilla.org/en-US/docs/Web/API/Window [Accessed 3 Dec. 2022].</li>";
    echo "<li>www.w3schools.com. (n.d.). CSS Selectors Reference. [online] Available at: https://www.w3schools.com/csSref/css_selectors.php.</li>";
    echo "<li>www.w3schools.com. (n.d.). CSS Reference. [online] Available at: https://www.w3schools.com/cssref/index.php.</li>";
    echo "</ul>";

    /*Functions to finalize the page*/   
    echo endMain();
    echo makeFooter("KF5002 Assignment");
    echo makePageEnd();
?>