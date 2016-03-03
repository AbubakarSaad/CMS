<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	
	if(loggedIn()){
		redirectTo("staff.php");
	}
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
			$query = "SELECT id, username ";
			$query .= "FROM users ";
			$query .= "WHERE username = '{$username}' ";
			$query .= "AND hashed_password = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			$resultSet = mysql_query($query);
			confirmQuery($resultSet);
			if(mysql_num_rows($resultSet) == 1){
			// username and password authenticaed
			// only 1 found
			$foundUser = mysql_fetch_array($resultSet);
			$_SESSION["user_id"] = $foundUser["id"];
			$_SESSION["username"] = $foundUser["username"];
			redirectTo("staff.php");
			}else {
				$message = "username/password combination is incorrect <br /> please try again" . mysql_error();
			}
		}
	}else {
		if(isset($_GET["logout"]) && $_GET["logout"] == 1){
			$message = "You are now logged out";
		}

		$username = "";
		$password = "";
	}
?>
<?php include("includes/header.php"); ?>
		<table id="structure">
			<tr>
				<td id="navigation">
					<a href="index.php">Return to publicSite</a>
				</td>
				<td id="page">
					<h2>Login</h2>
					<?php if(!empty($message)){ echo "<p class=\"message\">". $message . "</p>"; }?>
			<?php if(!empty($errors)){ displayError($error); }?>
					<form action="login.php" method="post">
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
								<td colspan="2"><input type="submit" name="submit" value="Login"></td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
<?php 
	include("includes/footer.php");
?>