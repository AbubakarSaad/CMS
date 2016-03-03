<?php 
	include("constants.php");
	// step 1
	$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	if(!$connection){
		die("Db connection failed: " . mysql_error());
	}

	// step 2 
	$dbSelect = mysql_select_db(DB_NAME, $connection);
	if(!$dbSelect){
		die("DB selection failed: " . mysql_error());
	}
?>