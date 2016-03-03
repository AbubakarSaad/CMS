<?php require_once("includes/functions.php"); ?>
<?php 
	// logging out
	// step 1
	session_start();

	// 2. Unset all the session varible
	$_SESSION = array();

	// 3. destory the session cookie
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time()-42000, '/');
	}

	// 4. Destory the session
	session_destroy();

	redirectTo("login.php?logout=1");

?>