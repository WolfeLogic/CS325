<?php
require('helper/session_start.php');

// Check if user is logged in using the session variable
if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE ) {
    $_SESSION['err_message'] = "You must log in before viewing the SME Application!";
    $_SESSION['err_redirect'] = "LoginRegistrationForm/loginRegister.php";
    header("location: error.php");    
}
else {
    // get userID using the session variable
    $userID = $_SESSION['userID'];

    // get other user info from database
    require('helper/sql_connect.php');
    $getuser_result = $conn->query("SELECT * FROM User WHERE id='$userID'");

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
        $status = $userRow['status'];
    }
}

// For OSU PHP
ob_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>View SME Application</title>
    <meta name="viewport" content="width=device-width, initialscale=1" />
    <meta name="author" content="zhuzhe" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
    <div id="navBar_RU"></div>
        <script>
            $("#navBar_RU").load("navBar_RU.html");
        </script>

    <div class="container">
        
        <?PHP
			
			require('helper/sql_connect.php');
			
			// Check appID in URL
			if( isset($_GET['appID']) && $_GET['appID'] != "") {
				$smeapp_sql = "SELECT * FROM `SME_Application` a WHERE";
				$smeapp_sql .= " a.applicationID=" . intval($_GET['appID']);
                
                $result = $conn->query($smeapp_sql);
                
                // Check appID from database
                if ($result->num_rows == 1) {
                    
                    $row = $result->fetch_assoc();
                    
                    // Only the applicant himself/herself or the SysAdmin is permitted to access this page
                    $viewEligibility = FALSE;
                    
                    if ($status == 'sysadmin') {
                        $viewEligibility = TRUE;
                    }
                    else if ($status == 'ru' && $userID == $row['userID']) {
                        $viewEligibility = TRUE;
                    }
                    
                    if ($viewEligibility == FALSE) {
                        ob_end_clean();
                        $_SESSION['err_message'] = 'You do not have authority to view this SME application!';
                        $_SESSION['err_redirect'] = "myAccount.php";
                        header("location: error.php");
                        exit;
                    }
                    
                    // passed the eligibility test, proceed...
                    else {
                        echo "<h2 class='content-subhead'>Application ID: " . $row["applicationID"] . "</h2>";
                        
                        $user_sql = "SELECT * FROM `User` u WHERE";
						$user_sql .= " u.id=" . intval($row["userID"]);
						
						$user_result = $conn->query($user_sql);

                        if ($user_result->num_rows == 1) {
							while($user_row = $user_result->fetch_assoc()) {
								echo "<h3>Applicant</h3>";
								echo "<big>" . $user_row["fname"] . " " .
									$user_row["lname"] . " (UserID: " . $row["userID"] . ")</big>";
							}
                        }
                        
                        $disease_sql = "SELECT * FROM `Disease` d WHERE";
						$disease_sql .= " d.OrphaNumber=" . intval($row["expertise"]);
						
						$disease_result = $conn->query($disease_sql);

                        if ($disease_result->num_rows == 1) {
							while($disease_row = $disease_result->fetch_assoc()) {
								echo "<h3>Disease Expertise</h3>";
								echo "<big>" . $disease_row["Name"] . "<br />";
								echo "OrphaNumber: " . "<a href='Disease.php?OrphaNumber=" .
							        intval($row["expertise"]) . "'>" . $row["expertise"] . "</a></big>";
							}
                        }
                        
                        echo "<h3>Application Status</h3>";
						echo "<big>" . $row["applicationStatus"] . "</big>";
						
						if ($row["education"] != '') {
						    echo "<div class='articleInfo'><h3>Educational background</h3>";
						    echo "<p>" . nl2br($row["education"]) . "</p></div>";
						}
						
						if ($row["experience"] != '') {
						    echo "<div class='articleInfo'><h3>Professional experience</h3>";
						    echo "<p>" . nl2br($row["experience"]) . "</p></div>";
						}
						
						if ($row["ref"] != '') {
						    echo "<div class='articleInfo'><h3>References</h3>";
						    echo "<p>" . nl2br($row["ref"]) . "</p></div>";
						}
						
						echo "<div class='articleInfo'><h3>Reason for becoming an SME</h3>";
						echo "<p>" . nl2br($row["why"]) . "</p></div>";
                        
                    }
                }
                // No such appID in database
                else {
                    echo "<h2 class='content-subhead'>Found no entry - Incorrect applicationID</h2>";
                }

            // Missing appID in URL
			} else {
                echo "<h2 class='content-subhead'>Missing applicationID</h2>";
            }
        
            ob_end_flush();            
		?>
    </div>

</body>
</html>