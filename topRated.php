<?php
    // include("Includes/config.php");
    include("Includes/includedFiles.php");
?>
<h2 class="topRatedHeading">TOP 10</h2>
<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
            $songsQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY plays DESC LIMIT 10");
            $songIdArray = array();
            while($row = mysqli_fetch_array($songsQuery)) {
                array_push($songIdArray, $row['id']);
            }

            $count = 1;
            foreach($songIdArray as $songId) {
                $albumSong = new Song($con, $songId);
                $albumArtist = $albumSong->getArtist();

                echo    "<li class='tracklistRow'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/Icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                                <span class='trackNumber'>$count.</span>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                <span class='artistName'>" . $albumArtist->getName() . "</span>
                            </div>
                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img class='optionButton' src='assets/images/Icons/more.png' onclick='showOptionsMenu(this)'>
                            </div>
                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>
                            </div>  
                        </li>";
                
                $count += 1;
            }
            
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>