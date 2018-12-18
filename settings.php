<?php
    include("Includes/includedFiles.php");
?>

<div class="entityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getName(); ?></h1>
        </div>
    </div>

    <div class="buttonItems">
        <button class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
        <button class="button" onclick="logout()">LOGOUT</button>
    </div>

    <?php 
        if($userLoggedIn->isAdmin()) {
            // USERS
            $query = mysqli_query($con, "SELECT id,username,email,admin FROM users");
            echo "<h2>Users</h2>";
            echo    "<div class='table100 ver3 m-b-110'>";
            echo    "<div class='table100-head'>
                        <table>
                            <thead>
                                <tr class='row100 head'>
                                    <th class='cell100 column1'>ID</th>
                                    <th class='cell100 column2'>Username</th>
                                    <th class='cell100 column3'>Email</th>
                                    <th class='cell100 column4'>Admin</th>
                                    <th class='cell100 column5'>Remove</th>
                                </tr>
                            </thead>
                        </table>
                    </div>";
            echo    "<div class='table100-body js-pscroll'>
                        <table>
                            <tbody>";
            while($row = mysqli_fetch_array($query)) {
                if ($row['username'] == $userLoggedIn->getUsername()) {
                    continue;
                }
                $isAdmin = $row['admin'] ? "Yes" : "No";
                echo    "<tr class='row100 body'>
                            <td class='cell100 column1'>" . $row['id'] . "</td>
                            <td class='cell100 column2'>" . $row['username'] . "</td>
                            <td class='cell100 column3'>" . $row['email'] . "</td>
                            <td class='cell100 column4'>" . $isAdmin . "</td>
                            <td class='cell100 column5'>
                                <img src='assets/images/Icons/remove.png' alt='Remove' class='removeIcon pointer' onclick='deleteUser(\"".$row['id']."\")'>
                            </td>
                        </tr>";
            }
            echo            "</tbody>
                        </table>
                    </div>";
            echo "</div>";

            // SONGS
            $query = mysqli_query($con, "SELECT id,title,plays FROM songs");
            echo "<h2>Songs</h2>";
            echo    "<div class='table100 ver3 m-b-110'>";
            echo    "<div class='table100-head'>
                        <table>
                            <thead>
                                <tr class='row100 head'>
                                    <th class='cell100 column1'>ID</th>
                                    <th class='cell100 column2'>Title</th>
                                    <th class='cell100 column3'># Plays</th>
                                    <th class='cell100 column4'>Remove</th>
                                </tr>
                            </thead>
                        </table>
                    </div>";
            echo    "<div class='table100-body js-pscroll'>
                        <table>
                            <tbody>";
            while($row = mysqli_fetch_array($query)) {
                echo    "<tr class='row100 body'>
                            <td class='cell100 column1'>" . $row['id'] . "</td>
                            <td class='cell100 column2'>" . $row['title'] . "</td>
                            <td class='cell100 column3'>" . $row['plays'] . "</td>
                            <td class='cell100 column4'>
                                <img src='assets/images/Icons/remove.png' alt='Remove' class='removeIcon pointer' onclick='deleteSong(\"".$row['id']."\")'>
                            </td>
                        </tr>";
            }
            echo            "</tbody>
                        </table>
                    </div>";
            echo "</div>";
        }
    ?>
</div>

<script src="assets/js/perfect-scrollbar.min.js"></script>
<script>
    $('.js-pscroll').each(function(){
        var ps = new PerfectScrollbar(this);

        $(window).on('resize', function(){
            ps.update();
        })
    });
</script>