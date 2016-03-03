<?php 
function navigation($selSubject, $selPage){
		$output = "<ul class=\"subjects\">"; 
			// step 3.
			$subjectSet = getAllSubjects();

			// step 4.
			while ($subject = mysql_fetch_array($subjectSet)) {
				$output .= "<li"; 
				if($subject["id"] == $selSubject['id']){
					$output .= " class=\"selected\"";
				}
				$output .= "><a href=\"editSubject.php?subj=" . urlencode($subject["id"]) . 
					"\">{$subject["menu_name"]}</a></li>";

				$pageSet = getPageForSubject($subject["id"]);

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
?>