<?php
    include("../../config.php");

    if(isset($_POST['userId'])) {
        $userId = $_POST['userId'];
        $userDataQuery = mysqli_query($con, "SELECT * FROM users WHERE id='$userId'");
        $result = mysqli_fetch_array($userDataQuery);
        $username = $result['username'];

        $userQuery = mysqli_query($con, "DELETE FROM users WHERE id='$userId'");

        $playlistsDataQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

        while ($row = mysqli_fetch_array($playlistsDataQuery)) {
            $playlistId = $row['id'];
            $songsQuery = mysqli_query($con, "DELETE FROM playlistssongs WHERE playlistId='$playlistId'");
        }

        $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE owner='$username'");

        
    }
    else {
        echo "userId was not passed";
    }
?>