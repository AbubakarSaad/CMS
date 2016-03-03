<?php 
	session_start(); 
	function loggedIn(){
		return isset($_SESSION['user_id']);
	}
	function confirmLoggedIn(){
		if(!loggedIn()){
			redirectTo("login.php");
		}
	}
?>