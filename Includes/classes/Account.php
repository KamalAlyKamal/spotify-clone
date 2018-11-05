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

		private function validateUsername($un) {
			if (strlen($un)>25 || strlen($un)< 5) {
				array_push($this->errorArray, "Your username must be between 5 and 25 characters");
				return;
			}
			//check if this exist in table
		}

		private function validateFistName($fn) {
			if (strlen($fn)>25 || strlen($fn)< 2) {
				array_push($this->errorArray, "Your first name must be between 2 and 25 characters");
				return;
			}
		}

		private function validateLastName($ln) {
			if (strlen($ln)>25 || strlen($ln)< 2) {
				array_push($this->errorArray, "Your last name must be between 2 and 25 characters");
				return;
			}
		}

		private function validateEmails($em, $em2) {
			if($em != $em2){
				array_push($this->errorArray, "Your emails must match");
				return; 
			}
			if(!filter_var($em,FILTER_VALIDATE_EMAIL)){
				array_push($this->errorArray, "Invalid email");
				return;
			}
			//check if the email is not in data base 

		}

		private function validatePasswords($pw, $pw2) {	
			if($pw != $pw2){
				array_push($this->errorArray, "Your passwords must match");
				return; 
			}
			if(preg_match("/[^a-zA-Z0-9_$!@%&*]/", subject)){
				array_push($this->errorArray, "Your password must contain only number and letter and these special characters[_$!@%&*]");
				return;	
			}
			if(strlen($pw) >30 || strlen($pw)<4 ){
				array_push($this->errorArray, "your password must be between 4 and 30 ");
				return;
			}		
		}
	}

?>