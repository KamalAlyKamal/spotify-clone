<?php 
function sanitizeFormUserName($stringInput){
	$stringInput = strip_tags($stringInput);
	$stringInput = str_replace(" ", "", $stringInput);
	return $stringInput;
}

function sanitizeFormString($stringInput){
	$stringInput = strip_tags($stringInput);
	$stringInput = str_replace(" ", "", $stringInput);
	$stringInput=ucfirst(strtolower($stringInput));
	return $stringInput;
}

function sanitizeFormPassword($stringInput)
{
	$stringInput = strip_tags($stringInput);
	return $stringInput;
}

if (isset($_POST["registerButton"])) {
	$username = sanitizeFormUserName($_POST["username"]);
	$firstName = sanitizeFormString($_POST["firstName"]);
	$lastName = sanitizeFormString($_POST["lastName"]);
	$email = sanitizeFormString($_POST["email"]);
	$email2 = sanitizeFormString($_POST["email2"]);
	$password = sanitizeFormPassword($_POST["password"]);
	$password2 = sanitizeFormPassword($_POST["password2"]);

	$wasSuccessful = $account->register($username,$firstName,$lastName,$email,$email2,$password,$password2);
	if($wasSuccessful){
		$_SESSION['userLoggedIn'] = $username;
		header("Location:index.php");
	}
}

 ?>