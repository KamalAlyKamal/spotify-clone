<?php 
	class Account 
	{
		private $errorArray;

		public	function __construct() {
			# code...
			$this->errorArray = array();
		}

		public function register($username,$firstName,$lastName,$email,$email2,$password,$password2) {
    		$this->validateUsername($username);
			$this->validateFistName($firstName);
			$this->validateLastName($lastName);
			$this->validateEmails($email, $email2);
			$this->validatePasswords($password, $password2);
			if(empty($this->errorArray))
			{
				//insert into database 
				return true;
			}
			else
			{
				return false ;

			}
		}

		public function getError($error){
			if(!in_array($error,$this->errorArray)){
				$error="";
			}
			return "<span class='errorMessage'> $error </span>";
		}

		private function validateUsername($un) {
			if (strlen($un)>25 || strlen($un)< 5) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}
			//check if this exist in table
		}

		private function validateFistName($fn) {
			if (strlen($fn)>25 || strlen($fn)< 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		private function validateLastName($ln) {
			if (strlen($ln)>25 || strlen($ln)< 2) {
				array_push($this->errorArray,Constants::$lastNameCharacters);
				return;
			}
		}

		private function validateEmails($em, $em2) {
			if($em != $em2){
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return; 
			}
			if(!filter_var($em,FILTER_VALIDATE_EMAIL)){
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}
			//check if the email is not in data base 

		}

		private function validatePasswords($pw, $pw2) {	
			if($pw != $pw2){
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return; 
			}
			if(preg_match("/[^a-zA-Z0-9_$!@%&*]/", subject)){
				array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
				return;	
			}
			if(strlen($pw) >30 || strlen($pw)<4 ){
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}		
		}
	}

?>