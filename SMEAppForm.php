<?php
require('helper/session_start.php');
require('helper/statusText.php');

// submitting a new SME application
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['expertise'])) {
        require 'helper/SMEAppSubmit.php';
    }
}

// Check if user is logged in using the session variable
elseif ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE ) {
  $_SESSION['err_message'] = "You must log in before submitting a new SME application!";
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
    
    // get user info
    else {
        $userRow = $getuser_result->fetch_assoc();
        $email = $userRow['email'];
        $fname = $userRow['fname'];
        $lname = $userRow['lname'];
        $status = $userRow['status'];
        $status_text = statusText($status);
        
        // check if user status is not 'ru'
        if ( $status != 'ru') {
            $_SESSION['err_message'] = 'You are a " . $status_text . " who is ineligible for applying for SME status!';
            $_SESSION['err_redirect'] = "myAccount.php";
            header("location: error.php");
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
        <title>SME Application Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="SME Application Form" />
        <meta name="keywords" content="orphan disease crowd funded science" />
        <meta name="author" content="wolfedr, zhuzhe" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div id="navBar_RU"></div>
            <script>
                $("#navBar_RU").load("navBar_RU.html");
            </script>
        
        <div class="container">
            <h2> Apply to Become a Subject Matter Expert (SME) </h2>
            <h4> Applicant Name: <?php echo $fname.' '.$lname; ?></h4>
            
            <form action="SMEAppForm.php" method="post" autocomplete="on">
                
                <div class="form-group">
                    <label for="dxprt" class="dexpert">Primary disease expertise (OrphaNumber required)</label>
                    <input class="form-control" id="expertise" name="expertise" required="required"
                        type="number" min="1" placeholder="2118" />
                    <p><a href="search_results.php" target="_blank"><strong>Display All Orphan Diseases</strong></a></p>
                </div>
                                
                <div class="form-group">
                    <label for="edubckgnd" class="edbackground">Educational background (Optional)</label>
                    <textarea class="form-control" id="education" name="education"
                        placeholder="Degrees held, from when, and where" rows="4" cols="80"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="profbckgnd" class="pbackground">Professional experience (Optional)</label>
                    <textarea class="form-control" id="experience" name="experience"
                        placeholder="Where you've worked and for how long" rows="4" cols="80"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="ref" class="references">References (Optional)</label>
                    <textarea class="form-control" id="references" name="references"
                        placeholder="With whom you've worked and for how long" rows="4" cols="80"></textarea>
                </div>
                
                <!--
                                <p> 
                                    <label for="perref" class="perreferences">Personal references</label>
                                    <br>
                                    <textarea id="personalreferences" placeholder="Character references and for how long you've known them" rows="4" cols="80"></textarea> 
                                </p>
                -->
                <div class="form-group"> 
                    <label for="ysme" class="ywantsme">Why you want to become an SME</label>
                    <textarea class="form-control" id="reason" name="reason" required="required"
                        placeholder="Tell us why this is important to you" rows="6" cols="80"></textarea>
                </div>
                
                <input class="btn btn-primary" id="submitSMEAppButton" type="submit" value="Submit"/>
            
            </form>
        </div>
    </body>
</html>