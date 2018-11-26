<?php
    // Create random playlist of 10 songs
    $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();
    while ($row = mysqli_fetch_array($songQuery)) {
        array_push($resultArray, $row['id']);
    }

    // Convert to JSON to pass to javascript
    $jsonArray = json_encode($resultArray);
?>

<script>
    $(document).ready(function() {
        currentPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        // Dont play when page reloads
        setTrack(currentPlaylist[0], currentPlaylist, false);
    });

    // Only plays if play is true
    function setTrack(trackId, newPlaylist, play) {
        // Get song from db using AJAX
        $.post("Includes/Handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
            var track = JSON.parse(data);
            audioElement.setTrack(track.path);
            audioElement.play();
            $('.controlButton.play').hide();
            $('.controlButton.pause').show();
        });

        if(play) {
            audioElement.play();
        }
    }

    // Functions to play/pause and toggle buttons
    function playSong() {
        $('.controlButton.play').hide();
        $('.controlButton.pause').show();
        audioElement.play();
    }

    function pauseSong() {
        $('.controlButton.play').show();
        $('.controlButton.pause').hide();
        audioElement.pause();
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="assets/images/album-filler.jpg" alt="album" class="albumArtwork">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span>Track Name</span>
                    </span>
                    <span class="artistName">
                        <span>Artist Name</span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle">
                        <img src="assets/images/Icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous">
                        <img src="assets/images/Icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play" title="Play" onclick="playSong();">
                        <img src="assets/images/Icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause" onclick="pauseSong();">
                        <img src="assets/images/Icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next">
                        <img src="assets/images/Icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat">
                        <img src="assets/images/Icons/repeat.png" alt="Repeat">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBG">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume">
                <img src="assets/images/Icons/volume.png" alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBG">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>