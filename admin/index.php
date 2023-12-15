<?php

$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

// Fetch all hikes from the mainView table
$result = $mysql->query("SELECT * FROM mainView");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/styles.css" type="text/css">
        <link rel="stylesheet" href=../css/typography.css" type="text/css">
        <link rel="stylesheet" href="../css/colors.css" type="text/css">
        <link rel="stylesheet" href="../admin/admin.module.css" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="index.php"><img src="../public/assets/icons/green logo.png"></a>
        </div>
        <div class="nav-items">
            <!--<text class="body bold"><a href="pages/map-page.php">Map</a></text>-->
            <text class="body bold"><a href=../pages/groupPage.php">Groups</a></text>
            <text class="body bold"><a href="../pages/login.php">Log-in</a></text>
            <text class="body bold"><a href="../pages/profilepage.php">Your Profile</a></text>
            <!-- login/profile button to be changed to dynamic when log in flow is complete -->
        </div>
    </div>
    <div class="admin">
        <div class="admin-nav">
            <a href="add.php">Add Hike</a>
            <a href="edit.php">Edit Hike</a>
            <a href="delete.php">Delete Hike</a>
        </div>

        <div id="admin-main">
            <h1>Admin Dashboard</h1>
            <h2>Hikes List</h2>
            <?php
            $sql = "SELECT * FROM mainView";
            $result = $mysql->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>Name</th><th>Actions</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["name"] . "</td>
                            <td>
                                <a href='edit.php?id=" . $row["hikeID"] . "'>Edit</a>
                                <a href='delete.php?id=" . $row["hikeID"] . "'>Delete</a>
                            </td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "No results found";
            }
            ?>
        </div>
        <div class="footer">
                <img class="footer-logo" src="public/assets/icons/logotype bottom.png">
                <div class="footer-links">
                    <a href="../pages/TeamPage.php">Team</a>
                    <a href="../pages/faq.php">FAQ</a>
                </div>
        </div>
    </div>
</body>
</html>

   