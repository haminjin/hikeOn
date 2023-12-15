<?php
session_start();
$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

$email = $_SESSION['email'];

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the JSON data from the request
    $postData = file_get_contents("php://input");

    // Decode JSON data
    $jsonData = json_decode($postData, true);

    // Extract values from JSON
    $hikeName = $jsonData['hikeName'];
    $likeStatus = $jsonData['likeStatus'];

    // Output values as JSON
    echo json_encode(array(
        'hikeName' => $hikeName,
        'likeStatus' => (int)$likeStatus
    ));

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

    if($likeStatus == 1) {
        // Check if the entry already exists before inserting
        $checkQuery = "SELECT COUNT(*) as count FROM favorites WHERE userID='$userID' AND hikeID='$hikeID'";
        $checkResult = $mysql->query($checkQuery);
        $checkRow = $checkResult->fetch_assoc();

        if ($checkRow['count'] == 0) {
            // Entry does not exist, insert it
            if ($userID !== null && $hikeID !== null) {
                $insertQuery = "INSERT INTO favorites (hikeID,userID) VALUES ('$hikeID','$userID')";
                $mysql->query($insertQuery);
            }
        }
    } else if($likeStatus == 0) {

        // Fetch favoriteID
        $query = "SELECT favoriteID FROM favorites WHERE userID='$userID' AND hikeID='$hikeID'";
        $result = $mysql->query($query);
        $row = $result->fetch_assoc();
        $favoriteID = isset($row['favoriteID']) ? $row['favoriteID'] : null;

        if ($favoriteID !== null) {
            $deleteQuery = "DELETE FROM favorites WHERE favoriteID='$favoriteID'";
            $mysql->query($deleteQuery);
        }
    }
}
?>
