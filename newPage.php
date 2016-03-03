<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirmLoggedIn(); ?>
<?php 
	if(intval($_GET['subj']) == 0){
		redirectTo("content.php");
	}

	include_once("includes/formFunction.php");

	if(isset($_POST['submit'])){
		$errors = array();
		// form validations

		$requireField = array("menu_name", "position", "visible","content");
		$errors = array_merge($errors, checkfields($requireField));

		$fieldsWithLengths = array('menu_name' => 30);
		$errors = array_merge($errors, checkMaxFieldLength($fieldsWithLengths));

		$subjectId = mysql_prep($_GET["subj"]);
		$menuName = mysql_prep($_POST["menu_name"]); 
		$position = mysql_prep($_POST["position"]);
		$visible = mysql_prep($_POST["visible"]);
		$content = mysql_prep($_POST["content"]);
		

		if(empty($errors)){
			// peform update
			$query = "INSERT INTO Pages (subject_id, menu_name, position, visible, content)
				VALUES ({$subjectId}, '{$menuName}', {$position}, {$visible}, '{$content}')";
			$result = mysql_query($query,$connection);
			if($result){
			// success!
				//redirectTo("content.php");
			}else {
				echo "<p>Page creation failed.</p>";
				echo "<p>" . mysql_error() . "</p>";
			}
		}

	} // end: if(isset($_POST['submit'])) 
?>
<?php findSelectedPages(); ?>
<?php include("includes/header.php"); ?>
		
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($selSubject, $selPage); ?>
			<br />
			<a href="newSubject.php">+ Add a new Subject </a>
		</td>
		<td id="page">
			<h2>Create Page</h2>

			<?php if(!empty($message)){
				echo "<p class=\"message\">". $message . "</p>";
			}?>
			<?php
			// output a list of fields that had errors
			if(!empty($errors)){
				displayError($error);
			}
			 ?>
			<form action="newPage.php?subj=<?php echo $selSubject['id']; ?>" method="post">
				<?php $newPage = true; ?>
				<?php include("pageForm.php"); ?>
				<input type="submit" name="submit" value="Create Page">
			</form>
			<br />
			<a href="editSubject.php?subj=<?php echo $selSubject['id']; ?>">Canel</a>
		</td>
	</tr>
</table>
<?php 
	require("includes/footer.php");
?>

