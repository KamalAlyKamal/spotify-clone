<?php
    include("../../config.php");

    if(isset($_POST['songId'])) {
        $songId = $_POST['songId'];

        $songQuery = mysqli_query($con, "DELETE FROM songs WHERE id='$songId'");

        $playlistssongsQuery = mysqli_query($con, "DELETE FROM playlistssongs WHERE songId='$songId'");
    }
    else {
        echo "songId was not passed";
    }
?>