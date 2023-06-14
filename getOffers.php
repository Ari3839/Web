<?php
try {
	// include the file for the database connection
	require_once('functions.php');
	// get database connection
	$dbConn = getConnection();

	// echo what getJSONOffer returns
	echo getJSONOffer($dbConn);
}
catch (Exception $e) {
	echo "Error " . $e->getMessage();
}

function getJSONOffer($dbConn) {
    header("Content-Type: application/json; charset=UTF-8"); 

	try {
	    $sql = "select recordID, recordTitle, catDesc, recordPrice from nmc_special_offers inner join nmc_category on nmc_special_offers.catID = nmc_category.catID order by rand() limit 1";
	   	$rsOffer = $dbConn->query($sql);;
	    $offer = $rsOffer->fetchObject();
	    return json_encode($offer);
	}
	catch (Exception $e) {
		throw new Exception("problem: " . $e->getMessage());
	}
}

?>