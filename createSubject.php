<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirmLoggedIn(); ?>
<?php 
	$errors = array();
	// form validations

	$requireFeild = array('menu_name', 'position', 'visible');
	foreach($requireFeild as $fieldName){
		if(!isset($_POST[$fieldName]) || empty($_POST[$fieldName])){
			$errors[] = $fieldName;
		}
	}

	$fieldsWithLengths = array('menu_name' => 30);
	foreach ($fieldsWithLengths as $fieldName => $maxLength) {
		if(strlen(trim(mysql_prep($_POST[$fieldName]))) > $maxLength){
			$errors[] = $fieldName;
		}
	}

	if(!empty($errors)){
		redirectTo("newSubject.php");
	}
?>
<?php 
	$menuName = mysql_prep($_POST["menu_name"]); 
	$position = mysql_prep($_POST["position"]);
	$visible = mysql_prep($_POST["visible"]);
?>
<?php 
	$query = "INSERT INTO subjects (menu_name, position, visible)
			VALUES ('{$menuName}', {$position}, {$visible})";
	$result = mysql_query($query,$connection);
	if($result){
		// success!
		redirectTo("content.php");
	}else {
		echo "<p>Subject creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}

?>

<?php 
	mysql_close($connection);
?>