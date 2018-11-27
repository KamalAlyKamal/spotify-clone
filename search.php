<?php
    include("Includes/includedFiles.php");

    if(isset($_GET['query'])) {
        // To decode URL
        // For example: if query is: kamal aly then in the url will be kamal%20aly
        // urldecode output = kamal aly
        $query = urldecode($_GET['query']);
    }
    else {
        $query = "";
    }
?>

<div class="searchContainer">
    <h4>Search for a song, artist, album, or a playlist</h4>
    <input type="text" class="searchInput" value="<?php echo $query; ?>" placeholder="Search...">
</div>