<?php
    // If request was sent with AJAX not manually typing url
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        include("Includes/config.php");
        include("Includes/classes/User.php");
        include("Includes/classes/Artist.php");
        include("Includes/classes/Album.php");
        include("Includes/classes/Song.php");
        include("Includes/classes/Playlist.php");

        if(isset($_GET['userLoggedIn'])) {
            $userLoggedIn = new User($con, $_GET['userLoggedIn']);
        }
        else {
            echo "username not passed";
            exit(); //Dont load rest of the page
        }
    }
    else { //manualy url or pressed on link
        include("Includes/header.php");
        include("Includes/footer.php");
        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url')</script>";
        // To prevent from executing the if condition again after loading content with AJAX
        exit();
    }
?>