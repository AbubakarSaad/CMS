<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirmLoggedIn(); ?>
<?php 
	include_once("includes/formFunction.php");

	if(isset($_POST['submit'])){
		$errors = array();
		// form validations

		$requireField = array("username", "password");
		$errors = array_merge($errors, checkfields($requireField));

		$fieldsWithLengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, checkMaxFieldLength($fieldsWithLengths));

		$username = trim(mysql_prep($_POST["username"]));
		$password = trim(mysql_prep($_POST["password"]));
		$hashed_password = sha1($password);

		if(empty($errors)){
			// peform update
			$query = "INSERT INTO users (username, hashed_password)
				VALUES ('{$username}', '{$hashed_password}')";
			$result = mysql_query($query,$connection);
			if($result){
			// success!
			$message ="the user was successfully created";
			}else {
				$message .="user creation failed";
				$message .="<br/>" . mysql_error();
			}
		}
	}else {
		$username = "";
		$password = "";
	}


?>
<?php include("includes/header.php"); ?>
		<table id="structure">
			<tr>
				<td id="navigation">
					<a href="staff.php">Return to mainmenu</a>
				</td>
				<td id="page">
					<h2>Create User</h2>
					<?php if(!empty($message)){ echo "<p class=\"message\">". $message . "</p>"; }?>
			<?php if(!empty($errors)){ displayError($error); }?>
					<form action="new_user.php" method="post">
						<table>
							<tr>
								<td>Username:</td> 
								<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username);?>"><br/></td>
							</tr>
							<tr>
								<td>Password:</td>
								<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password);?>"><br/></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" name="submit" value="Create User"></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
<?php 
	include("includes/footer.php");
?>