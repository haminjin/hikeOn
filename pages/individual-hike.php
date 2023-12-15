<?php include 'logged-in.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["login"]) === true) {

    $review = $_POST["review"];
    $currentHike = $_REQUEST["hikeid"];
    $stars = $_REQUEST["activeStarsCount"];

    $mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");
    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    $loginID = $_SESSION["email"];
    $query = "SELECT * FROM users WHERE userName = '$loginID'";
    $result = $mysql->query($query);
    while($currentrow = $result->fetch_assoc()) {
        $loginID = $currentrow["userID"];
    }



    $query = "INSERT INTO userReviews (comments, userID, hikeID, rating) VALUES ('$review', '$loginID', '$currentHike', '$stars');";
    $mysql->query($query);

    $mysql->close();
}


 ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>USC Hikes</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/typography.css" type="text/css">
    <link rel="stylesheet" href="../css/colors.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.1.0/dist/ol.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <script>
        function on() {
            document.getElementById("overlay").style.display = "block";
        }
        function off() {
            document.getElementById("overlay").style.display = "none";
        }
        function rateStars() {
            const stars = document.querySelectorAll(".stars i");
            const activeStarsInput = document.getElementById("activeStarsInput");

            stars.forEach((star, index1) => {
                star.addEventListener("click", () => {
                    let activeCount = 0; // Counter for active stars
                    stars.forEach((star, index2) => {
                        if (index1 >= index2) {
                            star.classList.add("active");
                            activeCount++;
                        } else {
                            star.classList.remove("active");
                        }
                    });

                    // Update the hidden input value
                    activeStarsInput.value = activeCount;

                    // Send activeCount to PHP using AJAX
                    sendStarsCountToPHP(activeCount);
                });
            });
        }

        function sendStarsCountToPHP(count) {
            // Make an AJAX request to pass the count to PHP
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    // Handle response if needed
                    // Maybe display a success message or do further actions
                }
            };

            // Prepare the POST request to send the count to PHP
            xhr.open("POST", "your_php_script.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("starsCount=" + count); // Send the active stars count as a parameter
        }
    </script>
    <style>
        body{
            background: var(--background, #FFFFFB);
        }
        .holder{
            padding: 0px 60px 0px 60px;
        }
        .divider{
            margin-top:5rem;
            margin-bottom:5rem;
            width: 100%;
            height: 1px;
            background: #999;
        }
        .individual-hero{
            display: flex;
            padding:48px;
            justify-content: center;
            align-items: flex-end;
            gap: 32px;
            flex-shrink: 0;
            align-self: stretch;
            border-radius: 20px;
            position:relative;
        }
        .icon{
            width: 20px;
        }
        .individual-title-holder{
            display: flex;
            flex-direction:row;
            justify-content: space-between;
            align-items: center;
            flex: 1 0 0;
            z-index:1;
        }
        .details-content{
            display: flex;
            align-items: flex-start;
            gap: 5rem;
            align-self: stretch;
            flex-direction:row;
        }
        .details-holder{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            align-self: stretch;
            padding-bottom:3rem;
        }
        .text-content{
            display: flex;
            flex-direction:row;
            align-items: flex-start;
            gap: 5rem;
            align-self: stretch;
        }
        .stars{
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .individual-hero-details{
            display: flex;
            width:90%;
            justify-content: space-between;
            align-items: flex-start;
        }
        .individual-hero-text{
            z-index:1;
            color:white;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .about-holder{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            align-self: stretch;
        }
        .text-content{
            display: flex;
            width: 627px;
            flex-direction: column;
            align-items: flex-start;
            gap: 64px;
        }
        .icon-text{
            display: flex;
            align-items: center;
            gap: 12px;
            width:12rem;
        }
        .review{
            max-width:50%;
            display: flex;
            padding: 24px 40px;
            align-items: flex-start;
            gap: 40px;
            flex: 1 0 0;
            border-radius: 20px;
            border: 1px solid #E5E5E5;
            background: #FFF;
        }
        .review-inner{

            display: flex;
            flex-direction: column;
            background-color:white;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            align-self: stretch;
        }
        .reviews-row{
            display: flex;
            align-items: flex-start;
            gap: 40px;
            align-self: stretch;
        }
        .review-criteria-holder{
            display:flex;
            width:100%;
            justify-content:space-between;
        }
        .reviewer{
            display: flex;
            align-items: center;
            flex-direction:row;
            gap: 8px;
            flex: 1 0 0;
        }
        .gradient{
            width: 100%;
            height:50%;
            position: absolute;
            left: -1px;
            bottom: 0px;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.00) 0%, #000 100%);
            z-index:0;
            border-radius:20px;
        }
        .info-holder{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            align-self: stretch;
        }
        .info-text{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 8px;
        }
        .info-content{
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .info-list{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 16px;
        }
        .reviews-holder{
        }
        .map-holder{
            border-radius:20px;
        }

        #map {
            width: 50vw;
            height:70vh;
            border-radius:20px;
        }
        .weather-icons{
            display: flex;
            align-items: center;
            gap: 8px;
            flex-direction:row;
        }
        .weather-content{
            margin-top:16px;
            display: flex;
            align-items: center;
            gap: 32px;
            flex-direction:row;
        }
        .weather-info{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            gap: 8px;
        }
        .temperature{
            display: flex;
            align-items: flex-start;
            gap: 16px;
            flex-direction:row;
        }
        .add-review-holder{
            display:flex;
            flex-direction:column;
        }
        .button-holder{
            width:20rem;
        }
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            right: 0;
            bottom: 0;
            top: 0;
            left: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 2;
            cursor: pointer;
        }
        .form-holder{
            display: inline-flex;
            padding: 5rem 5rem;
            position:relative;
            flex-direction: column;
            align-items: flex-start;
            gap: 2rem;
            border-radius: 20px;
            background: #FFF;
        }
        .form-labels{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            width:100%;
        }
        .text-box{
            border-radius: 4px;
            border: 1px solid var(--ui-border, #E5E5E5);
        }
        .share-field{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            width:100%;
        }
        .form{
        }
        .centered-form{
            width:100%;
            height:100%;
            display:flex;
            justify-content: center;
            align-items: center;
        }
        .stars{
            width:12rem;
        }
        .stars i {
            color: #e6e6e6;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .stars i.active {
            color: #FFE600;
        }
        @media screen and (max-width: 600px) {
            .holder{
                padding: 0px 20px 0px 20px;
            }
            .details-content{
                flex-direction:column;
            }
            .reviews-row{
                flex-direction:column;
            }
            #map{
                width: 30rem;
            }
            .about-holder{
                width:20rem;
            }
            .individual-title-holder{
                flex-direction:column;
                gap:2rem;
                align-items: flex-start;
            }
            .weather-content{
                flex-direction:column;
            }
            .form{
                width:80%;
            }
        }


    </style>
</head>
<body>

<?php

$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}
$sql = "SELECT * FROM mainView WHERE hikeID = " . $_REQUEST["hikeid"];
$result = $mysql->query($sql);
if ($result->num_rows > 0) {
while($currentrow = $result->fetch_assoc()) {
    $h_img = $currentrow["imageURL"];
    $h_name = $currentrow["name"];
    $h_desc = $currentrow["details"];
    $h_leng = $currentrow["length"];
    $h_dur = $currentrow["duration"];
    $h_diff = $currentrow["difficulty"];
    $h_lat = $currentrow["lattitude"];
    $h_long = $currentrow["longitude"];
}
}

?>

<script>
    function distance(lat1, lon1, lat2, lon2, unit) {
        if ((lat1 == lat2) && (lon1 == lon2)) {
            return 0;
        }
        else {
            var radlat1 = Math.PI * lat1/180;
            var radlat2 = Math.PI * lat2/180;
            var theta = lon1-lon2;
            var radtheta = Math.PI * theta/180;
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
                dist = 1;
            }
            dist = Math.acos(dist);
            dist = dist * 180/Math.PI;
            dist = dist * 60 * 1.1515;
            if (unit=="K") { dist = dist * 1.609344 }
            if (unit=="N") { dist = dist * 0.8684 }
            return dist;
        }
    }
</script>

<div>
    <!--php for sharing hike-->
    <?php
    require 'logged-in.php';
    if(!empty($_REQUEST["friend-email"]))
    {
        $message = "";
        // mail tag with variables plugged into mail command
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $domain = $_SERVER['HTTP_HOST'];
        $path = $_SERVER['REQUEST_URI'];
        $current_url = $protocol . "://" . $domain . $path;

        $to = $_REQUEST["friend-email"];
        $subject = "Let's go on a hike!";

        $message = "Hey there, ". $_REQUEST["friend-name"]. "!" ." A friend suggested you might like this hike: " . $current_url."<br><br>".". Their custom message: ".$_REQUEST["special-message"];
        $from = $_SESSION['email'];
        $headers = "From: $from";
        $test = mail($to,$subject,$message,$headers);
        // if you set a variable EQUAL to the mail command
        // then that variable "stores" the response from the php server
        if ($test==1)
        {
            echo "Mail sent to " . $_REQUEST["friend-email"];
            exit();
        }
    }
    ?>
    <div id="overlay">
        <div class="centered-form">
            <form action="" method="post" class="form">
                <div class="form-holder">
                    <img onclick="off()" style="position:absolute; top: 1rem; right: 1rem;" src="../public/assets/icons/light-x.svg">
                    <div class="form-labels">
                        <h2>Share this hike!</h2>
                        <text class ="copy1">Fill out this form to email this hike to a friend</text>
                    </div>
                    <div class="form-labels">
                        <text class ="caption1">Name of Friend</text>
                        <input type="text" class="share-field" name="friend-name">
                    </div>
                    <div class="form-labels">
                        <text class ="caption1">Friend's Email</text>
                        <input type="text" class="share-field" name="friend-email">
                    </div>
                    <div class="form-labels">
                        <text class ="caption1">Custom message</text>
                        <textarea type="text" name="special-message" style="min-width:100%; height:2rem; border-radius: 10px;"
                                  placeholder="Write a custom message.."></textarea>
                    </div>
                    <input type="submit" value="Submit" class="search-button" style="width:8rem">
                </div>
            </form>
        </div>
    </div>

    <!-- NAV -->
    <?php include "../pages/nav.php" ?>

<div class="holder">
    <div class="individual-hero" style="background-image: url('../public/assets/images/<?php echo $h_img?>'); height:60%;object-fit: fill;top:0; background-position:center;">
        <div class="individual-title-holder">

            <div class="individual-hero-text">
                <h3 style="line-height:0px" id="hike-name"><?php echo $h_name?></h3>
                <div class="individual-hero-details">
                    <div class="icon-text">
                        <img src="../public/assets/icons/road.svg" class="icon">
                        <text class="copy1"><script>document.write(distance(<?php echo $h_lat . ", " . -$h_long . ", 34.0224, 118.2851" ?>, "M").toFixed(1).toString());</script> miles from campus</text>
                    </div>
                </div>
            </div>

            <div class="button-holder">
                <button class="search-button" id="like-button">
                    <img src="../public/assets/icons/heart-empty.svg" id="like-unfilled" class="icon">
                    <span class="btn-text">Like</span>
                </button>
                <!--script for button liking-->
                <script>
                    const imageElement = document.getElementById('like-unfilled');
                    const changeButton = document.getElementById('like-button');
                    let hikeName = document.getElementById('hike-name').innerText;
                    console.log('Hike Name:', hikeName);
                    let likeStatus = 0;

                    function toggleLike() {

                        // Check if the user is logged in
                        const isLoggedIn = <?php echo isset($_SESSION['login']) && $_SESSION['login'] === true ? 'true' : 'false'; ?>;

                        if (!isLoggedIn) {
                            console.log('User is not logged in. Redirect to login page or show a message.');
                            return;
                        }

                        // Toggle the 'liked' class on the image element
                        if (likeStatus === 1) {
                            imageElement.classList.remove('liked');
                            imageElement.src = '../public/assets/icons/heart-empty.svg';
                            likeStatus = 0;
                        } else {
                            imageElement.classList.add('liked');
                            imageElement.src = '../public/assets/icons/heart-filled.svg';
                            likeStatus = 1;
                        }
                        console.log(likeStatus);

                        //javascript ==> php
                        fetch('like-feature.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json; charset=utf-8',
                            },
                            body: JSON.stringify({
                                hikeName: hikeName,
                                likeStatus: likeStatus,
                            }),
                        }).then(function(response){
                            return response.text();
                        }).then(function(data){
                            console.log(data);
                        });
                    }
                    changeButton.addEventListener('click', toggleLike);
                </script>

                <button class="search-button" onclick="on()">
                    <img src="../public/assets/icons/share.svg" class="icon">
                    <span class="btn-text">Share</span>
                </button>
            </div>
        </div>
        <div class="gradient">
        </div>
    </div>
    <div class="details-holder">
        <h1>Details</h1>
        <div class="details-content">
            <div class="text-content">
                <div class="about-holder">
                    <h2 style="line-height:1rem">About</h2>
                    <text class="copy1"><?php echo $h_desc?></text>
                </div>
                <div class="info-holder">
                    <h2 style="line-height:1rem">Information</h2>
                    <div class="info-list">
                        <div class="info-content">
                            <img src="../public/assets/icons/footprints.svg" class="icon">
                            <div class="info-text">
                                <text style="color:#999">Trail Length:</text>
                                <text><?php echo $h_leng;
                                if($h_leng > 1){
                                    echo " miles";
                                }
                                else{
                                    echo " mile";
                                }
                                ?></text>
                            </div>
                        </div>
                        <div class="info-content">
                            <img src="../public/assets/icons/mountains.svg" class="icon">
                            <div class="info-text">
                                <text style="color:#999">Elevation:</text>
                                <text><?php echo $h_dur;
                                    if($h_dur > 1){
                                        echo " hours";
                                    }
                                    else{
                                        echo " hour";
                                    }?></text>
                            </div>
                        </div>

                    </div>
                </div>
                <!--<div class="weather-holder">
                    <text class="caption1">Weather</text>
                    <div class="weather-content">
                        <div class="weather-icons">
                            <img src="../public/assets/icons/sun.svg" style="width:48px">
                            <text class="temperature-colored" style ="font-size:48px; color:#EE8100;">76°F</text>
                        </div>
                        <div class="weather-info">
                            <text class="copy1">Partly Cloudy</text>
                            <div class="temperature">
                                <text class="copy1">High: 76°F</text>
                                <text class="copy1">Low: 58°F</text>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="map-holder">
                <div id="map">
                    <script>
                        var latd = "<?php echo $h_lat; ?>";
                        var long = "<?php echo $h_lat; ?>";
                        var _coords = [{"lat":"<?php echo $h_lat; ?>","long":"<?php echo $h_long; ?>","name":"Watt Way, University Park, Los Angeles, Los Angeles County, California, 90089, United States"},{"lat":"<?php echo $h_lat; ?>","long":"<?php echo $h_long; ?>","name":"Watt Way, University Park, Los Angeles, Los Angeles County, California, 90089, United States"}];
                        var map;

                        function initMap() {
                            map = new ol.Map({
                                target: "map",
                                layers: [
                                    new ol.layer.Tile({
                                        source: new ol.source.OSM(),
                                    }),
                                ],
                                view: new ol.View({
                                    center: ol.proj.fromLonLat([long, latd]),
                                    zoom: 14,
                                    maxZoom: 18,
                                }),
                                overlay: [
                                    new ol.Overlay({
                                        element: container
                                    }),
                                ],
                            });
                        }

                        function addMarker(latd, long, name) {
                            var _feature = new ol.Feature({
                                geometry: new ol.geom.Point(ol.proj.fromLonLat([long, latd])),

                            });
                            _feature.set("Name", name);

                            var layer = new ol.layer.Vector({
                                source: new ol.source.Vector({
                                    features: [
                                        _feature,
                                    ],
                                }),
                            });
                            map.addLayer(layer);
                        }

                        if(_coords.length > 0){
                            var latd = _coords[0]["lat"], long = _coords[0]["long"];

                            // load and setup map layers
                            initMap();

                            // to set all the pins
                            for (let i = 0; i < _coords.length; i++) {
                                addMarker(_coords[i]["lat"], _coords[i]["long"], _coords[i]["name"]);
                            }

                            // for the popup box
                            var container = document.getElementById('popup');
                            var content = document.getElementById('popup-content');

                            var overlay = new ol.Overlay({
                                element: container,
                                autoPan: true,
                                autoPanAnimation: {
                                    duration: 250
                                }
                            });

                            map.addOverlay(overlay);

                            map.on('pointermove', function (event) {
                                const features = map.getFeaturesAtPixel(event.pixel);
                                if (features.length > 0) {
                                    var coordinate = event.coordinate;
                                    const name = features[0].get('Name');
                                    //simple text written in the popup, values are just of the second index
                                    content.innerHTML = '<br><b>Address: </b>'+name;//just the second one is getting displayed
                                    overlay.setPosition(coordinate);
                                }
                                else {
                                    // if there are no features on the hovered position then hide the popup box
                                    overlay.setPosition(undefined);
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    <div>
        <div>
            <div class = "ReviewForm"><h1>Reviews</h1></div>
            <br>
            <form action="individual-hike.php?hikeid=<?php echo $_REQUEST['hikeid']?>" method="post" class="add-review-holder">
                <br>
                <div class="review-criteria-holder">
                    <div class="stars" >
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <!-- Display the number of active stars -->
                    <input type="hidden" id="activeStarsInput" name="activeStarsCount" value="0">
                    <script>rateStars()</script>
                    <br>
                    <br>
                    <br>
                </div>
                <div>
                        <textarea type="text" name="review" style="min-width:100%; height:250px; border-radius: 10px;"
                                  placeholder=" Write a Review..."></textarea>
                </div>
                <br>
                <input type="submit" value="Submit" class="search-button" style="margin-top:20px;float:right;width:10rem">
                <br>
                <br>
            </form>
            <?php


            ?>
        </div>
    </div>
    <br>
    <br>
    <div class="reviews-holder">
        <?php
        $id = $_REQUEST['hikeid'];
        $mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");
        if ($mysql->connect_error) {
            die("Connection failed: " . $mysql->connect_error);
        }

        $sql = "SELECT * FROM userReviews WHERE hikeID = $id";
        $result = $mysql->query($sql);
        if ($result->num_rows > 0) {
        while($currentrow = $result->fetch_assoc()) {

            $currentUSER = $currentrow['userID'];
            $query = "SELECT * FROM users WHERE userID = $currentUSER";
            $result2 = $mysql->query($query);
            while($currentrow2 = $result2->fetch_assoc()) {
                $reviewUser = $currentrow2["userName"];
            }


            $newEcho = '<br><div class="reviews-row">
            <div class="review">
                <div class="review-inner">
                    <div class="reviewer">
                        <div class="profile">
                            <a href="' . $path .'">
                                <img src="' . $profPicURL . '" style="width:3rem; border-radius: 50%; aspect-ratio: 1/1;" class="ppImg">
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
        else{
            echo "no reviews";
        }

        ?>
    </div>
        <div class="divider"></div>
    <div class="recs-holder">
        <h1>Similar hikes</h1>
        <div class="browse">
            <div class="hike-row">
                <?php
                $mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");
                if ($mysql->connect_error) {
                    die("Connection failed: " . $mysql->connect_error);
                }
                $sql = "SELECT * FROM mainView";
                $result = $mysql->query($sql);
                if ($result->num_rows > 0) {
                    while($currentrow = $result->fetch_assoc()) {
                        // PHP logic
                        echo '
                            <div class="hike-individual">
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
                    echo "<div class='body'>0 results</div>";
                }

                ?>
            </div>
        </div>

    </div>
</div>
    <br>
    <br>

    <!-- FOOTER -->
    <?php include "../pages/footer.php"?>
</div>
<script>
    function checkLikeStatus(hikeName) {
        fetch('like-feature-check.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8',
            },
            body: JSON.stringify({ hikeName: hikeName }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.likeStatus === 1) {
                    imageElement.classList.add('liked');
                    imageElement.src = '../public/assets/icons/heart-filled.svg';
                    likeStatus = 1;
                } else if (data.likeStatus === 0) {
                    imageElement.classList.remove('liked');
                    imageElement.src = '../public/assets/icons/heart-empty.svg';
                    likeStatus = 0;
                }
            })
            .catch(error => {
                console.error('Error fetching like status: ', error);
            });
    }
    console.log(likeStatus);
    document.addEventListener('DOMContentLoaded', function () {
        checkLikeStatus(hikeName);
    });
</script>
</body>
</html>

