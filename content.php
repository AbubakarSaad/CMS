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
			<br />
			<a href="newSubject.php">+ Add a new Subject </a>
		</td>
		<td id="page"> <!-- this is R part of the CRUD which means "Read" -->
			<?php if (!is_null($selSubject)) { // selected subject ?>
				<h2>
					<?php echo $selSubject['menu_name']; ?>
				</h2>
			<?php } elseif (!is_null($selPage)) { // selected Page ?>
				<h2>
					<?php echo $selPage['menu_name']; ?>
				</h2>
				<div id="content">
					<?php echo $selPage['content']; ?>
				</div>
			<?php } else { // nothing selected ?>
				<h2>Select a subject or page to edit</h2>
			<?php } ?>
			<br />
			<a href="editPage.php?page=<?php echo $selPage['id']?>">Edit Page</a>
		</td>
	</tr>
</table>
<?php 
	require("includes/footer.php");
?>

