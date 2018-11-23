<?php 
    include("Includes/header.php"); 

    if(isset($_GET['id'])) {
        $albumId = $_GET['id'];
    }
    else {
        header("Location: index.php");
    }

    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id = '$albumId'");
    $album = mysqli_fetch_array($albumQuery);

    $artist = new Artist($con, $album['artist']);

    echo $album['title'];
    echo $artist->getName();
?>


<?php include("Includes/footer.php"); ?>