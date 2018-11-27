/******************** GLOBAL VARIABLES START *****************************/
var currentPlaylist = [];
var shuffledPlaylist = [];
// Temp playlist for the album which the user is on
var tempPlaylist = [];
var audioElement;
// Check if mouse is currently pressed or not
var mouseDown = false;
// currentIndex of currentlyPlaying song (to use with next/previous)
var currentIndex = 0;
var repeat = false;
var shuffle = false;
/******************** GLOBAL VARIABLES END *****************************/

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    // to print 0 before 3 to be like 6:03
    var extraZero;

    extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $('.progressTime.current').text(formatTime(audio.currentTime));
    $('.progressTime.remaining').text(formatTime(audio.duration - audio.currentTime));

    var progress = ( audio.currentTime / audio.duration ) * 100;
    $('.playbackBar .progress').css('width', progress + '%');
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $('.volumeBar .progress').css('width', volume + '%');
}

function Audio() {
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

    // Event listener for duration
    this.audio.addEventListener('canplay', function() {
        var duration = formatTime(this.duration);
        $('.progressTime.remaining').text(duration);
    });

    // Event listener for remaining time
    this.audio.addEventListener('timeupdate', function() {
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    // Event listener for volume change
    this.audio.addEventListener('volumechange', function() {
        updateVolumeProgressBar(this);
    });

    // Event listener for song end
    this.audio.addEventListener('ended', function() {
        nextSong();
    });
}