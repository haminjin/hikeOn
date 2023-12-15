<?php
include ("logged-in.php");
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Groups</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/typography.css" type="text/css">
    <link rel="stylesheet" href="../css/colors.css" type="text/css">
    <link rel="stylesheet" href="groupPage.module.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">


</head>

<?php

$host = "webdev.iyaserver.com";
$userid = "haminjin_guest";
$userpw = "DevIIHikeOn123";
$db = "haminjin_hikeOn";

// Establish a connection
$mysqli = new mysqli($host, $userid, $userpw, $db);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Initialize an error message variable
$error_message = '';

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $groupName = $_POST['groupName'];

    $query = "SELECT * FROM mainView WHERE name = '" . $_POST['hikeLocation'] . "'" ;

    $results = $mysqli->query($query);
    while($currentrow = $results->fetch_assoc()) {
        $hikeID = $currentrow['hikeID'];
    }

    $location = $hikeID;
    $date = $_POST['date'];
    $time = $_POST['time'];
    $endtime = $_POST['time1'];

    $query = "SELECT * FROM groupLvls WHERE groupLvl = '" . $_POST['difficultyLevel'] . "'" ;

    $results = $mysqli->query($query);
    while($currentrow = $results->fetch_assoc()) {
        $diffID = $currentrow['groupLvlID'];
    }

    $difficulty = $diffID;
    $description = $_POST['userInput'];

    $query = "SELECT * FROM users WHERE userName = '" . $_SESSION["email"] . "'" ;

    $results = $mysqli->query($query);
    while($currentrow = $results->fetch_assoc()) {
        $userID = $currentrow['userID'];
    }

    $username = $userID;

// Combine date and time into a single string
    $startDateTimeString = $date . ' ' . $time;
    $endDateTimeString = $date . ' ' . $endtime;

// Create a DateTime object
    $DateTime = new DateTime($startDateTimeString);
    $EndDateTime = new DateTime($endDateTimeString);

// Format the DateTime object to the format you want to store in the database
    $DateTimeFormatted = $DateTime->format('Y-m-d H:i:s');
    $EndDateTimeFormatted = $DateTime->format('Y-m-d H:i:s');

    echo 'Combined Date and Time: ' . $startDateTimeString;

    // Insert data into reference tables and get the generated IDs
    $descriptionID = insertAndGetID($mysqli, "groupDescriptions", "groupDescription", $description);

    // Insert data into the database
    $query = "INSERT INTO groups (userID, hikeID, groupName, startDateTime, endDateTime, groupLvlID, groupDescriptionID) VALUES ('$username','$location', '$groupName',' $DateTimeFormatted',' $EndDateTimeFormatted','$difficulty','$descriptionID')";

    if ($mysqli->query($query) === TRUE) {
        echo "New group created successfully";
    } else {
        $error_message = "Error: " . $query . "<br>" . $mysqli->error;
    }
}

// Function to insert data into reference tables and get the generated ID
function insertAndGetId($mysqli, $table, $columnName, $value)
{
    $insertQuery = "INSERT INTO $table ($columnName) VALUES ('$value')";
    $mysqli->query($insertQuery);
    return $mysqli->insert_id;
}
?>


<!-- Display error message if there is any -->
<?php if (!empty($error_message)) : ?>
    <div style="color: red;"><?php echo $error_message; ?></div>
<?php endif; ?>

<?php include "../pages/nav.php" ?>

<div class="headline">
    <text class="title">Groups</text>
    <text class="copy1">Connect with other outdoor Trojans!</text>
</div>

<div class="featuredbox">
    <div class="featured">Featured</div>
    <div class="container1">
        <?php

        if($_SESSION["login"] == true){
            echo '<div class="CreateGroupButton" onclick="toggleGroupPopup()"> Create A Group </div>';
        }
        else{
            echo '<div class="CreateGroupButton"> Login to Create a Group </div>';
        }

        ?>
    </div>
</div>

<div class="break"></div>

<div>
    <div class="category">Casual</div>

    <?php

    $query = "SELECT * FROM hike_groups2 WHERE groupLvl = 'Casual'" ;

    $results = $mysqli->query($query);
    while($currentrow = $results->fetch_assoc()) {
        echo '<div class="groupcard">
        <div class="hikeTitle">'. $currentrow["groupName"] . ' at ' . $currentrow["name"] .'</div>
        <div class="hikeDistance">hosted by '. $currentrow["userName"] .', at '. $currentrow["startDateTime"] .'</div>
        <br>
        <div class="hikeDistance">'. $currentrow["groupDescription"] .'</div>
    </div>';
    }



    ?>


    <div class="category">Amateur</div>

    <?php

    $query = "SELECT * FROM hike_groups2 WHERE groupLvl = 'Amateur'" ;

    $results = $mysqli->query($query);
    while($currentrow = $results->fetch_assoc()) {
        echo '<div class="groupcard">
        <div class="hikeTitle">'. $currentrow["groupName"] . ' at ' . $currentrow["name"] .'</div>
        <div class="hikeDistance">hosted by '. $currentrow["userName"] .', at '. $currentrow["startDateTime"] .'</div>
        <br>
        <div class="hikeDistance">'. $currentrow["groupDescription"] .'</div>
    </div>';
    }



    ?>


    <div class="category">Hardcore</div>

    <?php

    $query = "SELECT * FROM hike_groups2 WHERE groupLvl = 'Hardcore'" ;

    $results = $mysqli->query($query);
    while($currentrow = $results->fetch_assoc()) {
        echo '<div class="groupcard">
        <div class="hikeTitle">'. $currentrow["groupName"] . ' at ' . $currentrow["name"] .'</div>
        <div class="hikeDistance">hosted by '. $currentrow["userName"] .', at '. $currentrow["startDateTime"] .'</div>
        <br>
        <div class="hikeDistance">'. $currentrow["groupDescription"] .'</div>
    </div>';
    }



    ?>


</div>

<div class="GroupPopup" id="groupPopup">
    <img src="x.png" class="x" id="closeButton">
    <p class="Popupheading">Create a Group</p>
    <div class="formContainer">
        <form method="post" action="groupPage.php">
            <br>
            <br>
            Group Name: <input type="text" name="groupName" required>
            <br>
            <br>
            Hike Location: <select name="hikeLocation">
                <?php
                $sql = "SELECT * FROM mainView";
                $results = $mysqli->query($sql);
                while($currentrow = $results->fetch_assoc()) {
                    echo "<option>" . $currentrow['name'] . "</option>";
                }
                ?>
            </select>
            <br>
            <br>
            <label for="selectedDate">Select a Date:</label>
            <input type="date" id="selectedDate" name="date" required>
            <br>
            <br>
            Start Time: <input type="time" id="selectedTime" name="time" required>
            <br>
            <br>
            End Time: <input type="time" id="selectedTime" name="time1" required>
            <br>
            <br>
            Group Difficulty: <select name="difficultyLevel">
                <?php
                $sql = "SELECT * FROM groupLvls";
                $results = $mysqli->query($sql);
                while($currentrow = $results->fetch_assoc()) {
                    echo "<option>" . $currentrow['groupLvl'] . "</option>";
                }
                ?>
            </select>
            <br>
            <br>
            Please add a description or anything information you would want potential members to know:
            <br>
            <br>
            <textarea id="hikeDescription" name="userInput" rows="4" cols="40" placeholder="Type here..."></textarea>
            <br>
            <br>
            <input type="submit">
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the document to be fully loaded

        // Get references to the x div and GroupPopup div
        var closeButton = document.getElementById("closeButton");
        var groupPopup = document.getElementById("groupPopup");

        // Add a click event listener to the closeButton
        closeButton.addEventListener("click", function() {
            // Toggle the visibility of the groupPopup
            if (groupPopup.style.display === 'none' || groupPopup.style.display === '') {
                groupPopup.style.display = 'block';
            } else {
                groupPopup.style.display = 'none';
            }
        });
    });

    function toggleGroupPopup() {
        var popup = document.getElementById('groupPopup');
        if (popup.style.display === 'none' || popup.style.display === '') {
            popup.style.display = 'block';
        } else {
            popup.style.display = 'none';
        }
    }
</script>

    <br>
    <br>
<script>
    // Function to open the filtersPopUp
    function openFiltersPopUp() {
        var filtersPopUp = document.getElementById('filtersPopUp');
        filtersPopUp.style.display = 'block';
    }

    // Function to close the filtersPopUp
    function closeFiltersPopUp() {
        var filtersPopUp = document.getElementById('filtersPopUp');
        filtersPopUp.style.display = 'none';
    }

    // Add a click event listener to open the filtersPopUp
    document.getElementById('openFiltersButton').addEventListener('click', openFiltersPopUp);

    // Add a click event listener to close the filtersPopUp
    document.getElementById('closeFiltersButton').addEventListener('click', closeFiltersPopUp);
</script>

<?php include "../pages/footer.php"?>

</body>
</html>
