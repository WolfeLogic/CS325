<?php
require('helper/session_start.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Project Information</title>
    <meta name="viewport" content="width=device-width, initialscale=1" />
    <meta name="author" content="zhuzhe" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
    <div id="navBar"></div>
    <?php include('display_navbar.php'); ?>

    <div class="container">
        
        <?PHP
            //echo 'Current PHP version: ' . phpversion();
			
			require('helper/sql_connect.php');
			
			if( isset($_GET['id']) && $_GET['id'] != "") {
				$proj_sql = "SELECT * FROM `Project` p WHERE";
				$proj_sql .= " p.projID=" . intval($_GET['id']);
                
                $result = $conn->query($proj_sql);
                
                if ($result->num_rows == 1) {
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<h2 class='content-subhead'>" . $row["projName"] . "</h2>";
                        
                        
                        echo "<h3>Project ID</h3>";
                        echo "<big>" . $row["projID"] . "</big>";
                        
                        $disease_sql = "SELECT * FROM `Disease` d WHERE";
						$disease_sql .= " d.OrphaNumber=" . intval($row["targetDisease"]);
						
						$disease_result = $conn->query($disease_sql);

                        if ($disease_result->num_rows == 1) {
							while($disease_row = $disease_result->fetch_assoc()) {
								echo "<h3>Target Disease</h3>";
								echo "<big>" . $disease_row["Name"] . "<br />";
								echo "OrphaNumber: " . "<a href='Disease.php?OrphaNumber=" .
							        intval($row["targetDisease"]) . "'>" . $row["targetDisease"] . "</a></big>";
							}
                        }
						
						$user_sql = "SELECT * FROM `User` u WHERE";
						$user_sql .= " u.id=" . intval($row["creator"]);
						
						$user_result = $conn->query($user_sql);

                        if ($user_result->num_rows == 1) {
							while($user_row = $user_result->fetch_assoc()) {
								echo "<h3>Creator</h3>";
								echo "<big>" . $user_row["fname"] . " " .
									$user_row["lname"] . " (UserID: " . $row["creator"] . ")</big>";
							}
                        }
						
						echo "<h3>Fund Goal</h3><big>US$ " . $row["goal"] . "</big>";
						echo "<h3>Contributions</h3><big>US$ " . $row["contributions"] . "</big>";
						echo "<h3>Status</h3><big>" . $row["status"] . "</big>";

                        if ($row["description"] != "") {
                            echo "<div class='articleInfo'><h3>Project Description</h3>";
                            echo "<p>" . nl2br($row["description"]) . "</p></div>";
                        }
                        
                    }
    
                } else {
                    echo "<h2 class='content-subhead'>Found no entry - Incorrect ProjectID</h2>";
                }

			} else {
                echo "<h2 class='content-subhead'>Missing ProjectID</h2>";
            }
		
		?>
    </div>

    
</body>

</html>