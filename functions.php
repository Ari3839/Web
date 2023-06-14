<?php
/*A. Ariadna Lazaro Mtz*/
/*w22034009*/
/*KF5002: Web programming final Assignment*/

/*Functions file used in different pages for the assignment*/

///////////////////////////DB Connection///////////////////////////////////
function getConnection() {
	$connection = new PDO("mysql:host=localhost;dbname=unn_w22034009",
	"unn_w22034009", "complicated");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $connection;
}

/////////////////Page creation functions////////////////////////////////

/*Title of the page and cssFile used for the paged received as parameters*/
function makePageStart($title,$cssFile) {
    $pageStartContent = <<<PAGESTART
    <!doctype html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <title>$title</title>
        <link href=$cssFile rel="stylesheet" type="text/css">
    </head>
    
    <body>
    <div id="gridContainer">
        
PAGESTART;
    
    $pageStartContent .="\n";
    return $pageStartContent;
}

/*Parameters: Text for header*/
function makeHeader($headerText){
    $headContent = <<<HEAD
        <header>
            <h1>$headerText</h1>
        </header>
HEAD;
    
    $headContent .="\n";
    return $headContent;
}

/*Parameters: Header of nav menu, array of links for nav menu and boolean to confirm session loged in or not*/
function makeNavMenu($navMenuHeader, array $links, $login) {
    $navMenuContent = "";
    $navMenuContent .= "<nav>";
    $navMenuContent .= "<h2>$navMenuHeader</h2>";

    /*Creating nav menu with array*/
    $navMenuContent .= "<ul>";
        foreach($links as $key => $value){
            $navMenuContent .= "<li><a href='$key'>'$value'</a></li>";
        }
    $navMenuContent .= "</ul>";

    /*If session not logged in, showing login form*/
    if(!$login){
        $navMenuContent .= "<h2> Login </h2>";
        $navMenuContent .= "<form method='post' action='loginProcess.php'>";
        $navMenuContent .= "Username <input type='text' name='username'>";
        $navMenuContent .= "<br>";
        $navMenuContent .= "Password <input type='password' name='password'>";
        $navMenuContent .= "<br>";
        $navMenuContent .= "<input type='submit' value='Login'>";
        $navMenuContent .= "</form>";
    }
    
    $navMenuContent .= "</nav>";
    $navMenuContent .= "\n";
    
    return $navMenuContent;
}


function startMain() {
    return "<main>\n";
}

function endMain() {
    return "</main>\n";
}

/*Parameters: text for footer*/
function makeFooter($footer) {
    $footContent = <<<FOOT
    <footer>
        <p>$footer</p>
    </footer>
FOOT;
    $footContent .="\n";
    return $footContent;
}

function makePageEnd() {
    return "</div>\n</body>\n</html>";
}

////////////////////////////TASK 1 Functions////////////////////////////////////

function displayRecords($dbConn){
    $output=array();

    //Query to db display the records
    $sqlQuery = "SELECT re.recordID as recordID, re.recordTitle as recordTitle, 
                re.recordYear as recordYear, ca.catID as catID, 
                ca.catDesc as catDesc, re.recordPrice as recordPrice
                FROM nmc_records as re
                INNER JOIN nmc_category as ca
                ON re.catID=ca.catID
                ORDER BY recordTitle";
    $queryResult = $dbConn->query($sqlQuery);

    //Sanitazing and displaying the records
    while ($rowObj = $queryResult->fetchObject()) {
        $output[]= "<div class='record'>\n";
        $output[]= "<span class='recordTitle'>";
        $recordID=$rowObj->recordID;
        $title=htmlspecialchars($rowObj->recordTitle,ENT_NOQUOTES);
        $output[]= "<a href='updateRecordsForm.php?recordID=$recordID'>$title</a>";
        $output[]= "</span>\n";
        $desc=htmlspecialchars($rowObj->catDesc,ENT_NOQUOTES);
        $output[]= "<span class='catDesc'>$desc</span>\n";
        $year=htmlspecialchars($rowObj->recordYear,ENT_NOQUOTES);
        $output[]= "<span class='recordYear'>$year</span>\n";
        $price=htmlspecialchars($rowObj->recordPrice,ENT_NOQUOTES);
        $output[]= "<span class='recordPrice'>$price</span>\n</div>\n";
    }
    return $output;
}


function displayForm($input,$dbConn){
    $output=array();

    //ID obtained when the title was clicked
    $recordID = filter_has_var(INPUT_GET, 'recordID')
        ? $_REQUEST['recordID'] : null;

    if($recordID==null){
        //Auxiliar variables in case the form is displaying again because of an error
        $recordID = $input['recordID']; 
        $displayedAgain=true;
    }else{
        $displayedAgain=false;
    }
    
    //Obtaining the values of the record clicked to use in the form
    $sqlQuery = "SELECT re.recordTitle as recordTitle, 
                re.recordYear as recordYear,
                p.pubID as pubID, p.pubName as pubName, 
                ca.catID as catID, ca.catDesc as catDesc, 
                re.recordPrice as recordPrice
                FROM nmc_records as re
                JOIN nmc_category as ca
                ON re.catID=ca.catID
                JOIN nmc_publisher as p
                ON p.pubID=re.pubID
                WHERE re.recordID=$recordID";
    $queryResult = $dbConn->query($sqlQuery);
    $rowObj = $queryResult->fetchObject();

    /*Creating form after sanitazing data*/
    $output[]="<br>";
    $output[]="<br>";
    $output[]="<form method='post' action='updateRecordsProcess.php'>";
    $output[]="<div>";
    $recordID = htmlspecialchars($recordID, ENT_NOQUOTES);
    $output[]="RecordID <input type='text' name='recordID' value=$recordID readonly>";
    $output[]="</div>";
    $output[]="<br>";

    $output[]="<div>";
    /*To resolve the problem of not showing all the title, it is shown with '-' instead of spaces*/
    $recordTitle=str_replace(" ", "-", "$rowObj->recordTitle");
    $recordTitle = htmlspecialchars("$recordTitle",ENT_NOQUOTES);
    /*If the form is showing again because of an error, the value showed in the form should be the last one that the user entered, not the one directly obtained with the db*/
    $typedRecordTitle = filter_has_var(INPUT_POST, 'recordTitle')
        ? $_REQUEST['recordTitle'] : null;
    if($displayedAgain){
        $recordTitle=$typedRecordTitle;
    }
    $output[]="Record Title <input type='text' name='recordTitle' value=$recordTitle>";
    $output[]="</div>";
    $output[]="<br>";

    $output[]="<div>";
    $recordYear=htmlspecialchars($rowObj->recordYear,ENT_NOQUOTES);
    /*If the form is showing again because of an error, the value showed in the form should be the last one that the user entered, not the one directly obtained with the db*/
    $typedRecordYear = filter_has_var(INPUT_POST, 'recordYear')
        ? $_REQUEST['recordYear'] : null;
    if($displayedAgain){
        $recordYear=$typedRecordYear;
    }
    $output[]="Record Year <input type='text' name='recordYear' value=$recordYear>";
    $output[]="</div>";
    $output[]="<br>";


    $output[]= "<div>";
    $output[]= "Category";
    $output[]= "<select name='catID'>";
    /*DB query to show all categories available*/
    $sqlQuery2 = "SELECT catID, catDesc
                FROM nmc_category
                order by catID";
    $queryResult2 = $dbConn->query($sqlQuery2);
    while ($nameRow=$queryResult2->fetchObject()){
        $cat=htmlspecialchars($nameRow->catDesc,ENT_NOQUOTES);
        $cID=$nameRow->catID;

        /*If the form is showing again because of an error, the value showed in the form should be the last one that the user entered, not the one directly obtained with the db*/
        $typedcatID= filter_has_var(INPUT_POST, 'catID')
        ? $_REQUEST['catID'] : null;

        if(!$displayedAgain){
            /*Showing the original category stored in the db if first time*/
            if($nameRow->catID==$rowObj->catID){
                $selected='selected';
            }else{
                $selected='';
            }
        }else{
            /*Showing the last category selected by the user if form is displayed again*/
            if($cID==$typedcatID){
                $selected='selected';
            }
            else{
                $selected='';
            }
        }

        $output[]= "<option value=$cID $selected>$cat</option>";
    }
    $output[]= "</select>";
    $output[]= "</div>";
    $output[]= "<br>";


    $output[]= "<div>";
    $output[]= "Publisher";
    $output[]= "<select name='pubID'>";
    /*DB query to show all publishers available*/
    $sqlQuery3 = "SELECT pubID, pubName
                FROM nmc_publisher
                order by pubID";
    $queryResult3 = $dbConn->query($sqlQuery3);
    while ($pRow=$queryResult3->fetchObject()){
        $pub=htmlspecialchars($pRow->pubName,ENT_NOQUOTES);
        $pID=$pRow->pubID;

        /*If the form is showing again because of an error, the value showed in the form should be the last one that the user entered, not the one directly obtained with the db*/
        $typedPubID= filter_has_var(INPUT_POST, 'pubID')
        ? $_REQUEST['pubID'] : null;

        if(!$displayedAgain){
            /*Showing the original publisher stored in the db if first time*/
            if($pID==$rowObj->pubID){
                $selected='selected';
            }
            else{
                $selected='';
            }    
        }else{
            /*Showing the last publisher selected by the user if form is displayed again*/
            if($pID==$typedPubID){
                $selected='selected';
            }
            else{
                $selected='';
            }
        }

        $output[]= "<option value=$pID $selected>{$pub}</option>";
    }
    $output[]= "</select>";
    $output[]= "</div>";
    $output[]= "<br>";


    $output[]="<div>";
    $recordPrice=htmlspecialchars($rowObj->recordPrice,ENT_NOQUOTES);

    /*If the form is showing again because of an error, the value showed in the form should be the last one that the user entered, not the one directly obtained with the db*/
    $typedRecordPrice= filter_has_var(INPUT_POST, 'recordPrice')
        ? $_REQUEST['recordPrice'] : null;
    if($displayedAgain){
        $recordPrice=$typedRecordPrice;
    }

    $output[]="Record Price <input type='text' name='recordPrice' value=$recordPrice>";
    $output[]="</div>";
    $output[]="<br>";

    $output[]= "<div>";
    $output[]= "<button type='submit'>Update Record</button>";
    $output[]= "</div>";
    $output[]= "</form>";

    return $output;
}

/*Function to validate data of the form before updating*/
function validateForm($dbConn){
    $input=array();
    $errors=array();
    
    /*Getting data to the update*/
    $input['recordID'] = filter_has_var(INPUT_POST, 'recordID')
        ? $_REQUEST['recordID'] : null;
    $input['recordTitle'] = filter_has_var(INPUT_POST, 'recordTitle')
        ? $_REQUEST['recordTitle'] : null;
    $input['recordYear'] = filter_has_var(INPUT_POST, 'recordYear')
        ? $_REQUEST['recordYear'] : null;
    $input['pubID']= filter_has_var(INPUT_POST, 'pubID')
        ? $_REQUEST['pubID'] : null;
    $input['catID']= filter_has_var(INPUT_POST, 'catID')
        ? $_REQUEST['catID'] : null;
    $input['recordPrice']= filter_has_var(INPUT_POST, 'recordPrice')
        ? $_REQUEST['recordPrice'] : null;
    
    /*Sanitazing data*/
    $input['recordID']=trim($input['recordID']);
    $input['recordTitle']=trim($input['recordTitle']);
    $input['recordYear']=trim($input['recordYear']);
    $input['recordPrice']=trim($input['recordPrice']);
    $input['pubID']=trim($input['pubID']);
    $input['catID']=trim($input['catID']);
    
    /*Queryng DB to obtain publishers and made validations*/
    $publishers=array();

    $sqlQuery = "SELECT pubID
                FROM nmc_publisher
                ORDER BY pubID";
    $queryResult = $dbConn->query($sqlQuery);

    while ($row=$queryResult->fetchObject()){
        $publishers[]="{$row->pubID}";
    }
    
    /*Conditions to update the form*/
    if(empty($input['recordTitle'])){
        $errors[]="Please enter an title\n";
    }else if(empty($input['recordYear'])){
        $errors[]="Please enter an year\n";
    }else if(empty($input['recordPrice'])){
        $errors[]="Please enter an price\n";
    }else{
        //Validation 1: values not empty
        $longitud1=strlen($input['recordTitle']);
        $longitud2=strlen($input['recordYear']);
        $longitud3=strlen($input['recordPrice']);
        //Validation 2: data too short or too long
        if($longitud1>99){
            $errors[]="Sorry, the title cannot be that long\n";
        }else if($longitud2!=4){
            $errors[]="Sorry, the year has to be 4 digits long\n";
        }else if($longitud3>5){
            $errors[]="Sorry, the price cannot be that high\n";
        //Validation 3: data type incorrect
        }else if(!filter_var($input['recordID'],FILTER_VALIDATE_INT)){
            $errors[]="Sorry, the ID of the record should be a number\n";
        }else if(!filter_var($input['catID'],FILTER_VALIDATE_INT)){
            $errors[]="Sorry, the please check the category\n";
        }else if(!filter_var($input['recordYear'],FILTER_VALIDATE_INT)){
            $errors[]="Sorry, the year should be a number\n";
        }else if(!filter_var($input['recordPrice'],FILTER_VALIDATE_FLOAT)){
            $errors[]="Sorry, the price should be a number with 2 decimals\n";
        //Validation 4: publisher incorrect
        }else if(!in_array($input['pubID'],$publishers)){
            $errors[]="Sorry, that publisher is not allowed\n";
        }
    }
    return array($input,$errors);
}

/*Function to join all errors*/
function showErrors($errors){
    $output='';
    foreach($errors as $error){
        $output .= $error;
    }
    return $output;
}

/*Function to update after validating*/
function processForm($input, $dbConn){
    $output='';
    $ID=$input['recordID'];

    /*Update db record*/
    $sqlUpdate = "UPDATE nmc_records
                    SET recordTitle=:recordTitle,
                    recordYear=:recordYear,
                    recordPrice=:recordPrice,
                    catID=:catID,
                    pubID=:pubID
                    WHERE recordID = $ID";
    $stmt=$dbConn->prepare($sqlUpdate);
    $stmt->execute(array(':recordTitle'=>$input['recordTitle'],
                        ':recordYear'=> $input['recordYear'],
                        ':recordPrice'=>$input['recordPrice'],
                        ':catID'=>$input['catID'],
                        ':pubID'=>$input['pubID'])
                    );
    
    return $output;
}



////////////////////////////////Error handler///////////////////////
/*** define a function to be the global exception handler that will fire if no catch block is found */
function exceptionHandler ($e) {
    echo "<p><strong>Problem occured</strong></p>";
    /*Saving error in file*/
    log_error($e);
}

/* Setting the php exception handler to be the one above */
set_exception_handler('exceptionHandler');

/*** Convert errors into exceptions.*/
function errorHandler ($errno, $errstr, $errfile, $errline) {
    if(!(error_reporting() & $errno)) {
        return;
    }
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler('errorHandler');

/*Storing the exceptions in a file*/
function log_error ($e) {
    $fileHandle = fopen("logs/error_log_file.log", "ab");
    $error_date = date('D M j G:i:s T Y');
    $error_message = $e->getMessage();
        
    $toReplace = array("\r\n", "\n", "\r"); //chars to replace
    $replaceWith = '';
    $errorMessage = str_replace($toReplace, $replaceWith, $error_message);

    fwrite($fileHandle, "$error_date|$errorMessage".PHP_EOL);
    fclose($fileHandle);
}

////////////////////////////////Task 2: Login//////////////////////////////////////
function displayLoginForm(){
    $output=array();
    
    $output[]="<form method='post' action='loginProcess.php'>";
    $output[]="Username <input type='text' name='username'>";
    $output[]="<br>";
    $output[]="Password <input type='password' name='password'>";
    $output[]="<br>";
    $output[]="<input type='submit' value='Login'>";
    $output[]="</form>";
    
    return $output;
}


function validateLogon($dbConn){
    $input=array();
    $errors=array();
    
    /*Retrieve the username and the password from the form*/  
    $input['username'] = filter_has_var(INPUT_POST, 'username')? $_POST['username']: null;
    $input['password'] = filter_has_var(INPUT_POST, 'password')? $_POST['password']: null;
    $input['username'] = trim($input['username']);
    $input['password'] = trim($input['password']);

    /* Query the users database table to get the password hash for 
    the username entered by the user, using a PDO named placeholder 
    for theusername */
    $querySQL = "SELECT passwordHash FROM nmc_users WHERE username = :username";
            
    // Prepare the sql statement using PDO
    $stmt = $dbConn->prepare($querySQL);
            
    // Execute the query using PDO
    $stmt->execute(array(':username' => $input['username']));
            
    /* Check if a record was returned by the query. If yes, then there was
    a username matching what was entered in the logon form and we can test
    (we will add code to shortly) to see if the password entered in the
    logon form was correct. Otherwise, indicate an error. */
    $user = $stmt->fetchObject();
    if ($user) {
        $passwordHash = $user->passwordHash;
    
        // Add code to verify the password attempt here (see below)        
        if(password_verify($input['password'], $passwordHash)){
            $_SESSION['logged-in'] = true;
        }else{
            $_SESSION['logged-in'] = false;
            $errors[]= "<p>Something went wrong, try to enter the user and password again :c</p>\n";
            $errors[]= "<p><a href='index.php'>Go back</a> to the form</p>";
        }
            
    }else {
        /* Add code to set a message to say the username or password
        were incorrect. Don’t say which. */
        $errors[]= "<p>Something went wrong, try to enter the user and password again :c</p>\n";
        $errors[]= "<p><a href='index.php'>Go back</a> to the form</p>";
    }
    
    return array($input,$errors);
}


function setSession($key, $value){
    // Set key element = value
    $_SESSION[$key] = $value;
    return true;
}

/*Function to retrieve a key-value element of the session*/
function getSession($key){
    $output='';
    if(isset($_SESSION[$key])){
        $output .=$_SESSION[$key];
    }
    return $output;
}

/*Function to very login*/
function checkLogin(){
    $value=getSession('logged-in');
    if($value){
        return true;
    }else{
        return false;
    }
}

?>