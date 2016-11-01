<?php

class Validation(){
public $errors = array();

public static function fieldname_as_text($fieldname) {
	$fieldname = str_replace("_", " ", $fieldname);
	$fieldname = ucfirst($fieldname);
	return $fieldname;
}



public static function has_presence($value) {
	return isset($value) && $value !== "";
}

public static function validate_presences($required_fields) {
	foreach ($required_fields as $field) {
		$value = trim($_POST[$field]);
		if (!has_presence($value)) {
			$errors[$field] = "Поле " . fieldname_as_text($field) . " не может быть пустым";
		}
	  }
	return $errors[$field];	
}


public static function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

public static function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	foreach ($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
		if(!has_max_length($value, $max)) {
			$errors[$field] = "Слишком длинное название раздела";
		}
	}
	return $errors[$field];
}


}



?>