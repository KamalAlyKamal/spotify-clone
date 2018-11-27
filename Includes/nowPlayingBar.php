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
        // Set volume progress bar initially
        updateVolumeProgressBar(audioElement.audio);
        
        // Prevent playingBar controls from getting highlighted when dragging
        $("#nowPlayingBar").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });

        // Dragging progress bar
        $('.playbackBar .progressBar').mousedown(function() {
            mouseDown = true;
        });
        $('.playbackBar .progressBar').mousemove(function(e) {
            if(mouseDown) {
                // Set time of song depending on mouse position
                timeFromOffset(e, this);
            }
        });
        $('.playbackBar .progressBar').mouseup(function(e) {
            timeFromOffset(e, this);
        });


        // Dragging volume bar
        $('.volumeBar .progressBar').mousedown(function() {
            mouseDown = true;
        });
        $('.volumeBar .progressBar').mousemove(function(e) {
            if(mouseDown) {
                var percentage = e.offsetX / $(this).width();
                if(percentage >=0 && percentage <=1) {
                    audioElement.audio.volume = percentage;
                }
            }
        });
        $('.volumeBar .progressBar').mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();
            if(percentage >=0 && percentage <=1) {
                audioElement.audio.volume = percentage;
            }
        });


        $(document).mouseup(function() {
            mouseDown = false;
        });
    });

    // Get time of song from mouse offset (Start offset)
    function timeFromOffset(mouse, progressBar) {
        // get offset of mouse in X direction
        var percentage = ( mouse.offsetX / $(progressBar).width() ) * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    // Only plays if play is true
    function setTrack(trackId, newPlaylist, play) {
        // Get song from db using AJAX
        $.post("Includes/Handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
            // Parse returned string array into json
            var track = JSON.parse(data);

            $('.trackName span').text(track.title);
            
            // AJAX call to get artist
            $.post("Includes/Handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
                var artist = JSON.parse(data);
                $('.artistName span').text(artist.name);
            });

            // AJAX call to get album
            $.post("Includes/Handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
                var album = JSON.parse(data);
                $('.albumLink img').attr("src", album.artworkPath);
            });

            audioElement.setTrack(track);
            // audioElement.play();
        });

        if(play) {
            $('.controlButton.play').hide();
            $('.controlButton.pause').show();
            audioElement.play();
        }
    }

    // Functions to play/pause and toggle buttons
    function playSong() {
        // Update song count only if currentTime = 0 (just played not paused then played)
        if(audioElement.audio.currentTime == 0) {
            // AJAX call to update song play count
            $.post("Includes/Handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
        }


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
                    <img src="" alt="album" class="albumArtwork">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span></span>
                    </span>
                    <span class="artistName">
                        <span></span>
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