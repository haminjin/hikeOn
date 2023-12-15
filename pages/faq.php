<?php session_start(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <title>FAQ Page</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link rel="stylesheet" href="../css/typography.css" type="text/css">
    <link rel="stylesheet" href="../css/colors.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .background {
            padding-bottom: 0;
        }
        .faq {
            position: relative;
            margin-left: 15%;
            margin-right:15%;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        dl {
            width: 100%;
        }

        .faq-question {
            font-weight: bold;
            background-color: #ffffff;
            border: 1px solid #E5E5E5;
            border-radius: .5rem;
            padding: 1%;
            height:1.2rem;
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.25);
        }

        .faq-question-click {
            min-height: 6rem;
        }

        .faq-question-click .faq-answer{
            visibility: visible;
        }

        .faq-answer {
            visibility:hidden;
            font-weight: normal;
        }


        dd {
            opacity:0;
            font-weight: normal;
            margin:0;
            background-color: #E5E5E5;
            border: 1px solid #E5E5E5;
            border-radius: 0 0 .5rem .5rem;
            padding: 2%;
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.25);
        }

        .highlight {
            background-color: #E5E5E5;
        }

        #show-hide {
            padding: 1rem;
            border-radius: 2rem;
            border: 1px solid var(--ui-border, #E5E5E5);
            background: white;
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.25);
        }

    </style>
</head>
<body>

<!-- NAV -->
<div class="main">
    <!-- Navigation -->
    <?php include "../pages/nav.php" ?>
</div>

<!-- PAGE CONTENT -->
<div class="faq" style="padding-bottom:13.5rem;">
    <!-- TITLE & BUTTONS -->
    <header style="display:flex; flex-direction:row; align-items: center;">
        <h3>Frequently Asked Questions</h3>
        <div id = "show-hide" class="filterButton">Show All</div>
    </header>

    <!-- QUESTIONS & ANSWERS -->
    <dl>
        <div class="faq-question"><strong>Q: What is "Hike On!"?</strong>
            <div class="faq-answer"><br>
                A: Hike On! is a website targeted towards USC students providing them with an easier, more efficient way to
                find hiking trails within a 3 hour drive from campus. We have multiple filters allowing students to sort through
                hikes and view reviews from their peers to ensure they find their perfect hike!
            </div>
        </div>

        <br><br>

        <div class="faq-question"><strong>Q: How can I meet other people to hike with?</strong>
            <div class="faq-answer"><br>
                A: We have a "Groups" page on our website where you can join various hiking groups and meet other students
                to coordinate trips to each trail.
            </div>
        </div>

        <br><br>

        <div class="faq-question"><strong>Q: What information does Hike On! provide for each hike?</strong>
            <div class="faq-answer"><br>
                A: On each individual hike page, we provide you with some information about the trail, the trail length,
                elevation, the current weather at that location, and various reviews from other students who have completed
                the hike.
            </div>
        </div>

        <br><br>

        <div class="faq-question"><strong>Q: Is there an option to save hikes for the future?</strong>
            <div class="faq-answer"><br>
                A: Yes! Once you open up an individual hike page, you have the ability to "like" a hike. You can then view
                all the hikes you have liked and saved for later on your Profile page. We also have a feature where you
                can view all your completed hikes on your Profile page.
            </div>
        </div>

    </dl>

</div>

<?php include "../pages/footer.php"?>

<script>
    $(".faq-question").hover(function() {
        $(this).toggleClass("highlight");
    });

    $(".faq-question").click(function() {
        $(this).toggleClass("faq-question-click");
    });

    $("#show-hide").click(function() {
        if ($(".faq-question-click:visible").length > 0) {
            // if any are visible, hide all
            $(".faq-question-click").removeClass("faq-question-click");
            $("#show-hide").html("Show All");
        } else {
            // show all if none are visible
            $(".faq-question").addClass("faq-question-click");
            $("#show-hide").html("Hide All");
        }
    });

</script>


</body>
</html>

