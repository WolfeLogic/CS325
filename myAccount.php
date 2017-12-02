<?php
/* Displays user information*/
require('helper/session_start.php');
require('helper/statusText.php');

// Check if user is logged in using the session variable
if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != TRUE ) {
  $_SESSION['err_message'] = "You must log in before viewing your profile page!";
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
        $status_text = statusText($status);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Account: <?= $fname.' '.$lname ?></title>
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

        <h1>My Account</h1>
                    
        <h3>Full Name: <?php echo $fname.' '.$lname; ?></h3>
        <h3>UserID: <?php echo $userID; ?></h3>
        <h3>Email: <?= $email ?></h3>
        <h3>User Status: <?=$status_text ?> <br />
            <?php
                if ($status=='ru') {
                    // Check if the RU has a submitted SME Application
                    $getSMEApp_result = $conn->query("SELECT * FROM SME_Application WHERE userID='$userID'");
                    
                    $hasSubmittedSMEApp = 0;
                    $applicationID = -1;
                    
                    if ( $getSMEApp_result->num_rows != 0 ) {
                        // SME Application(s) exist
                        // Note: Allow only ONE SME application with stutas "submitted" & ZERO application with status "approved" for RU
                        while($SMEAppRow = $getSMEApp_result->fetch_assoc()) {
                            if ($SMEAppRow['applicationStatus'] == 'submitted' || $SMEAppRow['applicationStatus'] == 'approved') {
                                $hasSubmittedSMEApp = 1;
                                $applicationID = $SMEAppRow['applicationID'];
                                break;
                            }
                        }
                    }
                    
                    if ($hasSubmittedSMEApp == 1) {
                        echo "<a href='ViewSMEApp.php?appID=$applicationID'><button class='btn btn-success'>View My Submitted SME Application</button></a>";
                    }
                    else {
                        echo "<a href='SMEAppForm.php'><button class='btn btn-primary'>Apply to Become a Subject Matter Expert (SME)</button></a>";
                    }
                }
            ?>
        </h3>
          
        <div class="container">
        
		<h3 class='content-subhead'>My Projects</h2>
		
		
        <?PHP
            
			$myProjSQL = "SELECT * FROM `Project` p WHERE";
			$myProjSQL .= " p.creator = " . $userID;
            			
			$result = $conn->query($myProjSQL);
			
			if ($result->num_rows > 0) {
                $row_cnt = $result->num_rows;
                echo "<h4 class='chapter-head'>Number of Projects: " . $row_cnt . "<br><br>";
                
                echo "<a href='PrjctAppForm.php'><button class='btn btn-primary'>Submit a new project</button></a><br><br>";
                
			    echo "<table class='table table-bordered table-hover table-responsive'>";	# start new table
			    echo "<thead><tr><th>Project ID</th><th>Title</th><th>Target Disease (OrphaNumber)</th>" .
					"<th>Fund Goal</th><th>Contributions</th><th>Status</th></tr></thead>";	# table header	
			    echo "<tbody>";	# table body
			    while($row = $result->fetch_assoc()) {
				    echo "<tr><td><a href='Project.php?id=" . $row["projID"] . "'>" . $row["projID"] . "</td><td>" . $row["projName"] .
				        "</td><td><a href='Disease.php?OrphaNumber=" . $row["targetDisease"] . "'>" . $row["targetDisease"] . "</a></td>" .
						"<td>" . $row["goal"] . "</td><td>" . $row["contributions"] . "</td><td>" . $row["status"] . "</td>";
			    }
			    echo "</tbody></table>";

		    } else {
			    echo "<h4 class='chapter-head'>Found no entry.<br><br>";
			    echo "<a href='PrjctAppForm.php'><button class='btn btn-primary'>Submit a new project</button></a>";
		    }
		
		?>
		
    </div>

    </div>

</body>
</html>