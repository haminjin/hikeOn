<?php
$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

$hikeID = isset($_GET['id']) ? $_GET['id'] : '';
$data = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $length = $_POST['length'];
    $duration = $_POST['duration'];
    $numOfViews = $_POST['numOfViews'];
    $difficulty = $_POST['difficulty'];
    $comments = $_POST['comments'];
    $terrain = $_POST['terrain'];
    $imageURL = $_POST['imageURL'];

    // Prepare an update statement
    $sql = "UPDATE mainView SET name = ?, latitude = ?, longitude = ?, length = ?, duration = ?, numOfViews = ?, difficulty = ?, comments = ?, terrain = ?, imageURL = ? WHERE hikeID = ?";
    
    if($result = $mysql->prepare($sql)) {
        $result->bind_param("sddiisssssi", $name, $latitude, $longitude, $length, $duration, $numOfViews, $difficulty, $comments, $terrain, $imageURL, $hikeID);
        
        if($result->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $result->error;
        }
        $result->close();
    } else {
        echo "Error: " . $mysql->error;
    }
} else {
    // Prepare a select statement to get the existing data
    $sql = "SELECT * FROM mainView WHERE hikeID = ?";
    
    if($result = $mysql->prepare($sql)) {
        $result->bind_param("i", $hikeID);
        
        if($result->execute()) {
            $result = $result->get_result();
            $data = $result->fetch_assoc();
        } else {
            echo "Error: " . $result->error;
        }
        $result->close();
    } else {
        echo "Error: " . $mysql->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Hike</title>
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
    <h1>Edit Hike</h1>
    <form action="edit.php?id=<?php echo $hikeID; ?>" method="post">
        Name: <input type="text" name="name" value="<?php echo $data['name']; ?>"><br>
        Latitude: <input type="text" name="latitude" value="<?php echo $data['latitude']; ?>"><br>
        Longitude: <input type="text" name="longitude" value="<?php echo $data['longitude']; ?>"><br>
        Length: <input type="number" name="length" value="<?php echo $data['length']; ?>"><br>
        Duration: <input type="number" name="duration" value="<?php echo $data['duration']; ?>"><br>
        Number of Views: <input type="number" name="numOfViews" value="<?php echo $data['numOfViews']; ?>"><br>
        Difficulty: <input type="text" name="difficulty" value="<?php echo $data['difficulty']; ?>"><br>
        Comments: <textarea name="comments"><?php echo $data['comments']; ?></textarea><br>
        Terrain: <input type="text" name="terrain" value="<?php echo $data['terrain']; ?>"><br>
        Image URL: <input type="text" name="imageURL" value="<?php echo $data['imageURL']; ?>"><br>
        <input type="submit" value="Update Hike">
    </form>
    <div class="footer">
            <img class="footer-logo" src="public/assets/icons/logotype bottom.png">
            <div class="footer-links">
                <a href="../pages/TeamPage.php">Team</a>
                <a href="../pages/faq.php">FAQ</a>
            </div>
     </div>
</body>
</html>