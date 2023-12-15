<?php
include 'logged-in.php';
session_start();
$mysql = new mysqli("webdev.iyaserver.com", "haminjin_guest", "DevIIHikeOn123", "haminjin_hikeOn");

if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Meet the Team</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/typography.css" type="text/css">
    <link rel="stylesheet" href="../css/colors.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">

    <style>
        .image-container {
            width:800px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            max-width: 800px;
            margin: auto;
            gap: 20px;
        }

        .circle-image {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            margin: 10px; /* Adjust margin as needed */
            overflow: hidden;
            border: 2px solid #333; /* Add border styling */
        }

        .circle-image img {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .background {
            background-image: url('../public/assets/hero-background.png');
            height:90%;
        }


        .peopleContainer {
            width: 700px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            position: relative;
            margin: auto;
        }

        .nameContainer1 {
            width: 700px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40px;
            position: absolute;
            top: 180;
            gap: 65px;
        }
        .nameContainer2 {
            width: 700px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40px;
            margin:auto;
            gap: 65px;
        }

        .name {
            width:170px;
            height:40px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }

        .aboutTeam {
            width: 1000px;
            height: 230px;
            margin: auto;
            margin-top: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

    </style>

</head>
<body>

<div class="background">
    <?php include "../pages/nav.php" ?>
    <div class="headline">
        <text class="title">Meet the USC Hikes Team!</text>
        <text class="copy1"></text>
    </div>

    <div class="peopleContainer">
        <div class= "image-container">
            <img src="../public/assets/images/Hamin.png" class="circle-image">
            <img src="../public/assets/images/Joey.png" class="circle-image">
            <img src="../public/assets/images/jaden.png" class="circle-image">
            <div class="nameContainer1">
                <div class="name">Hamin</div>
                <div class="name">Joey</div>
                <div class="name">Jaden</div>
            </div>
            <img src="../public/assets/images/lindsey.png" class="circle-image">
            <img src="../public/assets/images/BJ.png" class="circle-image">
            <img src="../public/assets/images/arya.png" class="circle-image">
        </div>
    </div>
        <div class="nameContainer2">
            <div class="name">Lindsey</div>
            <div class="name">Byeongjun</div>
            <div class="name">Arya</div>
        </div>

</div>

<div class="aboutTeam">

    <p>Hike On is dedicated to showcasing hikes near the USC campus and we hope that is serves as a resource for students seeking an escape from the academic hustle and bustle. We hope that USC students, immersed in a dynamic urban environment, can use this platform to discover new ways to connect with nature, fostering a sense of well-being, stress relief, and a connection with fellow outdoorsy Trojans. We built this website with the goal that it would not only promote physical activity but also encourage a vibrant community of outdoor enthusiasts within the USC student body. The platform can serve as a hub for sharing hiking experiences, forming hiking groups, and fostering a deeper appreciation for the natural beauty surrounding the campus, contributing to a better, more balanced student lifestyle.</p>

    <p>This website was created by 6 members of the Fall 2023 ACAD 276 class. Despite the challenges we encountered, the team at Hike really enjoyed building this website and using all of the new skills we learned throughout taking Dev 2. Now Hike on is yours to explore, so have fun and get outside Trojans!</p>
</div>


<?php include "../pages/footer.php"?>

</body>
</html>
