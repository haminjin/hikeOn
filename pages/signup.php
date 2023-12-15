<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../pages/login.module.css">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/typography.css" type="text/css">
    <link rel="stylesheet" href="../css/colors.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>
<?php include "logged-in.php" ?>
<?php include "../pages/nav.php" ?>
<div class="login-container">
    <h2>Sign Up</h2>
    <?php
    $mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve all user profile information
        $email = $_POST['email'];
        $password = $_POST['password'];
        $fullName = $_POST['full_name'];
        $major = $_POST['major'];
        $academicYearID = $_POST['academic_year'];
        $genderID = $_POST['gender'];

        if (strpos($email, "@usc.edu") === false) {
            echo "<p>Only USC email addresses are allowed.</p>";
        } else {
            // Insert data into reference tables and get the generated IDs
            $fullNameID = insertAndGetID($mysql, "fullNames", "fullName", $fullName);

            $query = "INSERT INTO users (userName, userPsswd, fullNameId, major, yearID, genderID) 
                      VALUES ('$email', '$password', '$fullNameID', '$major', '$academicYearID', '$genderID')";

            if ($mysql->query($query) === TRUE) {
                echo "User created successfully!";
            } else {
                echo "Error: " . $query . "<br>" . $mysql->error;
            }
        }
    }

    $mysql->close();

    // Function to insert data into reference tables and get the generated ID
    function insertAndGetId($mysqli, $table, $columnName, $value)
    {
        $insertQuery = "INSERT INTO $table ($columnName) VALUES ('$value')";
        $mysqli->query($insertQuery);
        return $mysqli->insert_id;
    }
    ?>

    <div class="logo-container">
        <img src="../public/assets/icons/green logo.png" alt="Logo">
    </div>
    <form method="post" action="signup.php" enctype="multipart/form-data">
        <label for="email">Email:</label>
        <input type="text" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" required>
        <br>
        <label for="major">Major:</label>
        <input type="text" name="major" required>
        <br>
        <label for="academic_year">Academic Year:</label>
        <select name="academic_year">
            <option value="1">Freshman</option>
            <option value="2">Sophomore</option>
            <option value="3">Junior</option>
            <option value="4">Senior</option>
            <option value="5">Graduate</option>
            <option value="6">Professor</option>
        </select>
        <br>
        <label for="gender">Gender:</label>
        <select name="gender">
            <option value="1">Male</option>
            <option value="2">Female</option>
            <option value="3">Non-binary</option>
        </select>
        <br>
        <label for="backgroundPicture">Upload Background Picture: </label>
        <input type="file" id="backgroundPicture" name="backgroundPicture" accept="image/*">
        <br>
        <label for="profilePicture">Upload Profile Picture: </label>
        <input type="file" id="profilePicture" name="profilePicture" accept="image/*">
        <br>
        <input type="submit" value="Sign Up">
    </form>
</div>

        <?php include "../pages/footer.php"?>
</body>
</html>
