var currentPlaylist = [];
var audioElement;

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    // to print 0 before 3 to be like 6:03
    var extraZero;

    extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
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

    // Event listener for remaining time
    this.audio.addEventListener('canplay', function() {
        var duration = formatTime(this.duration);
        $('.progressTime.remaining').text(duration);
    });
}