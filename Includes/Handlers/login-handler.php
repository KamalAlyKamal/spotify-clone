<?php 
    if (isset($_POST["loginButton"])) {
        $username = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];

        $result = $account->login($username, $password);

        if ($result) {
            header("Location: index.php");
        }
    }
?>