<?php include("Includes/header.php"); ?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

        while ($row = mysqli_fetch_array($albumQuery)) {
            echo    "<div class='gridViewItem'>
                        <img src='" . $row['artworkPath'] . "'>
                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                    </div>";
        }
    ?>
</div>

<?php include("Includes/footer.php"); ?>