<?php require_once("includes/session.php"); ?>
<?php confirmLoggedIn(); ?>
<?php // this page is includes by editpage?>
<?php if(!isset($newPage)){$newPage = false; }?>


<p>Page name: 
	<input type="text" name="menu_name" value="<?php echo $selPage['menu_name']; ?>" id="menu_Name">
</p>
<p>Position: <select name="position">
	<?php 
		if(!$newPage){
			$pageSet = getPageForSubject($selPage['subject_id']);
			$pageCount = mysql_num_rows($pageSet);
		}else{
			$pageSet = getPageForSubject($selSubject['id']);
			$pageCount = mysql_num_rows($pageSet) + 1;
		}
		// $subjectCount + 1 b/c we are adding the subject
		for($count=1; $count<=$pageCount+1; $count++){
			echo "<option value=\"{$count}\"";
				if($selPage['position'] == $count){
					echo " selected";
				}
			echo ">{$count}</option>";
		}
	?>
</select></p>
<p>Visible:
	<input type="radio" name="visible" value="0" <?php 
		if($selPage['visible'] == 0){echo " checked";}
	?> /> NO
	&nbsp;
	<input type="radio" name="visible" value="1" <?php 
		if($selPage['visible'] == 1){echo " checked";}
	?> /> YES
</p>
<p>Content: <br />
	<textarea name="content" rows="20" cols="80"><?php echo $selPage['content']; ?></textarea>
</p>