<?php
    
?>
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
                    <button class="controlButton play" title="Play">
                        <img src="assets/images/Icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause">
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