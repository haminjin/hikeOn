<?php
// Start the session
session_start();

$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION["login"]) === true) {
    // User is logged in
    $username = $_SESSION['email'];

    $query = "SELECT bgPicURL, profPicURL FROM user_profile WHERE userName = '$username'";
    $result = $mysql->query($query);

    if ($result === false) {
        die("Error in query: " . $mysql->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $bgPicURL = $row['bgPicURL'];
        $profPicURL = $row['profPicURL'];

        $_SESSION['bgPicURL'] = '../public/uploads/' . $row['bgPicURL'];
        $_SESSION['profPicURL'] = '../public/uploads/' . $row['profPicURL'];

    }

    $result->close();
} else {
    echo "User is not logged in";
}
$mysql->close();
?>
