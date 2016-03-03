<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirmLoggedIn(); ?>
<?php findSelectedPages(); ?>
<?php include("includes/header.php"); ?>
		
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($selSubject, $selPage); ?>
		</td>
		<td id="page">
			<h2>Add subject</h2>
			<form action="createSubject.php" method="post">
				<p>Subject name: 
					<input type="text" name="menu_name" value="" id="menu_Name">
				</p>
				<p>Position: 
					<select name="position">
					<?php 
						$subjectSet = getAllSubjects();
						$subjectCount = mysql_num_rows($subjectSet);
						// $subjectCount + 1 b/c we are adding the subject
						for($count=1; $count<=$subjectCount+1; $count++){
							echo "<option value=\"{$count}\">{$count}</option>";
						}
					?>
						
					</select>
				</p>
				<p>Value:
					<input type="radio" name="visible" value="0" /> NO
					&nbsp;
					<input type="radio" name="visible" value="1" /> YES
				</p>
				<input type="submit" value="Add Subject">
			</form>
			<br />
			<a href="content.php">Canel</a>
		</td>
	</tr>
</table>
<?php 
	require("includes/footer.php");
?>

