<?php
    include("../../config.php");

    if(!isset($_POST['username'])) {
        echo "ERROR: Could not set username";
        exit();
    }
    
    if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
        echo "Not all password have been set";
        exit();
    }

    if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
        echo "Please fill all passwords";
        exit();
    }

    $username = $_POST['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    $oldMD5 = md5($oldPassword);

    $passwordCheckQuery = mysqli_query($con, "SELECT * FROM users where username='$username' AND password='$oldMD5'");
    if(mysqli_num_rows($passwordCheckQuery) == 0) {
        echo "Password is incorrect";
        exit();
    }

    if($newPassword1 != $newPassword2) {
        echo "Your new passwords do not match";
        exit();
    }

    if(preg_match('/[^a-zA-Z0-9_$!@%&*]/', $newPassword1)) {
        echo "Your new password must not contain illegal special characters.";
        exit();
    }

    if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5) {
        echo "Your new password must be between 5 and 30 characters";
        exit();
    }


    $newMD5 = md5($newPassword1);

    $query = mysqli_query($con, "UPDATE users SET password='$newMD5' WHERE username='$username'");
    echo "Password updated successfully!";
?>