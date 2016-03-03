<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	if(intval($_GET['subj']) == 0){
		redirectTo("content.php");
	}
	if(isset($_POST['submit'])){
		$errors = array();
		// form validations

		$requireFeild = array("menu_name", "position", "visible");
		foreach($requireFeild as $fieldName){
			if(!isset($_POST[$fieldName]) || (empty($_POST[$fieldName]) && $_POST[$fieldName] != 0)){
				$errors[] = $fieldName;
			}
		}

		$fieldsWithLengths = array('menu_name' => 30);
		foreach ($fieldsWithLengths as $fieldName => $maxLength) {
			if(strlen(trim(mysql_prep($_POST[$fieldName]))) > $maxLength){
				$errors[] = $fieldName;
			}
		}

		if(empty($errors)){
			// peform update
			$id = mysql_prep($_GET['subj']);
			$menuName = mysql_prep($_POST["menu_name"]); 
			$position = mysql_prep($_POST["position"]);
			$visible = mysql_prep($_POST["visible"]);

			$query = "UPDATE subjects SET
					menu_name = '{$menuName}', 
					position = {$position},
					visible = {$visible}
					WHERE id = {$id}";
			$result = mysql_query($query, $connection);
			if(mysql_affected_rows()==1){
				// Succes
				$message = "The subject was successfully updated.";
			}else{
				// failed
				$message = "Subject update failed";
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
		</td>
		<td id="page">
			<h2>Edit Subject: <?php echo $selSubject['menu_name'];?></h2>

			<?php if(!empty($message)){
				echo "<p class=\"message\">". $message . "</p>";
			}?>
			<?php
			// output a list of fields that had errors
			if(!empty($errors)){
				echo "<p class=\"errors\">";
				echo "Please review the following field: <br />";
				foreach($errors as $error){
					echo "-" . $error . "<br/>";
				}
				echo "</p>";
			}
			 ?>
			<form action="editSubject.php?subj=<?php echo urlencode($selSubject['id'])?>" method="post">
				<p>Subject name: 
					<input type="text" name="menu_name" value="<?php echo $selSubject['menu_name']; ?>" id="menu_Name">
				</p>
				<p>Position: 
					<select name="position">

					<?php 
						$subjectSet = getAllSubjects();
						$subjectCount = mysql_num_rows($subjectSet);
						// $subjectCount + 1 b/c we are adding the subject
						for($count=1; $count<=$subjectCount+1; $count++){
							echo "<option value=\"{$count}\"";
							if($selSubject['position'] == $count){
								echo " selected";
							}
							echo ">{$count}</option>";
						}
					?>
					</select>
				</p>

				<p>Visible:
					<input type="radio" name="visible" value="0" <?php 
					if($selSubject['visible'] == 0){echo " checked";}
					?> /> NO
					&nbsp;
					<input type="radio" name="visible" value="1" <?php 
					if($selSubject['visible'] == 1){echo " checked";}
					?> /> YES
				</p>

				<input type="submit" name="submit" value="Edit Subject">
				&nbsp;
				&nbsp;
				<a href="deleteSubject.php?subj=<?php echo urlencode($selSubject['id']); ?>" 
					onclick="return confirm('Are you sure');">Delete Subject</a>
			</form>
			<br />
			<a href="content.php">Canel</a>
			<div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>Page in this Subject:</h3>
				<ul>
				<?php 
					$subjectPage = getPageForSubject($selSubject['id']);
					while ($page = mysql_fetch_array($subjectPage)) {
						echo "<li><a href=\"content.php?page={$page['id']}\">{$page['menu_name']}</a></li>";
					 	
					 } 
				?>
				</ul>
				<br />
				+ <a href="newPage.php?subj=<?php echo $selSubject['id']?>">Add a new page</a>
			</div>
		</td>
	</tr>
</table>
<?php 
	require("includes/footer.php");
?>

