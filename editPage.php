<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirmLoggedIn(); ?>
<?php 
	if(intval($_GET['page']) == 0){
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

		$id = mysql_prep($_GET['page']);
		$menuName = trim(mysql_prep($_POST["menu_name"])); 
		$position = mysql_prep($_POST["position"]);
		$visible = mysql_prep($_POST["visible"]);
		$content = mysql_prep($_POST["content"]);

		if(empty($errors)){
			// peform update
			$query = "UPDATE Pages SET
					menu_name = '{$menuName}', 
					position = {$position},
					visible = {$visible},
					content = '{$content}'
					WHERE id = {$id}";
			$result = mysql_query($query, $connection);
			if(mysql_affected_rows()==1){
				// Succes
				$message = "The Page was successfully updated.";
			}else{
				// failed
				$message = "Page update failed";
				$message .= "<br/>" . mysql_error(); 
			}

		}else {
			// errors occured
			$message = "There were " . count($errors) . " errors in the form.";
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
			<h2>Edit Page: <?php echo $selPage['menu_name'];?></h2>

			<?php if(!empty($message)){
				echo "<p class=\"message\">". $message . "</p>";
			}?>
			<?php
			// output a list of fields that had errors
			if(!empty($errors)){
				displayError($error);
			}
			 ?>
			<form action="editPage.php?page=<?php echo urlencode($selPage['id'])?>" method="post">
				<?php include("pageForm.php"); ?>
				<input type="submit" name="submit" value="Update Page">
				&nbsp;
				&nbsp;
				<a href="deletePage.php?page=<?php echo urlencode($selPage['id']); ?>" 
					onclick="return confirm('Are you sure');">Delete Page</a>
			</form>
			<br />
			<a href="content.php?page=<?php echo $selPage['id']; ?>">Canel</a>
		</td>
	</tr>
</table>
<?php 
	require("includes/footer.php");
?>

