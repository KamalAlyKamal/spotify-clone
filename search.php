<?php
    include("Includes/includedFiles.php");

    if(isset($_GET['query'])) {
        // To decode URL
        // For example: if query is: ahmed osman then in the url will be ahmed%20osman
        // urldecode output = ahmed osman
        $query = urldecode($_GET['query']);
    }
    else {
        $query = "";
    }
?>

<div class="searchContainer">
    <h4>Search for a song, artist, album, or a playlist</h4>
    <input type="text" class="searchInput" value="<?php echo $query; ?>" placeholder="Search..." onfocus="this.value = this.value">
</div>

<script>
    // Refocus input on page reload
    $(".searchInput").focus();
    var temp = $(".searchInput").val();
    $(".searchInput").val("");
    $(".searchInput").val(temp);

    // IIFE to reload page with new query after 2 seconds when stopped typing
    $(function() {
        $(".searchInput").keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                var val = $(".searchInput").val();
                openPage("search.php?query=" + val);
            }, 2000);
        });
    });
</script>

<?php
    // If empty query, stop loading the rest of the page
    if($query == "") {
        exit();
    }
?>

<div class="tracklistContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="tracklist">
        <?php
            $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$query%' LIMIT 10");

            if(mysqli_num_rows($songsQuery) == 0) {
                echo "<p class='noResults'>Oops, No songs found matching: " . $query . "</p>";
            }

            $songIdArray = array();

            $count = 1;
            while($row = mysqli_fetch_array($songsQuery)) {
                // ONLY GET TOP 5 SONGS FOR THIS ARTIST
                // if($count > 15) {
                //     break;
                // }
                
                array_push($songIdArray, $row['id']);

                $albumSong = new Song($con, $row['id']);
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
                
                $count++;
            }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<div class="artistsContainer borderBottom">
    <h2>ARTISTS</h2>

    <?php
        $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$query%' LIMIT 10");
        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<p class='noResults'>Oops, No artists found matching: " . $query . "</p>";
        }

        while($row = mysqli_fetch_array($artistsQuery)) {
            $artistRow = new Artist($con, $row['id']);

            echo    "<div class='artistRow'>
                        <div class='artistRowName'>
                            <span class='pointer' onclick='openPage(\"artist.php?id=" . $artistRow->getId() . "\")'>
                                "
                                . $artistRow->getName() .
                                "
                            </span>
                        </div>
                    </div>";
        }
    ?>
</div>

<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$query%' LIMIT 10");

        if(mysqli_num_rows($albumQuery) == 0) {
            echo "<p class='noResults'>Oops, No albums found matching: " . $query . "</p>";
        }

        while ($row = mysqli_fetch_array($albumQuery)) {
            echo    "<div class='gridViewItem'>
                        <span onclick='openPage(\"album.php?id=" . $row['id'] . "\");'>
                            <img src='" . $row['artworkPath'] . "'>
                            <div class='gridViewInfo'>"
                                . $row['title'] .
                            "</div>
                        </span>
                    </div>";
        }
    ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>