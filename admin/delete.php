<?php
$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}


$message = '';
$hikeID = isset($_GET['id']) ? $_GET['id'] : null;

if(!$hikeID) {
    $message = 'Error: No ID provided for deletion.';
} elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
    // A post request means the confirmation form was submitted
    if(isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
        // Prepare a delete statement
        $sql = "DELETE FROM mainView WHERE hikeID = ?";
        
        if($result = $mysql->prepare($sql)) {
            $result->bind_param("i", $hikeID);
            
            if($result->execute()) {
                // redirect to admin main page
                header("Location: index.php?message=Hike+deleted+successfully");
                exit();
            } else {
                $message = "Error: " . $result->error;
            }
            $result->close();
        } else {
            $message = "Error: " . $mysql->error;
        }
    } elseif(isset($_POST['confirm']) && $_POST['confirm'] == 'no') {
        // User decided not to delete
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Hike Confirmation</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
        <link rel="stylesheet" href=../css/typography.css" type="text/css">
        <link rel="stylesheet" href="../css/colors.css" type="text/css">
        <link rel="stylesheet" href="../admin/admin.module.css" type="text/css">
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <a href="index.php"><img src="public/assets/icons/green logo.png"></a>
        </div>
        <div class="nav-items">
            <!--<text class="body bold"><a href="pages/map-page.php">Map</a></text>-->
            <text class="body bold"><a href="pages/groupPage.php">Groups</a></text>
            <text class="body bold"><a href="pages/login.php">Log-in</a></text>
            <text class="body bold"><a href="pages/profilepage.php">Your Profile</a></text>
            <!-- login/profile button to be changed to dynamic when log in flow is complete -->
        </div>
    </div>
    <h1>Delete Hike</h1>
    <?php if($message): ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <p>Are you sure you want to delete this hike?</p>
        <form action="delete.php?id=<?php echo $hikeID; ?>" method="post">
            <input type="hidden" name="hikeID" value="<?php echo $hikeID; ?>">
            <input type="submit" name="confirm" value="yes">
            <input type="submit" name="confirm" value="no">
        </form>
    <?php endif; ?>
    <div class="footer">
            <img class="footer-logo" src="public/assets/icons/logotype bottom.png">
            <div class="footer-links">
                <a href="../pages/TeamPage.php">Team</a>
                <a href="../pages/faq.php">FAQ</a>
            </div>
     </div>
</body>
</html>
