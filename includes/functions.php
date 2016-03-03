<?php
	// this file is store all basic funciton
	function mysql_prep($value){
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_escape_string"); // ie PHP >= v4.3.0

		if($new_enough_php){
			// undo any magic quotes effects so mysql_real_escape_quotes can do the work
			if($magic_quotes_active){
				$value = stripcslashes($value);
			}
			$value = mysql_real_escape_string($value);
		}else {
			// if magic quotes aren't on then add slashes manually 
			if(!$magic_quotes_active){
				$value = addslashes($value);
				// if magic quotes are on the slashes already exits
			}
		}
		return $value;
	}

	function redirectTo($location = NULL){
		if($location != NULL){
			header("location: {$location}");
			exit;
		}
	}

	function confirmQuery($reusltSet) {
		if(!$reusltSet){
			die("DB query failed: " . mysql_error());
		}
	}

	function getAllSubjects($public = true){
		global $connection;
		$query = "SELECT * 
				FROM subjects ";
		if($public){ 
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subjectSet = mysql_query($query, $connection); 
		confirmQuery($subjectSet);
		return $subjectSet;

	}

	function getPageForSubject($subject_id, $public = true){
		global $connection;
		$query = "SELECT * 
				FROM Pages  
				WHERE subject_id = {$subject_id} ";
		if($public){
			$query .="AND visible = 1 "; 
		}
		$query .="ORDER BY position ASC";
		$pageSet = mysql_query($query, $connection); 
		confirmQuery($pageSet);
		return $pageSet;
	}

	function getSubjectById($subject_id){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id . " ";
		$query .= "LIMIT 1";
		$resultSet = mysql_query($query, $connection);
		confirmQuery($resultSet);
		// if no rows are returned and fetch_array will return false
		if ($subject = mysql_fetch_array($resultSet)){
			return $subject;
		}else {
			return NULL;
		}
	}

	function getPageById($page_id){
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM Pages ";
		$query .= "WHERE id=" . $page_id . " ";
		$query .= "LIMIT 1";
		$resultSet = mysql_query($query, $connection);
		confirmQuery($resultSet);
		if ($page = mysql_fetch_array($resultSet)){
			return $page;
		}else {
			return NULL;
		}
	}
	function getDefaultPage($subject_id){
		// selects the subjects
		$pageSet = getPageForSubject($subject_id, true);
		if($firstPage = mysql_fetch_array($pageSet)){
			return $firstPage;
		}else {
			return NULL;
		}
	}
	function findSelectedPages() {
		global $selSubject;
		global $selPage;
		if(isset($_GET['subj'])){
			$selSubject = getSubjectById($_GET['subj']);
			$selPage = getDefaultPage($selSubject["id"]);
		} elseif (isset($_GET['page'])) {
			$selSubject = NULL;
			$selPage = getPageById($_GET['page']);
		} else {
			$selSubject = NULL;
			$selPage = NULL;
		}
	}

	function navigation($selSubject, $selPage, $public = false){
		$output = "<ul class=\"subjects\">"; 
			// step 3.
			$subjectSet = getAllSubjects($public);

			// step 4.
			while ($subject = mysql_fetch_array($subjectSet)) {
				$output .= "<li"; 
				if($subject["id"] == $selSubject['id']){
					$output .= " class=\"selected\"";
				}
				$output .= "><a href=\"editSubject.php?subj=" . urlencode($subject["id"]) . 
					"\">{$subject["menu_name"]}</a></li>";

				$pageSet = getPageForSubject($subject["id"], $public);

				$output .= "<ul class=\"pages\">";
				while ($page = mysql_fetch_array($pageSet)) {
					$output .= "<li";
					if($page["id"] == $selPage['id']){
						$output .= " class=\"selected\"";
					} 
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]). 
					"\">{$page["menu_name"]}</a></li>";

				}
				$output .= "</ul>";
			}
			

		$output .= "</ul>";
		return $output;
	}

	function publicNav($selSubject,$selPage, $public = true){
		$output = "<ul class=\"subjects\">"; 
			// step 3.
			$subjectSet = getAllSubjects($public);

			// step 4.
			while ($subject = mysql_fetch_array($subjectSet)) {
				$output .= "<li"; 
				if($subject["id"] == $selSubject['id']){
					$output .= " class=\"selected\"";
				}
				$output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . 
					"\">{$subject["menu_name"]}</a></li>";

				if($subject["id"] == $selSubject['id']){
					$pageSet = getPageForSubject($subject["id"]);

					$output .= "<ul class=\"pages\">";
					while ($page = mysql_fetch_array($pageSet)) {
						$output .= "<li";
						if($page["id"] == $selPage['id']){
							$output .= " class=\"selected\"";
						} 
					$output .= "><a href=\"index.php?page=" . urlencode($page["id"]). 
						"\">{$page["menu_name"]}</a></li>";

					}
					$output .= "</ul>";
				}
				}
			

		$output .= "</ul>";
		return $output;
	}

	
?>