
<?php 
function santizeFormUserName($stringInput){
	$stringInput = strip_tags($stringInput);
	$stringInput = str_replace(" ", "", $stringInput);
	return $stringInput;
}

function santizeFormStrings($stringInput){
	$stringInput = strip_tags($stringInput);
	$stringInput = str_replace(" ", "", $stringInput);
	$stringInput=ucfirst(strtolower($stringInput));
	return $stringInput;
}

function santizeFormPassword($stringInput)
{
	$stringInput = strip_tags($stringInput);
	return $stringInput;
}

if (isset($_POST["loginButton"])) {
	echo "hello you have signed in with" . $_POST["loginUsername"];
	# code...
}

if (isset($_POST["registerButton"])) {
	# code...
	$userName = santizeFormUserName($_POST["username"]);
	$firstName = santizeFormStrings($_POST("firstName"));
	$lastName = santizeFormStrings($_POST("lastName"));
	$email1 = santizeFormStrings($_POST("email"));
	$email2 = santizeFormStrings($_POST("email2"));
	$password1 = santizeFormPassword($_POST("password"));
	$password2 = santizeFormPassword($_POST("password2"));
}

 ?>