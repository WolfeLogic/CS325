<?php
require('helper/session_start.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Disease Information</title>
    <meta name="viewport" content="width=device-width, initialscale=1" />
    <meta name="author" content="zhuzhe" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>

    </style>
    
</head>

<body>
    <div id="navBar"></div>
    <?php include('display_navbar.php'); ?>

    <div class="container">
        
        <?PHP
            //echo 'Current PHP version: ' . phpversion(); // Super! 
			
			require('helper/sql_connect.php');
			
			if( isset($_GET['OrphaNumber']) && $_GET['OrphaNumber'] != "") {
				$sql = "SELECT * FROM `Disease` d WHERE";
				$sql .= " d.OrphaNumber=" . intval($_GET['OrphaNumber']);
                
                $result = $conn->query($sql);
                
                if ($result->num_rows == 1) {
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<h2 class='content-subhead'>" . $row["Name"] . "</h2>";
                        echo "<h3 class='chapter-head'>ORPHANUMBER: " . $row["OrphaNumber"] . "</h3>";

                        if ($row["SynonymList"] != "") {
                            echo "<div class='articleInfo'><h3>SynonymList:</h3>";
                            echo "<p>" . $row["SynonymList"] . "</p></div>";
                        }

                        if ($row["DiseaseDef"] != "") {
                            echo "<div class='articleInfo'><h3>Disease Definition:</h3>";
                            echo "<p>" . $row["DiseaseDef"] . "</p></div>";
                        }
                        
                    }
    
                } else {
                    echo "Found no entry - Incorrect OrphaNumber";
                }

			} else {
                echo "<h2 class='content-subhead'>Missing OrphaNumber</h2>";
            }
		
		?>
    </div>

    
</body>

</html>