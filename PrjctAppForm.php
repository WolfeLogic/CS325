<?php
require('helper/session_start.php');

// submitting a new project
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['projectTitle'])) {
        require 'helper/projectSubmit.php';
    }
}

// Check if user is logged in using the session variable
elseif ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE ) {
  $_SESSION['err_message'] = "You must log in before submitting a new project!";
  $_SESSION['err_redirect'] = "LoginRegistrationForm/loginRegister.php";
  header("location: error.php");
}
else {
    // get userID using the session variable
    $userID = $_SESSION['userID'];

    // get other user info from database
    require('helper/sql_connect.php');
    $getuser_result = $conn->query("SELECT * FROM User WHERE id='$userID'");

    // user does not exist - something wrong - Log out immediately
    if ( $getuser_result->num_rows != 1 ) {
        
        $_SESSION['err_message'] = 'User with this ID does not exist! Logging out';
        $_SESSION['err_redirect'] = "LoginRegistrationForm/logout.php";
        header("location: error.php");
    }
    
    else {
        $userRow = $getuser_result->fetch_assoc();
        $email = $userRow['email'];
        $fname = $userRow['fname'];
        $lname = $userRow['lname'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>Project Application Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Project Application Form" />
        <meta name="keywords" content="orphan disease crowd funded science" />
        <meta name="author" content="wolfedr, zhuzhe" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="helper/jquery.number.js"></script>
    </head>
    <body>
            <div id="navBar_RU"></div>
            <script>
                $("#navBar_RU").load("navBar_RU.html");
            </script>
            
            <div class="container">
                <!-- <div id="prjctApp" class="form"> -->
                <h2> Project Application </h2> 
                <h4> Applicant Name: <?php echo $fname.' '.$lname; ?></h4>
                <form action="PrjctAppForm.php" method="post" autocomplete="on">
                                
                        <div class="form-group"> 
                            <label for="prjcttitle">Project Title</label>
                            <input class="form-control" id="projectTitle" name="projectTitle" required="required" type="text" placeholder="No More Snail Fever!" />
                        </div>
                                <!--<p> -->
                                <!--    <label for="blurb" class="sblurb">Short blurb</label>-->
                                <!--    <textarea id="shortblurb" placeholder="A brief sense of what you're project will do" rows="4" cols="80"></textarea>-->
                                <!--</p>-->
                                <!--<p> -->
                                <!--    <label for="prjctlocation" class="plocation">Project location</label>-->
                                <!--    <input id="projectlocation" name="projectlocation" required="required" type="text" placeholder="Lauster Lab, Cambridge, MA" />-->
                                <!--</p>-->
                        <div class="form-group"> 
                            <label for="trgtdisease" class="pdisease">Target Disease (OrphaNumber required)</label>
                            <input class="form-control" id="targetDisease" name="targetDisease" required="required" type="number" min="1" placeholder="2118" />
                            <p><a href="search_results.php" target="_blank"><strong>Display All Orphan Diseases</strong></a></p>
                        </div>
                    
                        <div class="form-group"> 
                            <label for="descrpt" class="fdescript">Full Description</label>
                            <textarea class="form-control" id="fullDescription" name="fullDescription" required="required"
                                placeholder="Lay it all out there" rows="10" cols="80"></textarea>
                        </div>
                                <!--<p> -->
                                <!--    <label for="prjctduration" class="pduration">Project duration</label>-->
                                <!--    <input id="projectduration" name="projectduration" required="required" type="number" min="1" max="1000" placeholder="Days"/>-->
                                <!--</p>-->
                        <div class="form-group"> 
                            <label for="fundgol" class="fgoal">Funding Goal (in US Dollars)</label>
                            <input class="form-control" id="fundingGoal" name="fundingGoal" required="required" type="number" min="1000" max="1000000000" step="0.01"
                                placeholder="Between 1,000 and 1,000,000,000" />
                        </div>
                    
                        <input class="btn btn-primary" id="submitButton" type="submit" value="Submit"/> 
                                
                </form>
            </div>
    </body>
</html>