<?php

$errors = array();

function fieldname_as_text($fieldname) {
	$fieldname = str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);

	return $fieldname;
}

// PRESENCE
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
	return isset($value) && $value !== "" && $value !== " ";
}

function validate_presences($required_fields){
	global $errors;

	foreach($required_fields as $field) {
		$value = trim($_POST[$field]);
	//	$value = str_replace(" ", "", $_POST[$field]);

		if(!has_presence($value)){
			$errors[$field] = fieldname_as_text($field) . " can't be blank";
		}
	}
}


// string length
// min length
function has_min_length($value, $min) {
	return strlen($value) >= $min;
}

function validate_min_lengths($fields_with_min_lengths){
	global $errors;
	//expects an assoc. array
	foreach($fields_with_min_lengths as $field => $min){

		$value = trim($_POST[$field]);
	//	$value = str_replace(" ", "", $_POST[$field]);

		if(!has_min_length($value, $min)){
			$errors[$field] = fieldname_as_text($field) . " is too short ";
			$message = fieldname_as_text($field) . " is too short ";
		//	echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}
}


// string length
// max length
function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths){
	global $errors;
	//expects an assoc. array
	foreach($fields_with_max_lengths as $field => $max){

		$value = trim($_POST[$field]);

		if(!has_max_length($value, $max)){
			$errors[$field] = fieldname_as_text($field) . " is too long ";
		}
	}
}



?>

