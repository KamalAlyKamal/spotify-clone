<?php
    include("../../config.php");

    if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
        $playlistId = $_POST['playlistId'];
        $songId = $_POST['songId'];

        // Get last order to put the song in
        $orderIdQuery = mysqli_query($con, "SELECT MAX(playlistOrder) + 1 AS playlistOrder FROM playlistssongs WHERE playlistId='$playlistId'");

        $row = mysqli_fetch_array($orderIdQuery);
        $order = $row['playlistOrder'];

        $query = mysqli_query($con, "INSERT INTO playlistssongs VALUES('', '$songId', '$playlistId', '$order')");
    }
    else {
        echo "playlistId or songId was not passed";
    }
?>