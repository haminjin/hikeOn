<?php
include 'logged-in.php';
include 'upload.php';
session_start();
$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

$email = $_SESSION['email'];
$bgPicURL = $_SESSION['bgPicURL'];
$profPicURL = $_SESSION['profPicURL'];

//For Displaying Settings Data
$query = "SELECT userName, fullName, major, year, gender FROM user_profile WHERE userName ='$email'";
$result = $mysql->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $major = $row['major'];
    $academic_year = $row['year'];
    $gender = $row['gender'];
    $fullName = $row['fullName'];
}

// Check if user is logged in
if(isset($_SESSION["login"]) === false) {
    // Send user to login page
    $path = '../pages/login.php';
} else {
    $path = '../pages/profilepage.php';
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/typography.css" type="text/css">
    <link rel="stylesheet" href="../css/colors.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <style>
        .background {
            padding-bottom:0;
        }
        .tabs {
            width: 100%;
            position: relative;
        }

        .tabs .tab-header {
            height: 4rem;
            display: flex;
            align-items: center;
        }
        .tabs .tab-header > div {
            width: calc(100% / 3);
            text-align: center;
            cursor: pointer;
            font-size: 1rem;
            text-transform: uppercase;
            outline: none;
        }
        .tabs .tab-header > div.active {
            font-weight: bold;
            color: #3E5D15;

        }
        .tabs .tab-indicator {
            position: absolute;
            width: calc(100%/3);
            height: .3rem;
            background: #3E5D15;
            left:0;
            border-radius: 1rem;
            transition:all 500ms ease-in-out;
        }

        .tabs .tab-body {
            position: relative;
            min-height:75%;
            padding: 2rem 1rem;
        }
        .tabs .tab-body > div {
            position: absolute;
            top: -200%;
            opacity:0;
            margin-top:1rem;
            transform:scale(0.9);
            transition: opacity 500ms ease-in-out 0ms,
            transform 500ms ease-in-out 0ms;
            width:100%;
        }
        .tabs .tab-body >div.active {
            top:0;
            opacity:1;
            transform:scale(1);
            margin-top:0;
        }
        .profilepage-body {
            width:100%;
            min-height: 50%;
        }
        /*reviews css*/
        .reviews-holder{
            padding-bottom:5rem;
            overflow: hidden;
        }
        .reviews-row{
            display: flex;
            align-items: flex-start;
            gap: 2.5rem;
            align-self: stretch;
        }
        .review{
            display: flex;
            padding: 1.5rem 2.5rem;
            align-items: flex-start;
            gap: 2.5rem;
            flex: 1 0 0;
            border-radius: 1.25rem;
            border: 1px solid #E5E5E5;
            background: #FFF;
        }
        .review-inner{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 1.25rem;
            align-self: stretch;
        }
        .reviewer{
            display: flex;
            align-items: center;
            flex-direction:row;
            gap: 0.5rem;
            flex: 1 0 0;
        }
        .stars{
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        #editProfile {
            display: inline-flex;
            padding: 1rem 1.5rem;
            align-items: center;
            gap: .25rem;
            border-radius: 2rem;
            border: 1px solid var(--ui-border, #E5E5E5);
            background: var(--ui-white, #FFF);
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.25);
        }

        #saved {
            max-height: 40rem;
            overflow-y: auto;
            padding: 1.25rem;
            box-shadow: inset 0 -0.625rem 0.625rem -0.5rem rgba(0, 0, 0, 0.25);

        }
        #myreviews {
            max-height: 40rem;
            overflow-y: auto;
            padding: 1.25rem;
            box-shadow: inset 0 -0.625rem 0.625rem -0.5rem rgba(0, 0, 0, 0.25);
        }
        #saved-cards {
            width: 35rem;
            margin: 0.625rem;
        }
        #editProfile:hover {
            background: #E5E5E5;
        }
        #overlay {
            position: fixed;
            display: none;
            width: 70%;
            min-height: 95%;
            background-color: white;
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.25);
            border-radius: 2rem;
            z-index: 2;
            cursor: pointer;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: auto;
        }

        form {
            padding-left:3rem;
            padding-right:3rem;
            padding-bottom:3rem;
        }


        @media only screen and (max-width: 480px) {
            .tabs .tab-header > div {
                font-size: 0.9rem;
            }

            .tabs .tab-indicator {
                width: calc(100% / 3);
            }

            .tabs .tab-body > div {
                padding: 2rem 1rem 1rem 1rem;
            }
        }

    </style>
</head>
<body>
<div class="background">
    <div class="nav">
        <div class="logo">
            <a href="../index.php"><img src="../public/assets/icons/green logo.png"></a>
        </div>
        <div class="nav-items">
            <text class="body bold"><a href="../pages/groupPage.php">Groups</a></text>
            <text class="body bold">
                <a href="<?php echo $path; ?>">
                    <img src="<?php echo $profPicURL;?>" style="width:3rem; aspect-ratio: 1/1; border-radius: 50%;" class="ppImg">
                </a>
            </text>
        </div>
    </div>
</div>

<!-- ACCOUNT NAME, PHOTO, BACKGROUND IMAGE -->
<!-- BACKGROUND IMAGE -->
<div class="background-image" style="text-align:center;display:flex;justify-content:center; align-items:center;">
    <img src="<?php echo $bgPicURL; ?>" style="width:70%;height:15rem;border-radius:2rem;" class=".ppImg">
</div>

<div class="profilepage" style="margin-left:15%; margin-right:15%;margin-top:-3%;">

    <!-- ACCOUNT NAME AND PHOTO -->
    <div class="account-header" style="padding-bottom:3rem;">
        <div style="text-align:center;">
            <img src="<?php echo $profPicURL;?>" style="width:6rem; aspect-ratio: 1/1; border-radius: 50%;" class="ppImg"><br><br><?php echo $fullName; ?>
        </div>
    </div>

    <!-- PROFILE PAGE BODY -->
    <div class="profilepage-body">

        <!-- TAB SLIDER SECTION -->
        <div class="tabs">

            <!-- TAB SLIDER HEADERS -->
            <div class="tab-header">
                <div class="active">
                    My Reviews
                </div>
                <div>
                    Saved
                </div>
                <div>
                    Settings
                </div>
            </div>

            <!-- SLIDER -->
            <div class="tab-indicator"></div>

            <!-- DYNAMIC BODY TEXT (FOR ALL TABS) -->
            <div class="tab-body">

                <!-- MY REVIEWS -->
                <div class="active" id="myreviews">

                    <div class="reviews-holder">
                        <h3>My Recent Reviews</h3>
                            <?php
                            $loginID = $_SESSION["email"];
                            $query = "SELECT * FROM users WHERE userName = '$loginID'";
                            $result = $mysql->query($query);
                            while($currentrow = $result->fetch_assoc()) {
                                $loginID = $currentrow["userID"];
                            }
                            $sql = "SELECT * FROM userReviews WHERE userID = $loginID";
                            $result = $mysql->query($sql);
                            if ($result->num_rows > 0) {
                                while($currentrow = $result->fetch_assoc()) {
                                        $currentUSER = $currentrow['userID'];
                                        $query = "SELECT * FROM users WHERE userID = $currentUSER";
                                        $result2 = $mysql->query($query);
                                        while($currentrow2 = $result2->fetch_assoc()) {
                                            $reviewUser = $currentrow2["userName"];

                                        $newEcho = '<br><div class="reviews-row">
            <div class="review">
                <div class="review-inner">
                    <div class="reviewer">
                        <div class="profile">
                            <a href="' . $path .'">
                                <img src="' . $profPicURL . '" style="width:3rem; aspect-ratio: 1/1; border-radius: 50%;" class="ppImg">
                            </a>
                        </div>
                        <div class="reviewer-info">
                            <text>' . $reviewUser . '</text>
                        </div>
                    ';

                                        if($currentrow["rating"] == 1){
                                            $newEcho .= '</div>
                            <text class="copy1">' . $currentrow["comments"] . '</text>
                            <div class="stars">
                                <img src="../public/assets/icons/star.svg" class="icon">
                            </div>
                        </div>
                    </div>
                </div>';
                                        }
                                        else if($currentrow["rating"] == 2){
                                            $newEcho .= '</div>
                            <text class="copy1">' . $currentrow["comments"] . '</text>
                            <div class="stars">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                            </div>
                        </div>
                    </div>
                </div>';
                                        }
                                        else if($currentrow["rating"] == 3){
                                            $newEcho .= '</div>
                            <text class="copy1">' . $currentrow["comments"] . '</text>
                            <div class="stars">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                            </div>
                        </div>
                    </div>
                </div>';
                                        }
                                        else if($currentrow["rating"] == 4){
                                            $newEcho .= '</div>
                            <text class="copy1">' . $currentrow["comments"] . '</text>
                            <div class="stars">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                            </div>
                        </div>
                    </div>
                </div>';
                                        }
                                        else if($currentrow["rating"] == 5){
                                            $newEcho .= '</div>
                            <text class="copy1">' . $currentrow["comments"] . '</text>
                            <div class="stars">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                                <img src="../public/assets/icons/star.svg" class="icon">
                            </div>
                        </div>
                    </div>
                </div>';
                                        }

                                        echo $newEcho;
                                    }

                                }
                            }
                            else{
                                echo "no reviews";
                            }
                            ?>

                                </div>
                </div>

                <!-- SAVED -->
                <div id="saved">
                    <h3>Your Saved Hikes</h3>
                    <p>
                        <?php
                        $sql_saved = "SELECT * FROM user_favoriteHikes WHERE userName = '$email'";
                        $result_saved = $mysql->query($sql_saved);

                        if($result_saved->num_rows > 0) {
                            while($currentrow = $result_saved->fetch_assoc()) {
                                echo '
                                        <div class="hike-individual" id="saved-cards">
                                            <div class="hike-thumbnail">
                                                <a href="pages/individual-hike.php"><img src="../public/assets/images/' . $currentrow["imageURL"] . '" class="hikeDisplayImg"></a>
                                            </div>
                                             <div class="hike-description">
                                                <div class="body hike-reviewer">' . $currentrow["lattitude"] . ' N, ' . $currentrow["longitude"] . ' W' . '</div>
                                                <div class="body">' . $currentrow["name"] . '</div>
                                                <div class="body">' . $currentrow["length"] . ' miles</div>
                                                <div class="body">' . $currentrow["duration"] . ' hr</div>
                                                <div class="hike-difficulty body" id="'. $currentrow["difficulty"] .'">
                                                    ' . $currentrow["difficulty"] . '
                                                </div>
                                            </div>
                                        </div>
                                    ';
                            }
                        } else {
                            echo "No saved hikes.";
                        }
                        ?>
                    </p>
                </div>


                <!-- SETTINGS -->
                <div id="settings">
                    <?php


                    //For Editing Settings
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Retrieve session email
                        $email = $_SESSION['email'];

                        // Retrieve updated user profile information but check if value is inputted
                        $newFullName = isset($_POST['full_name']) ? $_POST['full_name'] : null;
                        $newMajor = isset($_POST['major']) ? $_POST['major'] : null;
                        $newAcademicYearID = isset($_POST['academic_year']) ? $_POST['academic_year'] : null;
                        $newGenderID = isset($_POST['gender']) ? $_POST['gender'] : null;

                        $existingFullNameID = getFullNameId($mysql, $email);

                        // NOT NEEDED FOR THIS PAGE (Update the existing user profile)
                        // $fullNameID = insertAndGetID($mysql, "fullNames", "fullName", $newFullName);

                        //check if form values are empty or null
                        $userQuery = "UPDATE users SET";

                        if ($newMajor !== null && $newMajor !== "") {
                            $userQuery .= " major = '$newMajor',";
                        }

                        if ($newAcademicYearID !== null && $newAcademicYearID !== "") {
                            $userQuery .= " yearID = '$newAcademicYearID',";
                        }

                        if ($newGenderID !== null && $newGenderID !== "") {
                            $userQuery .= " genderID = '$newGenderID',";
                        }

                        $userQuery = rtrim($userQuery, ',');

                        $userQuery .= " WHERE userName = '$email'";

                        // Execute the 'users' query only if there are non-null values to update
                        if (strpos($userQuery, '=') !== false) {
                            if ($mysql->query($userQuery) === TRUE) {
                                echo "User profile updated successfully!";
                            } else {
                                echo "Error: " . $userQuery . "<br>" . $mysql->error;
                            }
                        }

                        // Check if the newFullName is not null and update the 'fullNames' table
                        if ($newFullName !== null && $newFullName !== "") {
                            $fullNameQuery = "UPDATE fullNames SET fullName = '$newFullName' WHERE fullNameID = '$existingFullNameID'";

                            // Execute the 'fullNames' query
                            if ($mysql->query($fullNameQuery) === FALSE) {
                                echo "Error: " . $fullNameQuery . "<br>" . $mysql->error;
                            }
                        }
                    }

                    // Function to insert data into reference tables and get the generated ID
                    function insertAndGetId($mysqli, $table, $columnName, $value)
                    {
                        $insertQuery = "INSERT INTO $table ($columnName) VALUES ('$value')";
                        $mysqli->query($insertQuery);
                        return $mysqli->insert_id;
                    }

                    // Function to get existing fullNameId for a user
                    function getFullNameId($mysql, $email)
                    {
                        $query = "SELECT fullNameId FROM users WHERE userName = '$email'";
                        $result = $mysql->query($query);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            return $row['fullNameId'];
                        }

                        return null;
                    }

                    //modified function getFullNameID to return values from database
                    function getColumnValue($mysql, $table, $column)
                    {
                        $email = $_SESSION['email'];
                        $query = "SELECT $column FROM $table WHERE userName = '$email'";
                        $result = $mysql->query($query);

                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            return $row[$column];
                        }

                        return null;
                    }

                    ?>
                    <h3>Profile</h3>
                    <p><hr></p>

                    <!-- NAME AND PROFILE PICTURE -->
                    <section style="display: flex; padding:.5rem;justify-content: space-between; align-items: center; margin:auto;width: 90%; position: relative;">
                        <section style="display: flex; align-items: center;">
                            <img src="<?php echo $profPicURL; ?>" class="ppImg" style="width: 3.5rem;
                                 margin-right: 3rem; aspect-ratio: 1/1; border-radius: 50%;">
                            <section style="position: relative;"><?php echo $fullName;?></section>
                        </section>
                        <!-- EDIT PROFILE BUTTON -->
                        <section id="editProfile" style="position: relative;" onclick="on()">Edit Profile</section>
                    </section>

                    <!-- EDIT PROFILE OVERLAY -->
                    <section id="overlay">
                        <h3 style="padding-left:2rem; padding-top:1rem; padding-bottom:0.5rem;">Edit Your Information:</h3>
                        <img src = "../public/assets/icons/light-x.svg" style="position: absolute; top: 1rem; right: 1rem; cursor: pointer;" onclick="off()">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <label for="name">Full Name: </label>
                            <input type="text" id="name" name="full_name"><br><br>

                            <label for="major">Major: </label>
                            <input type="text" id="major" name="major"><br><br>

                            <label for="year">Academic Year: </label>
                            <select id="year" name="academic_year">
                                <option value= null disabled selected></option>
                                <option value="1">Freshman</option>
                                <option value="2">Sophomore</option>
                                <option value="3">Junior</option>
                                <option value="4">Senior</option>
                                <option value="5">Graduate</option>
                                <option value="6">Professor</option>
                            </select><br><br>

                            <label for="gender">Gender: </label>
                            <select id="gender" name="gender">
                                <option value= null disabled selected></option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">non-binary</option>
                            </select><br><br>

                            <label for="profilePicture">Upload Profile Picture: </label>
                            <input type="file" id="profilePicture" name="profilePicture" accept="image/*"><br><br>

                            <label for="backgroundPicture">Upload Background Picture: </label>
                            <input type="file" id="backgroundPicture" name="backgroundPicture" accept="image/*"><br><br>

                            <button type="submit" class="search-button" style="float:right; margin-bottom:2rem;">Submit</button>
                        </form>
                    </section>

                    <!-- EMAIL -->
                    <section style=" padding-top:2rem;width:90%;position:relative; align-items: center; margin:auto; ">
                        <section style="font-size:1rem;font-weight:bold;">Email Address</section>
                        <p><hr style="width:100%; margin:auto;"></p>
                        <section style="margin-left:2rem; color:#999999;"><?php echo $email ?></section>
                    </section>

                    <!-- MAJOR -->
                    <section style=" padding-top:2rem;width:90%;position:relative; align-items: center; margin:auto; ">
                        <section style="font-size:1rem;font-weight:bold;">Major</section>
                        <p><hr style="width:100%; margin:auto;"></p>
                        <section style="margin-left:2rem; color:#999999;"><?php echo $major ?></section>
                    </section>

                    <!-- ACADEMIC YEAR -->
                    <section style=" padding-top:2rem;width:90%;position:relative; align-items: center; margin:auto; ">
                        <section style="font-size:1rem;font-weight:bold;">Academic Year</section>
                        <p><hr style="width:100%; margin:auto;"></p>
                        <section style="margin-left:2rem; color:#999999;"><?php echo $academic_year ?></section>
                    </section>

                    <!-- GENDER -->
                    <section style=" padding-top:2rem;width:90%;position:relative; align-items: center; margin:auto; ">
                        <section style="font-size:1rem;font-weight:bold;">Gender</section>
                        <p><hr style="width:100%; margin:auto;"></p>
                        <section style="margin-left:2rem; color:#999999;"><?php echo $gender ?></section>
                    </section>
                </div>

                </div><!-- DYNAMIC TAB BODY TEXT CLOSE-->

        </div>
    </div>
</div>

<!-- FOOTER -->
<?php include "../pages/footer.php"?>

<script>
    // tab slider script
    let tabHeader = document.getElementsByClassName("tab-header")[0];
    let tabIndicator = document.getElementsByClassName("tab-indicator")[0];
    let tabBody = document.getElementsByClassName("tab-body")[0];

    let tabsPane = tabHeader.getElementsByTagName("div");
    let savedTab = document.getElementById("saved");
    let settingsTab = document.getElementById("settings");

    for (let i = 0; i < tabsPane.length; i++) {
        tabsPane[i].addEventListener("click", function () {
            // Remove "active" class from the currently active tab
            tabHeader.getElementsByClassName("active")[0].classList.remove("active");
            tabsPane[i].classList.add("active");

            // Remove "active" class from the currently active tab body
            tabBody.getElementsByClassName("active")[0].classList.remove("active");
            tabBody.getElementsByTagName("div")[i].classList.add("active");

            // Move the tab indicator to the clicked tab
            tabIndicator.style.left = `calc(calc(100% / 3) * ${i})`;

            // Handle "saved" and "settings" tabs explicitly
            if (i === 1) {
                savedTab.classList.add("active");
                settingsTab.classList.remove("active");
            } else if (i === 2) {
                savedTab.classList.remove("active");
                settingsTab.classList.add("active");
            } else {
                settingsTab.classList.remove("active");
                savedTab.classList.remove("active");
            }
        });
    }


    // overlay script
    function on() {
        document.getElementById("overlay").style.display = "block";
    }
    function off() {
        document.getElementById("overlay").style.display = "none";

        // Reset form fields by setting their values to an empty string
        document.getElementById("name").value = null;
        document.getElementById("major").value = null;
        document.getElementById("year").value = null;
        document.getElementById("gender").value = null;
    }
</script>

</body>
</html>
