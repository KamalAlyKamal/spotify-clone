<?php
    include("Includes/includedFiles.php");
?>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>
        <div class="buttonItems">
            <button class="button green" onclick="createPlaylist('asdsadsad');">CREATE PLAYLIST</button>
        </div>

        <?php 
            $username = $userLoggedIn->getUsername();
            $playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

            if(mysqli_num_rows($playlistsQuery) == 0) {
                echo "<p class='noResults'>You do not have any playlists.</p>";
            }

            while ($row = mysqli_fetch_array($playlistsQuery)) {
                $playlist = new Playlist($con, $row);

                echo    "<div class='gridViewItem pointer' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                            <div class='playlistImage'>
                                <img src='assets/images/Icons/playlist.png'>
                            </div>
                            <div class='gridViewInfo'>"
                                . $playlist->getName() .
                            "</div>
                        </div>";
            }
        ?>
    </div>
</div>