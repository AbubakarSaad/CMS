<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php findSelectedPages(); ?>
<?php include("includes/header.php"); ?>
		
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo publicNav($selSubject,$selPage); ?>
		</td>
		<td id="page"> <!-- this is R part of the CRUD which means "Read" -->
			<?php if ($selPage) { // selected Page ?>
				<h2>
					<?php echo htmlentities($selPage['menu_name']); ?>
				</h2>
				<div id="pageContent">
					<?php echo strip_tags(nl2br($selPage['content'], "<b><br/><a>")); ?>
				</div>
			<?php } else { // nothing selected ?> 
				<h2>Welcome to Widget Crop</h2>
			<?php } ?>
		</td>
	</tr>
</table>
<?php 
	require("includes/footer.php");
?>

