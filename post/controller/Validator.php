<?php


class Validator {
	
	public function validateEmail($email) {
		$emailRegEx = '/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/';
 		if(preg_match($emailRegEx,$email))	{
 		return true;
 		}
  	return false;
	}
	
}
?>