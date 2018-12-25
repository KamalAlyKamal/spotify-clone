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

var userLoggedIn;
// Timer used in search
var timer;
/******************** GLOBAL VARIABLES END *****************************/

// Hides optionsMenu on scroll event
$(window).scroll(hideOptionsMenu);

$(document).click(function(clickEvent) {
    // Get element that was clicked on
    var target = $(clickEvent.target);
    // If target was not optionButton or item, hide it
    if(!target.hasClass("item") && !target.hasClass("optionButton")) {
        hideOptionsMenu();
    }
});

// Functions that is run on dropdown option click
$(document).on("change", "select.playlist", function() {
    var selectMenu = $(this);
    var playlistId = $(this).val();
    var songId = $(this).prev(".songId").val();

    $.post("Includes/Handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId }, function(err) {
        if(err != "") {
            console.log(err);
            return;
        }

        hideOptionsMenu();
        // Reset optionsMenu
        selectMenu.val("");
    });
});

function logout() {
    $.post("Includes/Handlers/ajax/logout.php", function() {
        // reload current page
        location.reload();
    });
}

function updateEmail(emailClass) {
    var email = $("." + emailClass).val();

    $.post("Includes/Handlers/ajax/updateEmail.php", { email: email, username: userLoggedIn }, function(response) {
        $("." + emailClass).nextAll(".message").text(response);
    });
}

function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("Includes/Handlers/ajax/updatePassword.php",
         {  oldPassword: oldPassword, 
            newPassword1: newPassword1,
            newPassword2: newPassword2,
            username: userLoggedIn 
        },
        function(response) {
            $("." + oldPasswordClass).nextAll(".message").text(response);
    });
}

// DYNAMIC LOADING FUNCTION
function openPage(url) {
    // If timer is set and navigating to another page, clear the timer
    if(timer != null) {
        clearTimeout(timer);
    }

    if(url.indexOf("?") == -1) {
        // if url doesnt have ? means first parameter
        url = url + "?";
    }

    // replaces special characters like space to %20 in url
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);

    $("#mainContent").load(encodedUrl);
    $('body').scrollTop(0);
    // thanks to stackoverflow
    // this writes the url into the browsers address bar as if the user changed the page
    history.pushState(null, null, url);
}

// Shows options menu in a position relative to the clicked button
function showOptionsMenu(button) {
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    // Get distance between top of window and top of page
    var scrollTop = $(window).scrollTop();
    // Get distance between top of page and button
    var elementOffset = $(button).offset().top;
    // Calculate position of menu
    var top = elementOffset - scrollTop;
    // Get left position of button
    var left = $(button).position().left;

    // Get songId of the clicked on song
    var songId = $(button).prevAll(".songId").val();
    // Finds the hidden input of the optionsMenu and gives it the id
    menu.find(".songId").val(songId);

    // Apply css to menu
    menu.css({
        "top": top + "px",
        "left": left - menuWidth + "px",
        "display": "inline"
    });
}

// Hides options menu if it is displaying
function hideOptionsMenu() {
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function removeFromPlaylist(button, playlistId) {
    // Get songId of the clicked on song
    var songId = $(button).prevAll(".songId").val();

    $.post("Includes/Handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId }, function(err) {
        if(err != "") {
            console.log(err);
            return;
        }

        // Reload page again async.
        openPage("playlist.php?id=" + playlistId);
    });
}

function createPlaylist() {
    var playlistName = prompt("Please enter the name of your playlist");
    if(playlistName != null) {
        $.post("Includes/Handlers/ajax/createPlaylist.php", { name: playlistName, username: userLoggedIn }, function(err) {
            if(err != "") {
                console.log(err);
                return;
            }

            // Reload page again async.
            openPage("yourMusic.php");
        });
    }
}

function deletePlaylist(playlistId) {
    var conf = confirm("Are you sure you want to delete this playlist?");
    if(conf) {
        $.post("Includes/Handlers/ajax/deletePlaylist.php", { playlistId: playlistId }, function(err) {
            if(err != "") {
                console.log(err);
                return;
            }

            // Reload page again async.
            openPage("yourMusic.php");
        });
    }
}

function deleteUser(userId) {
    var conf = confirm("Are you sure you want to delete this user?");
    if(conf) {
        $.post("Includes/Handlers/ajax/deleteUser.php", { userId: userId }, function(err) {
            if(err != "") {
                console.log(err);
                return;
            }

            // Reload page again async.
            openPage("settings.php");
        });
    }
}

function deleteSong(songId) {
    var conf = confirm("Are you sure you want to delete this song?");
    if(conf) {
        $.post("Includes/Handlers/ajax/deleteSong.php", { songId: songId }, function(err) {
            if(err != "") {
                console.log(err);
                return;
            }

            // Reload page again async.
            openPage("settings.php");
        });
    }
}

// Plays first song in artist page
function playArtistFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

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

    // Event listener for duration at the start of the song
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