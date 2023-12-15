<?php
session_start();
$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

$email = $_SESSION['email'];

//Logic flow
// create function to handle file uploads
function handleFileUpload($fileInputName, $uploadDirectory) {
    if (empty($_FILES[$fileInputName]["name"])) {
        return false;
    }

    // File was uploaded
    $file = $_FILES[$fileInputName];

    // Check file size
    $maxFileSize = 5 * 1024 * 1024; // 5 MB (you can adjust this value)
    if ($file['size'] > $maxFileSize) {
        echo "<script>alert('Error: File size exceeds the maximum limit.');</script>";
        return false;
    }

    // Check file type
    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif'); // Add more if needed
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedFileTypes)) {
        echo "<script>alert('Error: Invalid file type.');</script>";
        return false;
    }

//    echo "Received a file in the form object '$fileInputName'.<br>";
//    echo "File was named <strong>{$file['name']}</strong><br>";
//    echo "File was saved as a temp file at <strong>{$file['name']}</strong><br>";

    $destination = $uploadDirectory . '/' . $file['name'];

    // Move the uploaded file to the destination
    if (move_uploaded_file($file['tmp_name'], $destination)) {
//        echo "File saved successfully at <strong>{$destination}</strong><br>";
        return $destination;
    } else {
//        echo "Failed to save the file. Error: " . $_FILES[$fileInputName]['error'] . "<br>";
        return false;
    }

}


// create function to update bgPicsTable
function updateBackgroundPicturesTable($mysql, $fileName) {
    $email = $_SESSION['email'];
    $newBgPicID = insertAndGetId($mysql, 'bgPics', 'bgPicURL', $fileName);

    $query = "UPDATE users SET bgPicID = '$newBgPicID' WHERE userName = '$email'";
    // Execute the query
    $mysql->query($query);
    $_SESSION['bgPicURL'] = '../public/uploads/' . $fileName;
}

// create function to update profPicsTable
function updateProfilePicturesTable($mysql, $fileName) {
    $email = $_SESSION['email'];
    $newProfPicID = insertAndGetId($mysql, 'profPics', 'profPicURL', $fileName);

    $query = "UPDATE users SET profPicID = '$newProfPicID' WHERE userName = '$email'";
    // Execute the query
    $mysql->query($query);
    $_SESSION['profPicURL'] = '../public/uploads/' . $fileName;
}

// if form with id="backgroundPicture" !== null && !== "";
// initiate handle file upload from that id & update bgPicsTable
// if form with id="profilePicture" !== null && !== "";
// initiate handle file upload from that id & update profPicsTable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = getColumnValue($mysql, 'users', 'userID');

    // Handle Profile Picture Upload
    $profilePicPath = handleFileUpload('profilePicture', '../public/uploads');
    if ($profilePicPath) {
        updateProfilePicturesTable($mysql,  $_FILES['profilePicture']['name']);
    }

    // Handle Background Picture Upload
    $bgPicPath = handleFileUpload('backgroundPicture', '../public/uploads');
    if ($bgPicPath) {
        updateBackgroundPicturesTable($mysql,  $_FILES['profilePicture']['name']);
    }
}
?>
