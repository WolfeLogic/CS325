<?php
require('helper/session_start.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initialscale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        
        .image-rounded{
            height: 345px;
            width: 345px;
        }

        .titleText {
            text-align: center;
            text-decoration: underline;
        }

        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: auto;
            height: 500px;
            max-height: 500px;
            margin: auto;
        }

    </style>
    <title>Home Page</title>
</head>

<body>
    <div id="navBar"></div>
    <?php require('display_navbar.php'); ?>

    <div class ="titleText">
        <H1> Direct Scientific Funding of Orphan Diseases </H1>
    </div>
    <div class="container text-center">
        <div id="myCarousel" class="carousel slide>">
            <ol class="carousel-indicators">
                <li class="item1 active"></li>
                <li class="item2"></li>
                <li class="item3"></li>
                <li class="item4"></li>
                <li class="item5"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="http://crtv.cm/cont/noticias/imagePot/NeglectedTropicalDiseases.jpg" class="img-rounded img-responsive"
                        alt="Image 1">
                </div>
                <div class="item">
                    <img src="LoginRegistrationForm/images/banner.jpg" class="img-rounded img-responsive"
                        alt="Image 2">
                </div>
                <div class="item">
                    <img src="http://www.lifewithdogs.tv/wp-content/uploads/2015/03/3.27.15-Cutest-Doggie-Sleepovers18.jpg" class="img-rounded img-responsive"
                        alt="Image 3">
                </div>
                <div class="item">
                    <img src="https://i.imgflip.com/114ygb.jpg" class="img-rounded img-responsive" alt="Image 4">
                </div>
                <div class="item">
                    <img src="https://i.ytimg.com/vi/mj-oStptqsg/maxresdefault.jpg" class="img-rounded img-responsive" alt="Image 5">
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <h2>Orphan Diseases</h2>
        <p>Donate money to help fund research.</p>
        <p><a href="search_results.php"><strong>Display All Orphan Diseases</strong></a></p>
        <form action="search_results.php" method="get">
            Search Diseases:
            <input type="text" name="disease">
            <br>
            <input type="submit" value="Search">
        </form>
    </div>

    <script>

            $(document).ready(function(){
                // Activate Carousel
                $("#myCarousel").carousel({interval: 2500});
                
                // Enable Carousel Indicators
                $(".item1").click(function(){
                    $("#myCarousel").carousel(0);
                });
                $(".item2").click(function(){
                    $("#myCarousel").carousel(1);
                });
                $(".item3").click(function(){
                    $("#myCarousel").carousel(2);
                });
                $(".item4").click(function(){
                    $("#myCarousel").carousel(3);
                });
                $(".item5").click(function(){
                    $("#myCarousel").carousel(4);
                });
            });
    </script>

</body>

</html>