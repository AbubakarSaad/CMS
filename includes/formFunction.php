<?php 
	// form functions
	function checkFields($requireArray){
		$fieldError = array();
		foreach($requireArray as $fieldName){
			if(!isset($_POST[$fieldName]) || (empty($_POST[$fieldName]) && $_POST[$fieldName] != 0)){
				$fieldError[] = $fieldName;
			}
		}
		return $fieldError;
	}

	function checkMaxFieldLength($fieldLengthError){
		$fieldError = array();
		foreach ($fieldLengthError as $fieldName => $maxLength) {
			if(strlen(trim(mysql_prep($_POST[$fieldName]))) > $maxLength){
				$fieldError[] = $fieldName;
			}
		}
		return $fieldError;
	}
	
	function displayError($errorArray){
		echo "<p class=\"errors\">";
		echo "Please review the following field: <br />";
		foreach($errorArray as $error){
			echo "-" . $error . "<br/>";
		}
		echo "</p>";
	}
?>