<?php
session_start();

$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

if (isset($_SESSION["login"]) === FALSE) {
    $likeStatus = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents("php://input");
    $jsonData = json_decode($postData, true);

    $hikeName = $jsonData['hikeName'];
    $email = $_SESSION['email'];

    // Fetch nameID
    $query = "SELECT nameID FROM names WHERE name='$hikeName'";
    $result = $mysql->query($query);
    $row = $result->fetch_assoc();
    $nameID = isset($row['nameID']) ? $row['nameID'] : null;

    // Fetch hikeID
    $query = "SELECT hikeID FROM mainHikes WHERE nameID='$nameID'";
    $result = $mysql->query($query);
    $row = $result->fetch_assoc();
    $hikeID = isset($row['hikeID']) ? $row['hikeID'] : null;

    // Fetch userID
    $query = "SELECT userID FROM users WHERE userName='$email'";
    $result = $mysql->query($query);
    $row = $result->fetch_assoc();
    $userID = isset($row['userID']) ? $row['userID'] : null;

    // Check if the hike is a favorite for the current user
    $checkQuery = "SELECT COUNT(*) as count FROM favorites WHERE userID='$userID' AND hikeID='$hikeID'";
    $checkResult = $mysql->query($checkQuery);
    $checkRow = $checkResult->fetch_assoc();

    if ($checkRow['count'] == 0) {
        $likeStatus = 0;
    } else {
        $likeStatus = 1;
    }
}
echo json_encode(array('likeStatus' => $likeStatus));
?>

